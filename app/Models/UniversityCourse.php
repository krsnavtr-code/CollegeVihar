<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Universitycourse
 * 
 * @property int $id
 * @property int $university_id
 * @property int $course_id
 * @property string $univ_course_commision
 * @property int|null $univ_course_fee
 * @property string|null $uc_about
 * @property string|null $uc_overview
 * @property string|null $uc_highlight
 * @property string|null $uc_cv_help
 * @property string|null $uc_collab
 * @property string|null $uc_expert
 * @property string|null $uc_subjects
 * @property string|null $uc_details
 * @property string|null $uc_assign
 * @property string|null $uc_job
 * @property int|null $univ_course_slug
 * @property int $univ_course_status
 * @property int $univ_course_detail_added
 * 
 * @property University $university
 * @property Course $course
 * @property Metadata|null $metadata
 *
 * @package App\Models
 */
class UniversityCourse extends Model
{
    protected $table = 'universitycourses';
    public $timestamps = false;

    protected $fillable = [
        'university_id',
        'course_id',
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
    ];

    protected $casts = [
        'university_id' => 'int',
        'course_id' => 'int',
        'univ_course_fee' => 'int',
        'univ_course_commision' => 'string',
        'univ_course_status' => 'int',
        'univ_course_detail_added' => 'int',
        'univ_course_slug' => 'int'
    ];

    public function university()
    {
        return $this->belongsTo(University::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function metadata()
    {
        return $this->belongsTo(Metadata::class, 'univ_course_slug');
    }
}
