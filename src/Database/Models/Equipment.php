<?php

namespace AvoRed\Framework\Database\Models;

use App\Models\Review;
use AvoRed\Framework\Database\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Equipment extends BaseModel implements HasMedia
{
    use HasFactory, InteractsWithMedia, UuidTrait;

    /**
     * Tax Percentage Configuration Constant.
     * @var string
     */

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'title',
        'content'
    ];

    protected $hidden = [
        'media',
        'deleted_at'
    ];

    protected $appends = [
        'media_upload'
    ];

    public function getMediaUploadAttribute()
    {
        $mediaItems = $this->getMedia('equipment_upload');
        return isset($mediaItems[0]) ? collect([
            'url' => $mediaItems[0]->getFullUrl(),
            'mime_type' => $mediaItems[0]->mime_type
        ]) : collect([]);
    }


    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable')->whereNull('deleted_at');
    }
}
