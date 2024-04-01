<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Exceptions\FileNotFoundException;
use App\Imports\ImportCountries;
use App\Services\CsvImportService;
use Illuminate\Database\Seeder;

final class CountrySeeder extends Seeder
{
    /**
     * @throws FileNotFoundException
     */
    public function run(): void
    {
        $file            = base_path('database/seeders/csv/countries.csv');
        $countryImporter = new CsvImportService(new ImportCountries());
        $countryImporter->importFile($file);
    }
}
