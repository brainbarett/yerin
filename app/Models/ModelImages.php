<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelImages extends Model
{
    use HasFactory;

	protected $guarded = [];

	protected $with = ['source'];

	public function imageable()
	{
		return $this->morphTo();
	}

	public function source()
	{
		return $this->hasOne(Images::class, 'id', 'image_id');
	}
	
    public function filename(): Attribute
    {
        return Attribute::make(
			get: fn() => $this->source->filename
		);
    }
}
