<?php

declare(strict_types=1);

namespace App\Imports;

use App\Contracts\ImportStrategy;
use App\Models\Country;
use App\Models\State;

final class ImportStates implements ImportStrategy
{
    public function import($handle): void
    {
        $states = [];

        while (($row = fgetcsv($handle, 0)) !== false) {
            $states[] = [
                'country_id' => Country::firstOrCreate(['name' => $row[4]])->id,
                'name'       => $row[1],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        State::insert($states);
    }
}
