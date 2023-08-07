<?php

namespace App\Enums\RealEstate;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Names;
use ArchTech\Enums\Options;
use ArchTech\Enums\Values;

enum RentTerms
{
	use InvokableCases, Options, Values, Names;
	
	case DAY;
	case WEEK;
	case MONTH;
	case YEAR;
}
