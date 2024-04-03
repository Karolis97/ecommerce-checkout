<?php

declare(strict_types=1);

use App\Exceptions\FileNotFoundException;
use App\Imports\ImportCountries;
use App\Services\CsvImportService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

beforeEach(function (): void {
    Storage::fake('local');

    $this->csvFilePath = storage_path('app/countries.csv');
    $this->csvContent  = "header\n1,Lithuania,LTU,LT,440,370,Vilnius,EUR,Euro,€,.lt,Lietuva,Europe,4,Northern Europe,18,Lithuanian,[{zoneName:'Europe\/Vilnius',gmtOffset:7200,gmtOffsetName:'UTC+02:00',abbreviation:'EET',tzName:'Eastern European Time'}],56.00000000,24.00000000,🇱🇹,U+1F1F1 U+1F1F9
";

    File::put($this->csvFilePath, $this->csvContent);
});

test('imports data from a CSV file successfully', function (): void {
    $importer = new CsvImportService(new ImportCountries());

    $importer->importFile($this->csvFilePath);

    \Pest\Laravel\assertDatabaseHas('countries', [
        'name' => 'Lithuania',
    ]);
});

test('throws an exception if the CSV file does not exist', function (): void {
    $nonExistentFilePath = storage_path('app/non_existent.csv');
    $importer            = new CsvImportService(new ImportCountries());
    $importer->importFile($nonExistentFilePath);
})->throws(FileNotFoundException::class);
