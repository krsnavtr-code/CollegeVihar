<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

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
	protected $table = 'courses';
	public $timestamps = false;

	protected $casts = [
		'course_online' => 'int',
		'course_slug' => 'int',
		'course_status' => 'int',
		'course_detail_added' => 'int'
	];

	protected $fillable = [
		'course_name',
		'course_img',
		'course_short_name',
		'course_type',
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
		'course_detail_added'
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
		return $this->belongsToMany(University::class, 'universitycourses')->with('metadata')
			->withPivot('id', 'univ_course_commision', 'univ_course_fee',  'univ_course_slug', 'univ_course_status', 'univ_course_detail_added');
	}
}
