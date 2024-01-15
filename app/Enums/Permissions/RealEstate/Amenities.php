<?php

namespace App\Enums\Permissions\RealEstate;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Values;

enum Amenities: string
{
    use InvokableCases, Values;

    case READ = 'real-estate.amenities.read';
    case WRITE = 'real-estate.amenities.write';
    case DELETE = 'real-estate.amenities.delete';
}
