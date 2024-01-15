<?php

namespace App\Utils\ModelImages;

use App\Models\ModelImages;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;

trait HasImages
{
    protected static function booted()
    {
        parent::booted();

        static::deleting(function (self $resource) {
            $resource->images()->delete();
        });
    }

    public function images(): MorphMany
    {
        return $this->morphMany(ModelImages::class, 'imageable');
    }

    public function syncImages(Collection|array $images)
    {
        if (is_array($images)) {
            $images = collect($images);
        }

        $this->images()->whereNotIn('image_id', $images->pluck('id')->toArray())->delete();

        $images->sortBy('order')->each(function ($image, $i) {
            $this->images()->updateOrCreate(
                ['image_id' => $image['id']],
                ['order' => $i]
            );
        });
    }
}
