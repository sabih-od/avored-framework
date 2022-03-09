<?php

namespace AvoRed\Framework\Database\Models;

use App\Models\Comment;
use AvoRed\Framework\Database\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends BaseModel implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes, UuidTrait;

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
        'title',
        'content',
        'location'
    ];

    protected $hidden = [
        'media'
    ];

    protected $appends = [
        'media_upload'
    ];

    public function getMorphClass()
    {
        return "App\Models\Post";
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getMediaUploadAttribute()
    {
        $mediaItems = $this->getMedia('post_upload');
        return isset($mediaItems[0]) ? collect([
            'url' => $mediaItems[0]->getFullUrl(),
            'mime_type' => $mediaItems[0]->mime_type
        ]) : collect([]);
    }

    /**
     * @return MorphMany
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id')->orderBy('comments.created_at');
    }
}
