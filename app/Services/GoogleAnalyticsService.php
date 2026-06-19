<?php

namespace App\Services;

use Google\Analytics\Data\V1beta\Client\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\DateRange;
use Google\Analytics\Data\V1beta\Dimension;
use Google\Analytics\Data\V1beta\Metric;
use Google\Analytics\Data\V1beta\OrderBy;
use Google\Analytics\Data\V1beta\OrderBy\DimensionOrderBy;
use Google\Analytics\Data\V1beta\RunReportRequest;
use Google\Auth\HttpHandler\HttpHandlerFactory;
use GuzzleHttp\Client as GuzzleClient;
use Exception;
use Illuminate\Support\Facades\Log;

class GoogleAnalyticsService
{
    protected ?BetaAnalyticsDataClient $client = null;
    protected ?string $propertyId = null;
    protected bool $isConfigured = false;
    protected ?string $configError = null;

    public function __construct()
    {
        $this->propertyId = config('services.google_analytics.property_id');
        $credentialsJson = config('services.google_analytics.credentials_json');
        $credentialsPath = config('services.google_analytics.credentials_json_path');

        if (empty($this->propertyId)) {
            $this->configError = 'GA_PROPERTY_ID is not configured in the .env file';
            return;
        }

        try {
            $options = [];
            if (!empty($credentialsJson)) {
                $credentials = json_decode($credentialsJson, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new Exception('GA_CREDENTIALS_JSON in .env is invalid (must be a valid JSON string)');
                }
                $options['credentials'] = $credentials;
            } elseif (!empty($credentialsPath)) {
                $fullPath = base_path($credentialsPath);
                if (file_exists($fullPath)) {
                    $options['credentials'] = $fullPath;
                } else {
                    // Try checking as an absolute path
                    if (file_exists($credentialsPath)) {
                        $options['credentials'] = $credentialsPath;
                    } else {
                        throw new Exception("Credentials file not found at path: {$credentialsPath}");
                    }
                }
            } else {
                throw new Exception('Google Analytics credentials are not configured (use GA_CREDENTIALS_JSON or GA_CREDENTIALS_JSON_PATH)');
            }

            // Automatically disable SSL certificate verification if ssl_verify is set to false
            if (config('services.google_analytics.ssl_verify') === false) {
                $guzzleClient = new GuzzleClient(['verify' => false]);
                $httpHandler = [HttpHandlerFactory::build($guzzleClient), 'async'];
                $options['transportConfig'] = [
                    'rest' => [
                        'httpHandler' => $httpHandler,
                    ]
                ];
            }

            $this->client = new BetaAnalyticsDataClient($options);
            $this->isConfigured = true;
        } catch (Exception $e) {
            $this->configError = $e->getMessage();
            Log::error('GoogleAnalyticsService Initialization Failed: ' . $e->getMessage());
        }
    }

    /**
     * Check if the service has been configured successfully.
     */
    public function isConfigured(): bool
    {
        return $this->isConfigured;
    }

    /**
     * Get configuration error message (if any).
     */
    public function getConfigError(): ?string
    {
        return $this->configError;
    }

    /**
     * Get overview metrics (Active Users, Sessions, Views, Avg Engagement Time).
     */
    public function getOverviewStats(string $startDate, string $endDate): array
    {
        if (!$this->isConfigured) {
            return $this->getDefaultOverviewData();
        }

        try {
            $response = $this->client->runReport(new RunReportRequest([
                'property' => 'properties/' . $this->propertyId,
                'date_ranges' => [
                    new DateRange([
                        'start_date' => $startDate,
                        'end_date' => $endDate,
                    ]),
                ],
                'metrics' => [
                    new Metric(['name' => 'activeUsers']),
                    new Metric(['name' => 'sessions']),
                    new Metric(['name' => 'screenPageViews']),
                    new Metric(['name' => 'averageSessionDuration']),
                ],
            ]));

            $rows = $response->getRows();
            if (count($rows) > 0) {
                $values = $rows[0]->getMetricValues();
                return [
                    'activeUsers' => (int) $values[0]->getValue(),
                    'sessions' => (int) $values[1]->getValue(),
                    'screenPageViews' => (int) $values[2]->getValue(),
                    'averageSessionDuration' => $this->formatDuration((float) $values[3]->getValue()),
                ];
            }
        } catch (Exception $e) {
            Log::error('GA Overview Stats Error: ' . $e->getMessage());
        }

        return $this->getDefaultOverviewData();
    }

