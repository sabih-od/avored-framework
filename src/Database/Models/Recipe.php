<?php
namespace AvoRed\Framework\Database\Models;

use AvoRed\Framework\Database\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Recipe extends BaseModel implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    /**
     * Tax Percentage Configuration Constant.
     * @var string
     */
    
    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'is_approved'
    ];

    protected $hidden = [
        'media'
    ];

    protected $appends = [
        'media_upload'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getMediaUploadAttribute()
    {
        $mediaItems = $this->getMedia('recipe_upload');
        return isset($mediaItems[0]) ? collect([
            'url' => $mediaItems[0]->getFullUrl(),
            'mime_type' => $mediaItems[0]->mime_type
        ]) : collect([]);
    }
}
