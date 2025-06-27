<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UniversityGallery extends Model
{
    protected $fillable = [
        'university_id',
        'image_path',
        'original_name',
        'mime_type',
        'size'
    ];

    /**
     * Get the university that owns the gallery image.
     */
    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class);
    }
}
