<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Exceptions\FileNotFoundException;
use App\Imports\ImportStates;
use App\Services\CsvImportService;
use Illuminate\Database\Seeder;

final class StateSeeder extends Seeder
{
    /**
     * @throws FileNotFoundException
     */
    public function run(): void
    {
        $file          = base_path('database/seeders/csv/states.csv');
        $stateImporter = new CsvImportService(new ImportStates());
        $stateImporter->importFile($file);
    }
}
