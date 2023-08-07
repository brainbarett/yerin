<?php

namespace App\Enums\RealEstate;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Names;
use ArchTech\Enums\Options;
use ArchTech\Enums\Values;

enum PropertyTypes
{
	use InvokableCases, Options, Values, Names;
	
	case HOUSE;
	case VILLA;
	case APARTMENT;
	case PENTHOUSE;
}
