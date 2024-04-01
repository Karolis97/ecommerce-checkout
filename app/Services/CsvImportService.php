<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\ImportStrategy;
use App\Exceptions\FileNotFoundException;
use Illuminate\Support\Facades\File;

final class CsvImportService
{
    private ImportStrategy $importer;

    public function __construct(ImportStrategy $importer)
    {
        $this->importer = $importer;
    }

    /**
     * @throws FileNotFoundException
     */
    public function importFile(string $filePath): void
    {
        if ( ! File::exists($filePath)) {
            throw new FileNotFoundException("The file {$filePath} does not exist.");
        }

        $handle = fopen($filePath, 'r');

        fgetcsv($handle, 0);

        $this->importer->import($handle);

        fclose($handle);
    }
}
