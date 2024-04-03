<?php

declare(strict_types=1);

use App\Exceptions\FileNotFoundException;
use App\Imports\ImportStates;
use App\Models\Country;
use App\Services\CsvImportService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

beforeEach(function (): void {
    Storage::fake('local');

    $this->csvFilePath = storage_path('app/states.csv');
    $this->csvContent  = "header\n1574,Alytus County,126,LT,Lithuania,AL,,54.20002140,24.15126340";

    File::put($this->csvFilePath, $this->csvContent);
});

test('imports states with country creation successfully', function (): void {
    $importer = new CsvImportService(new ImportStates());

    $importer->importFile($this->csvFilePath);

    $country = Country::where('name', 'Lithuania')->first();

    \Pest\Laravel\assertDatabaseHas('states', [
        'name'       => 'Alytus County',
        'country_id' => $country->id,
    ]);

});

test('throws an exception if the CSV file does not exist', function (): void {
    $nonExistentFilePath = storage_path('app/non_existent.csv');
    $importer            = new CsvImportService(new ImportStates());
    $importer->importFile($nonExistentFilePath);
})->throws(FileNotFoundException::class);
