<?php

namespace App\Models;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property string $title
 * @property string|null $description
 * @property int $price
 * @property int|null $category_id
 * @property int|null $user_id
 *
 * @property Category|null $category
 * @property User $user
 */
class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    const MEDIA_COLLECTION_LOGO = 'logo';

    protected $fillable = [
        'title',
        'description',
        'price',
        'category_id',
        'user_id'
    ];

    protected $hidden = [
        'media'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function scopeSearch(Builder $query, string $search): void
    {
        $query->where('title', 'like', "%$search%");
    }

    public function getLogoUrlWhenLoaded(): ?string
    {
        return $this->relationLoaded('media')
            ? $this->media->where('collection_name', self::MEDIA_COLLECTION_LOGO)->first()?->getUrl()
            : null;
    }
}
