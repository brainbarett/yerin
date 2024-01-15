<?php

namespace App\Enums\RealEstate;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Names;
use ArchTech\Enums\Options;
use ArchTech\Enums\Values;

enum PropertyTypes
{
    use InvokableCases, Names, Options, Values;

    case HOUSE;
    case VILLA;
    case APARTMENT;
    case PENTHOUSE;
}
