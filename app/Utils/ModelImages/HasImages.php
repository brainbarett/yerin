<?php

namespace App\Utils\ModelImages;

use App\Models\ModelImages;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;

trait HasImages
{
    public function images(): MorphMany
    {
        return $this->morphMany(ModelImages::class, 'imageable');
    }

	public function syncImages(Collection | array $images)
	{
		if(is_array($images)) {
			$images = collect($images);
		}
		
		$this->images()->whereNotIn('id', $images->pluck('id')->toArray())->delete();

		$images->sortBy('order')->each(function($image, $i) {
            $this->images()->create([
				'image_id' => $image['id'],
                'order' => $i
			]);
        });
	}

    protected static function booted()
    {
        parent::booted();

        static::deleting(function(Model $resource) {
            $resource->images()->delete();
        });
    }
}
