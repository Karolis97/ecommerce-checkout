<?php

declare(strict_types=1);

namespace App\Imports;

use App\Contracts\ImportStrategy;
use App\Models\Country;

final class ImportCountries implements ImportStrategy
{
    public function import($handle): void
    {
        $countries = [];

        while (($row = fgetcsv($handle, 0)) !== false) {
            $countries[] = [
                'name'       => $row[1],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Country::insert($countries);
    }
}