    /**
     * Get daily trend data for the chart.
     */
    public function getDailyTrend(string $startDate, string $endDate, string $metricName): array
    {
        if (!$this->isConfigured) {
            return [];
        }

        try {
            $response = $this->client->runReport(new RunReportRequest([
                'property' => 'properties/' . $this->propertyId,
                'date_ranges' => [
                    new DateRange([
                        'start_date' => $startDate,
                        'end_date' => $endDate,
                    ]),
                ],
                'dimensions' => [
                    new Dimension(['name' => 'date']),
                ],
                'metrics' => [
                    new Metric(['name' => $metricName]),
                ],
                'order_bys' => [
                    new OrderBy([
                        'dimension' => new DimensionOrderBy([
                            'dimension_name' => 'date',
                            'order_type' => DimensionOrderBy\OrderType::ALPHANUMERIC,
                        ]),
                        'desc' => false,
                    ]),
                ],
            ]));

            $trendData = [];
            foreach ($response->getRows() as $row) {
                $dateStr = $row->getDimensionValues()[0]->getValue(); // Format YYYYMMDD
                $formattedDate = sprintf('%s/%s', substr($dateStr, 6, 2), substr($dateStr, 4, 2)); // DD/MM
                $val = (int) $row->getMetricValues()[0]->getValue();

                $trendData[$formattedDate] = $val;
            }

            return $trendData;
        } catch (Exception $e) {
            Log::error("GA Daily Trend Error ({$metricName}): " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get breakdown data for specific dimensions (e.g., Top Pages, Top Countries, Top Devices).
     */
    public function getDimensionBreakdown(string $startDate, string $endDate, string $dimensionName, string $metricName, int $limit = 7): array
    {
        if (!$this->isConfigured) {
            return [];
        }

        try {
            $response = $this->client->runReport(new RunReportRequest([
                'property' => 'properties/' . $this->propertyId,
                'date_ranges' => [
                    new DateRange([
                        'start_date' => $startDate,
                        'end_date' => $endDate,
                    ]),
                ],
                'dimensions' => [
                    new Dimension(['name' => $dimensionName]),
                ],
                'metrics' => [
                    new Metric(['name' => $metricName]),
                ],
                'limit' => $limit,
            ]));

            $breakdown = [];
            foreach ($response->getRows() as $row) {
                $label = $row->getDimensionValues()[0]->getValue();
                $value = (int) $row->getMetricValues()[0]->getValue();
                
                // Truncate labels if they are too long (e.g., long page paths or titles)
                if (strlen($label) > 60) {
                    $label = substr($label, 0, 57) . '...';
                }

                $breakdown[] = [
                    'label' => $label ?: '(Unknown)',
                    'value' => $value,
                ];
            }

            return $breakdown;
        } catch (Exception $e) {
            Log::error("GA Dimension Breakdown Error ({$dimensionName}): " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get default overview stats when GA is not configured or an error occurs.
     */
    protected function getDefaultOverviewData(): array
    {
        return [
            'activeUsers' => 0,
            'sessions' => 0,
            'screenPageViews' => 0,
            'averageSessionDuration' => '0s',
        ];
    }

    /**
     * Format seconds into a human-readable duration (e.g., minutes and seconds).
     */
    protected function formatDuration(float $seconds): string
    {
        if ($seconds < 60) {
            return round($seconds) . 's';
        }
        $minutes = floor($seconds / 60);
        $remainingSeconds = round($seconds % 60);
        return "{$minutes}m {$remainingSeconds}s";
    }
}
