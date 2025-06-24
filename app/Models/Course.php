<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Course
 *
 * @property int $id
 * @property string $course_name
 * @property string $course_short_name
 * @property string $course_type
 * @property int $course_online
 * @property string|null $course_duration
 * @property string|null $course_eligibility_short
 * @property string|null $course_intro
 * @property string|null $course_overview
 * @property string|null $course_highlights
 * @property string|null $course_subjects
 * @property string|null $course_eligibility
 * @property string|null $course_freights
 * @property string|null $course_specialization
 * @property string|null $course_job
 * @property string|null $course_types
 * @property string|null $why_this_course
 * @property string|null $course_faqs
 * @property int|null $course_slug
 * @property int $course_status
 * @property int $course_detail_added
 *
 * @property Metadata|null $metadata
 * @property Collection|Lead[] $leads
 * @property Collection|University[] $universities
 *
 * @package App\Models
 */
class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'courses';
    public $timestamps = true;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'course_online' => 'boolean',
        'course_status' => 'boolean',
        'course_detail_added' => 'boolean',
        'course_slug' => 'int',
        'course_category' => 'string',
        'course_subcategory' => 'string',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * Scope a query to only include active courses.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('course_status', true);
    }

    // Available categories and subcategories
    public const CATEGORIES = [
        'UG' => 'Undergraduate',
        'PG' => 'Postgraduate',
        'DIPLOMA' => 'Diploma',
        'CERTIFICATION' => 'Certification'
    ];

    public const SUBCATEGORIES = [
        'TECHNICAL' => 'Technical',
        'MANAGEMENT' => 'Management',
        'MEDICAL' => 'Medical',
        'TRADITIONAL' => 'Traditional'
    ];

    protected $fillable = [
        'course_name',
        'course_short_name',
        'course_category',
        'course_subcategory',
        'course_online',
        'course_duration',
        'course_eligibility_short',
        'course_intro',
        'course_overview',
        'course_highlights',
        'course_subjects',
        'course_eligibility',
        'course_freights',
        'course_specialization',
        'course_job',
        'course_types',
        'why_this_course',
        'course_faqs',
        'course_slug',
        'course_status',
        'course_detail_added',
        'course_type'  // Keeping for backward compatibility
    ];

    public function metadata()
    {
        return $this->belongsTo(Metadata::class, 'course_slug');
    }

    public function leads()
    {
        return $this->hasMany(Lead::class, 'lead_course');
    }

    public function universities()
    {
        return $this
            ->belongsToMany(University::class, 'universitycourses')
            ->with('metadata')
            ->withPivot('id', 'univ_course_commision', 'univ_course_fee', 'univ_course_slug', 'univ_course_status', 'univ_course_detail_added');
    }

    /**
     * Get the validation rules that apply to the model.
     *
     * @return array
     */
    public static function rules($id = null)
    {
        $rules = [
            'course_name' => 'required|string|max:255',
            'course_short_name' => [
                'required',
                'string',
                'max:50',
                \Illuminate\Validation\Rule::unique('courses', 'course_short_name')->ignore($id, 'id')
            ],
            'course_category' => 'required|in:' . implode(',', array_keys(self::CATEGORIES)),
            'course_subcategory' => 'required|in:' . implode(',', array_keys(self::SUBCATEGORIES)),
            'course_online' => 'required|boolean',
        ];

        return $rules;
    }

    /**
     * Get the validation messages.
     *
     * @return array
     */
    public static function messages()
    {
        return [
            'course_name.required' => 'The course name is required.',
            'course_short_name.required' => 'The course short name is required.',
            'course_short_name.unique' => 'This course short name already exists.',
            'course_category.required' => 'Please select a course category.',
            'course_category.in' => 'The course category must be one of: ' . implode(', ', array_values(self::CATEGORIES)),
            'course_subcategory.required' => 'Please select a course subcategory.',
            'course_subcategory.in' => 'The course subcategory must be one of: ' . implode(', ', array_values(self::SUBCATEGORIES)),
            'course_online.required' => 'Please select the course type (Online/Offline).',
        ];
    }
}
