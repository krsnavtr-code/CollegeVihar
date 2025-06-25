<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class University extends Model
{
    protected $table = 'universities';
    public $timestamps = true;

    protected $fillable = [
        'univ_name',
        'univ_url',
        'univ_type',
        'univ_category',
        'country_id',
        'state_id',
        'city_id',
        'univ_address',
        'univ_logo',
        'univ_banner',
        'univ_description',
        'univ_facts',
        'univ_industry',
        'univ_carrier',
        'univ_advantage',
        'univ_status',
        'univ_payout',
        'univ_meta_title',
        'univ_meta_desc',
        'univ_meta_keywords',
        'univ_person',
        'univ_person_email',
        'univ_person_phone',
        'univ_image',
        'univ_slug',
        'univ_detail_added',
        'brochure',
    ];

    protected $casts = [
        'univ_status' => 'boolean',
        'univ_detail_added' => 'boolean',
        'univ_payout' => 'boolean',
        'country_id' => 'integer',
        'state_id' => 'integer',
        'city_id' => 'integer',
    ];
    
    /**
     * Get the country that the university belongs to.
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the state that the university belongs to.
     */
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    /**
     * Get the city that the university belongs to.
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get the metadata for the university.
     */
    public function metadata(): BelongsTo
    {
        return $this->belongsTo(Metadata::class, 'univ_slug', 'url_slug');
    }

    /**
     * Get the leads associated with the university.
     */
    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class, 'lead_university');
    }

    /**
     * Get the university courses.
     */
    public function univCourses()
    {
        return $this->hasMany(UniversityCourse::class, 'university_id')
            ->with(['metadata:id,url_slug', 'course:id,course_name,course_duration,course_online,course_status']);
    }

    /**
     * Get the courses that belong to the university.
     */
    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'universitycourses')
            ->withPivot([
                'id',
                'univ_course_commision',
                'univ_course_fee',
                'uc_about',
                'uc_overview',
                'uc_highlight',
                'uc_cv_help',
                'uc_collab',
                'uc_expert',
                'uc_subjects',
                'uc_details',
                'uc_assign',
                'uc_job',
                'univ_course_slug',
                'univ_course_status',
                'univ_course_detail_added'
            ]);
    }
}
