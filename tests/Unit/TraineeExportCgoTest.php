<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Exports\TraineeReportExportCgo;
use App\Exports\TraineeListExportCgo;
use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Mockery;

class TraineeExportCgoTest extends TestCase
{
    protected $originalContainer;

    protected function setUp(): void
    {
        parent::setUp();
        // Save original container to restore later
        $this->originalContainer = Container::getInstance();
    }

    protected function tearDown(): void
    {
        // Restore container and close Mockery
        Container::setInstance($this->originalContainer);
        Mockery::close();
        parent::tearDown();
    }

    public function test_report_export_maps_translatable_arrays_correctly()
    {
        // Setup mock application container to return 'en' locale
        $appMock = Mockery::mock(\Illuminate\Foundation\Application::class);
        $appMock->shouldReceive('getLocale')->andReturn('en');
        Container::setInstance($appMock);

        // Mock a trainee with array values for full_name and NVQ details
        $trainee = new \stdClass();
        $trainee->portfolio = true;
        $trainee->career_test_count = 3;
        $trainee->cgo_counseling_count = 1;
        $trainee->full_name = [
            'en' => 'John Doe English',
            'sn' => 'John Doe Sinhala',
        ];
        $trainee->first_name = 'John';
        $trainee->last_name = 'Doe';
        $trainee->nic = '123456789V';
        $trainee->email = 'john@example.com';
        $trainee->mobile = '0771234567';

        // Mock NVQ levels relation mapping
        $nvq1 = new \stdClass();
        $nvq1->name = [
            'en' => 'Software Developer',
            'sn' => 'Sinhala Name Software Developer',
        ];
        $nvq1->level = [
            'en' => 'Level 4',
            'sn' => 'Level 4 Sinhala',
        ];

        $trainee->nvqs = collect([$nvq1]);

        $export = new TraineeReportExportCgo(collect([$trainee]));
        $mapped = $export->map($trainee);

        $this->assertEquals('John Doe English', $mapped[0]); // full_name
        $this->assertEquals('Yes', $mapped[4]); // portfolioStatus
        $this->assertEquals("• Software Developer (Level 4)", $mapped[5]); // nvqLevels

        // Change locale mock behavior and check if it switches languages correctly
        $appMock2 = Mockery::mock(\Illuminate\Foundation\Application::class);
        $appMock2->shouldReceive('getLocale')->andReturn('sn');
        Container::setInstance($appMock2);

        $mappedSinhala = $export->map($trainee);
        $this->assertEquals('John Doe Sinhala', $mappedSinhala[0]);
        $this->assertEquals("• Sinhala Name Software Developer (Level 4 Sinhala)", $mappedSinhala[5]);
    }

    public function test_list_export_maps_translatable_arrays_correctly()
    {
        $appMock = Mockery::mock(\Illuminate\Foundation\Application::class);
        $appMock->shouldReceive('getLocale')->andReturn('en');
        Container::setInstance($appMock);

        $trainee = new \stdClass();
        $trainee->full_name = [
            'en' => 'Alice Smith',
            'sn' => 'Alice Smith Sinhala',
        ];
        $trainee->contact_address = [
            'en' => 'Colombo, Sri Lanka',
            'sn' => 'Colombo, Sri Lanka Sinhala',
        ];
        $trainee->mobile = '0777654321';
        $trainee->email = 'alice@example.com';

        $request = new Request();
        $export = new TraineeListExportCgo($request);
        $mapped = $export->map($trainee);

        $this->assertEquals('Alice Smith', $mapped[0]);
        $this->assertEquals('Colombo, Sri Lanka', $mapped[1]);

        // Switch locale mock
        $appMock2 = Mockery::mock(\Illuminate\Foundation\Application::class);
        $appMock2->shouldReceive('getLocale')->andReturn('sn');
        Container::setInstance($appMock2);

        $mappedSinhala = $export->map($trainee);
        $this->assertEquals('Alice Smith Sinhala', $mappedSinhala[0]);
        $this->assertEquals('Colombo, Sri Lanka Sinhala', $mappedSinhala[1]);
    }
}
