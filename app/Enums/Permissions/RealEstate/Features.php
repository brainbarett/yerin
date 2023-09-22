<?php

namespace App\Enums\Permissions\RealEstate;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Values;

enum Features: string
{
	use InvokableCases, Values;
	
	case READ = 'real-estate.features.read';
	case WRITE = 'real-estate.features.write';
	case DELETE = 'real-estate.features.delete';
}
