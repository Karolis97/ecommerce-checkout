<?php

declare(strict_types=1);

namespace App\Contracts;

interface ImportStrategy
{
    public function import($handle): void;
}
