<?php

namespace App\Enums\RealEstate\Permissions;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Values;

enum PropertiesPermissions: string
{
    use InvokableCases, Values;

    case READ = 'real-estate.properties.read';
    case WRITE = 'real-estate.properties.write';
    case DELETE = 'real-estate.properties.delete';
}
