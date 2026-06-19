<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateActivityLogGuard extends Command
{
    protected $signature = 'activity-log:update-guard
                            {--dry-run : Chỉ hiển thị số lượng bản ghi sẽ được cập nhật}
                            {--show-unknown : Hiển thị chi tiết các record unknown}
                            {--export-unknown= : Export unknown records ra file CSV}
                            {--chunk=100 : Xử lý theo chunk}';

    protected $description = 'Cập nhật guard và causer cho activity log';

    public function handle()
    {
        $dryRun = $this->option('dry-run');
        $showUnknown = $this->option('show-unknown');
        $exportUnknown = $this->option('export-unknown');
        $chunkSize = (int) $this->option('chunk');

        $this->info('Bắt đầu cập nhật guard và causer cho activity_log...');

        // Define the tables and column structure
        $tables = [
            'cgo_users' => [
                'guard' => 'cgo',
                'model' => 'App\\Models\\CGOUser', // Or the corresponding model class
                'has_full_name' => $this->checkColumnExists('cgo_users', 'full_name'),
                'has_first_name' => $this->checkColumnExists('cgo_users', 'first_name') || $this->checkColumnExists('cgo_users', 'firstname'),
                'has_last_name' => $this->checkColumnExists('cgo_users', 'last_name') || $this->checkColumnExists('cgo_users', 'lastname'),
                'first_name_col' => $this->getFirstNameColumn('cgo_users'),
                'last_name_col' => $this->getLastNameColumn('cgo_users'),
            ],
            'company_recruiters' => [
                'guard' => 'company',
                'model' => 'App\\Models\\CompanyRecruiter',
                'has_full_name' => $this->checkColumnExists('company_recruiters', 'full_name'),
                'has_first_name' => $this->checkColumnExists('company_recruiters', 'first_name') || $this->checkColumnExists('company_recruiters', 'firstname'),
                'has_last_name' => $this->checkColumnExists('company_recruiters', 'last_name') || $this->checkColumnExists('company_recruiters', 'lastname'),
                'first_name_col' => $this->getFirstNameColumn('company_recruiters'),
                'last_name_col' => $this->getLastNameColumn('company_recruiters'),
            ],
            'trainee_users' => [
                'guard' => 'trainee',
                'model' => 'App\\Models\\TraineeUser',
                'has_full_name' => $this->checkColumnExists('trainee_users', 'full_name'),
                'has_first_name' => $this->checkColumnExists('trainee_users', 'first_name') || $this->checkColumnExists('trainee_users', 'firstname'),
                'has_last_name' => $this->checkColumnExists('trainee_users', 'last_name') || $this->checkColumnExists('trainee_users', 'lastname'),
                'first_name_col' => $this->getFirstNameColumn('trainee_users'),
                'last_name_col' => $this->getLastNameColumn('trainee_users'),
            ],
            'admin_users' => [
                'guard' => 'admin',
                'model' => 'App\\Models\\AdminUser',
                'has_full_name' => $this->checkColumnExists('admin_users', 'full_name'),
                'has_first_name' => $this->checkColumnExists('admin_users', 'first_name') || $this->checkColumnExists('admin_users', 'firstname'),
                'has_last_name' => $this->checkColumnExists('admin_users', 'last_name') || $this->checkColumnExists('admin_users', 'lastname'),
                'first_name_col' => $this->getFirstNameColumn('admin_users'),
                'last_name_col' => $this->getLastNameColumn('admin_users'),
            ],
        ];

        // Remove tables that do not exist
        $tables = array_filter($tables, function($info, $tableName) {
            if (!Schema::hasTable($tableName)) {
                $this->warn("Không tìm thấy bảng: {$tableName}");
                return false;
            }
            return true;
        }, ARRAY_FILTER_USE_BOTH);

        if (empty($tables)) {
            $this->error('Không tìm thấy bảng người dùng nào!');
            return 1;
        }

        // Display the table structure information
        $this->info("\nCấu trúc các bảng:");
        foreach ($tables as $tableName => $info) {
            $cols = [];
            if ($info['has_full_name']) {
                $cols[] = 'full_name';
            }
            if ($info['has_first_name'] && $info['has_last_name']) {
                $cols[] = $info['first_name_col'] . ' + ' . $info['last_name_col'];
            }
            $this->line("  - {$tableName} (" . $info['guard'] . "): " . implode(', ', $cols));
        }

        // Get all logs that need processing
        $logs = DB::table('activity_log')
            ->where('log_name', 'Access')
            ->where(function($query) {
                $query->whereNull('causer_id')
                    ->orWhere('causer_id', 0)
                    ->orWhereNull('properties')
                    ->orWhere('properties', 'not like', '%"guard"%');
            })
            ->get();

        $this->info("\nTìm thấy " . count($logs) . " bản ghi cần xử lý");

        if ($dryRun || $showUnknown || $exportUnknown) {
            $this->warn('=== DRY RUN MODE - Sẽ không có thay đổi thực tế ===');

            // Collect detailed information about the records
            $details = $this->getDetailedStats($logs, $tables);

            // Display the aggregated stats
            $stats = [];
            foreach ($details['guards'] as $guard => $count) {
                $stats[] = [$guard, $count];
            }
            $this->table(['Guard', 'Số lượng'], $stats);

            // Display unknown record details if requested
            if ($showUnknown && !empty($details['unknown_records'])) {
                $this->info("\n=== CHI TIẾT UNKNOWN RECORDS ({$details['unknown_count']} records) ===");

                $unknownData = [];
                foreach ($details['unknown_records'] as $record) {
                    $unknownData[] = [
                        $record['id'],
                        $record['description'],
                        $record['properties'],
                        $record['created_at']
                    ];
                }

                $this->table(['ID', 'Description', 'Properties', 'Created At'], $unknownData);
            }

            // Export unknown records to a CSV file if requested
            if ($exportUnknown && !empty($details['unknown_records'])) {
                $filename = $exportUnknown;
                if ($filename === true) {
                    $filename = 'unknown_records_' . date('Ymd_His') . '.csv';
                }

                $this->exportToCsv($details['unknown_records'], $filename);
                $this->info("Đã export " . count($details['unknown_records']) . " unknown records ra file: {$filename}");
            }

            return 0;
        }

        // Confirm with the user
        if (!$this->confirm("Bạn có chắc chắn muốn cập nhật " . count($logs) . " bản ghi?")) {
            $this->info('Đã hủy thao tác.');
            return 0;
        }

        $bar = $this->output->createProgressBar(count($logs));
        $updated = 0;
        $notFound = 0;
        $matchedBy = [
            'full_name' => 0,
            'first_last_name' => 0,
            'like_match' => 0
        ];

        // Process in chunks to avoid memory overload
        foreach (array_chunk($logs->toArray(), $chunkSize) as $chunk) {
            foreach ($chunk as $log) {
                $result = $this->updateSingleLog($log, $tables, $matchedBy);
                if ($result) {
                    $updated++;
                } else {
                    $notFound++;
                }
                $bar->advance();
            }
        }

        $bar->finish();
        $this->newLine(2);

        $this->info("Đã cập nhật: {$updated}");
        $this->warn("Không tìm thấy: {$notFound}");

        $this->info("\nChi tiết cách ghép:");
        foreach ($matchedBy as $method => $count) {
            if ($count > 0) {
                $this->line("  - {$method}: {$count} bản ghi");
            }
        }

        return 0;
    }

    /**
     * Get the detailed statistics
     */
    private function getDetailedStats($logs, $tables)
    {
        $guards = [];
        $unknownRecords = [];

        foreach ($logs as $log) {
            $result = $this->findGuardAndUser($log->description, $tables);
            if ($result) {
                $guards[$result['guard']] = ($guards[$result['guard']] ?? 0) + 1;
            } else {
                $guards['unknown'] = ($guards['unknown'] ?? 0) + 1;

                // Save the unknown record information
                $unknownRecords[] = [
                    'id' => $log->id,
                    'description' => $log->description,
                    'properties' => $log->properties,
                    'created_at' => $log->created_at ?? 'N/A',
                    'user_name' => str_replace(' logged in', '', trim($log->description))
                ];
            }
        }

        return [
            'guards' => $guards,
            'unknown_count' => $guards['unknown'] ?? 0,
            'unknown_records' => $unknownRecords
        ];
    }

    /**
     * Export unknown records to a CSV file
     */
    private function exportToCsv($records, $filename)
    {
        $file = fopen($filename, 'w');

        // Write the header
        fputcsv($file, ['ID', 'Description', 'Properties', 'Created At', 'Extracted User Name']);

        // Write the data
        foreach ($records as $record) {
            fputcsv($file, [
                $record['id'],
                $record['description'],
                $record['properties'],
                $record['created_at'],
                $record['user_name']
            ]);
        }

        fclose($file);
    }

    /**
     * Check whether a column exists in the table
     */
    private function checkColumnExists($table, $column)
    {
        if (!Schema::hasTable($table)) {
            return false;
        }
        return Schema::hasColumn($table, $column);
    }

    /**
     * Get the first_name column name (may be first_name or firstname)
     */
    private function getFirstNameColumn($table)
    {
        if (!Schema::hasTable($table)) {
            return null;
        }

        if (Schema::hasColumn($table, 'first_name')) {
            return 'first_name';
        }
        if (Schema::hasColumn($table, 'firstname')) {
            return 'firstname';
        }
        return null;
    }

    /**
     * Get the last_name column name (may be last_name or lastname)
     */
    private function getLastNameColumn($table)
    {
        if (!Schema::hasTable($table)) {
            return null;
        }

        if (Schema::hasColumn($table, 'last_name')) {
            return 'last_name';
        }
        if (Schema::hasColumn($table, 'lastname')) {
            return 'lastname';
        }
        return null;
    }

    /**
     * Update a single log
     */
    private function updateSingleLog($log, $tables, &$matchedBy)
    {
        // Find the user and guard based on the description
        $result = $this->findGuardAndUser($log->description, $tables);

        if (!$result) {
            return false;
        }

        // Parse properties
        $properties = json_decode($log->properties ?? '[]', true);
        if (!is_array($properties)) {
            $properties = [];
        }

        // Add the guard to properties
        $properties['guard'] = $result['guard'];

        // Update causer_id and causer_type
        $updateData = [
            'properties' => json_encode($properties),
            'causer_id' => $result['user_id'],
            'causer_type' => $result['model']
        ];

        // Record the matching method
        if (isset($result['method'])) {
            $matchedBy[$result['method']] = ($matchedBy[$result['method']] ?? 0) + 1;
        }

        // Update
        DB::table('activity_log')
            ->where('id', $log->id)
            ->update($updateData);

        return true;
    }

    /**
     * Find the guard and user based on the description
     */
    private function findGuardAndUser($description, $tables)
    {
        // Strip " logged in" from the description
        $userName = str_replace(' logged in', '', trim($description));

        // Case 1: Match by full_name first
        foreach ($tables as $table => $info) {
            if ($info['has_full_name']) {
                $user = DB::table($table)
                    ->where('full_name', $userName)
                    ->orWhere('full_name', 'like', '%' . $userName . '%')
                    ->orWhere(DB::raw("LOWER(full_name)"), strtolower($userName))
                    ->first(['id']); // Only fetch the id for optimization

                if ($user) {
                    return [
                        'guard' => $info['guard'],
                        'model' => $info['model'],
                        'user_id' => $user->id,
                        'method' => 'full_name'
                    ];
                }
            }
        }

        // Split into first and last name
        $nameParts = explode(' ', $userName);
        $lastName = array_pop($nameParts);
        $firstName = implode(' ', $nameParts);

        // Case 2: Match by first_name + last_name
        foreach ($tables as $table => $info) {
            if ($info['has_first_name'] && $info['has_last_name']) {
                $firstNameCol = $info['first_name_col'];
                $lastNameCol = $info['last_name_col'];

                $user = DB::table($table)
                    ->where(function($query) use ($firstNameCol, $lastNameCol, $firstName, $lastName, $userName) {
                        $query->where(DB::raw("CONCAT({$firstNameCol}, ' ', {$lastNameCol})"), $userName)
                            ->orWhere(DB::raw("LOWER(CONCAT({$firstNameCol}, ' ', {$lastNameCol}))"), strtolower($userName))
                            ->orWhere(function($q) use ($firstNameCol, $lastNameCol, $firstName, $lastName) {
                                $q->where($firstNameCol, $firstName)
                                    ->where($lastNameCol, $lastName);
                            })
                            ->orWhere(function($q) use ($firstNameCol, $lastNameCol, $firstName, $lastName) {
                                $q->where($firstNameCol, 'like', '%' . $firstName . '%')
                                    ->where($lastNameCol, 'like', '%' . $lastName . '%');
                            })
                            ->orWhere(DB::raw("CONCAT({$firstNameCol}, ' ', {$lastNameCol})"), 'like', '%' . $userName . '%');
                    })
                    ->first(['id']);

                if ($user) {
                    return [
                        'guard' => $info['guard'],
                        'model' => $info['model'],
                        'user_id' => $user->id,
                        'method' => 'first_last_name'
                    ];
                }
            }
        }

        // Case 3: Simpler LIKE-based match
        foreach ($tables as $table => $info) {
            if ($info['has_first_name'] && $info['has_last_name']) {
                $firstNameCol = $info['first_name_col'];
                $lastNameCol = $info['last_name_col'];

                $users = DB::table($table)
                    ->select(['id', DB::raw("CONCAT({$firstNameCol}, ' ', {$lastNameCol}) as full_name")])
                    ->get();

                foreach ($users as $user) {
                    $fullName = $user->full_name;
                    $similarity = 0;
                    similar_text(strtolower($userName), strtolower($fullName), $similarity);

                    if ($similarity > 70) {
                        return [
                            'guard' => $info['guard'],
                            'model' => $info['model'],
                            'user_id' => $user->id,
                            'method' => 'like_match'
                        ];
                    }
                }
            }
        }

        return null;
    }
}
