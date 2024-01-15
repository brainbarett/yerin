<?php

namespace App\Enums\RealEstate\Permissions;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Values;

enum AmenitiesPermissions: string
{
    use InvokableCases, Values;

    case READ = 'real-estate.amenities.read';
    case WRITE = 'real-estate.amenities.write';
    case DELETE = 'real-estate.amenities.delete';
}
