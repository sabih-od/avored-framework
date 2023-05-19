<?php

namespace AvoRed\Framework\Database\Models;

use App\Models\Review;
use App\Traits\ReportedRelationTrait;
use AvoRed\Framework\Database\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Recipe extends BaseModel implements HasMedia
{
    use HasFactory, InteractsWithMedia, ReportedRelationTrait, SoftDeletes;

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
        'ingredients',
        'is_approved'
    ];

    protected $hidden = [
        'media'
    ];

    protected $appends = [
        'media_upload',
        'reviews_count',
        'total_reviews',
        'auth_review',
        'is_reported',
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

    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable')->whereNull('deleted_at');
    }

    /**
     * @return int
     */
    public function getTotalReviewsAttribute()
    {
        return (int)$this->reviews()->sum('rating');
    }

    /**
     * @return int
     */
    public function getReviewsCountAttribute()
    {
        return (int)$this->reviews()->count();
    }

    /**
     * @return Collection|null
     */
    public function getAuthReviewAttribute()
    {
        if (Auth::guard('sanctum')->check()) {
            return $this->reviews()->where('user_id', Auth::guard('sanctum')->id())->first();
        }
        return null;
    }
}
