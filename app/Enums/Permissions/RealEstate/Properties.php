<?php

namespace App\Enums\Permissions\RealEstate;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Values;

enum Properties: string
{
    use InvokableCases, Values;

    case READ = 'real-estate.properties.read';
    case WRITE = 'real-estate.properties.write';
    case DELETE = 'real-estate.properties.delete';
}
