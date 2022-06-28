<?php

namespace App\Dal;

use App\Result\Result;

interface KnownPrimesInterface
{
    public function get(int $number): ?Result;
}
