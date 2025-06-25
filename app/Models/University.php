<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class University
 * 
 * @property int $id
 * @property string $univ_name
 * @property string $univ_url
 * @property string|null $univ_logo
 * @property string|null $univ_image
 * @property string $univ_type
 * @property string|null $univ_person
 * @property string|null $univ_person_email
 * @property string|null $univ_person_phone
 * @property int|null $univ_state
 * @property string|null $univ_address
 * @property string|null $univ_description
 * @property string|null $univ_facts
 * @property string|null $univ_advantage
 * @property string|null $univ_industry
 * @property string|null $univ_carrier
 * @property int|null $univ_slug
 * @property int $univ_status
 * @property int $univ_detail_added
 * @property Carbon $created_at
 * @property int|null $univ_payout
 * @property string|null $brochure
 * 
 * @property State|null $state
 * @property Metadata|null $metadata
 * @property Collection|Lead[] $leads
 * @property Collection|Course[] $courses
 *
 * @package App\Models
 */
class University extends Model
{
	protected $table = 'universities';
	public $timestamps = false;

	protected $casts = [
		'univ_state' => 'int',
		'univ_slug' => 'int',
		'univ_status' => 'int',
		'univ_detail_added' => 'int'
	];

	protected $fillable = [
		'univ_name',
		'univ_url',
		'univ_logo',
		'univ_image',
		'univ_type',
		'univ_state',
		'univ_address',
		'univ_description',
		'univ_facts',
		'univ_advantage',
		'univ_industry',
		'univ_carrier',
		'univ_slug',
		'univ_status',
		'univ_detail_added',
		'brochure',
		'univ_category',
		'univ_country',
		'univ_city'
	];

	public function state()
	{
		return $this->belongsTo(State::class, 'univ_state');
	}

	public function metadata()
	{
		return $this->belongsTo(Metadata::class, 'univ_slug');
	}

	public function leads()
	{
		return $this->hasMany(Lead::class, 'lead_university');
	}

	public function univCourses(){
		return $this->hasMany(UniversityCourse::class,'university_id')->with(['metadata:id,url_slug','course:id,course_name,course_duration,course_online,course_status']);
	}
	public function courses()
	{
		return $this->belongsToMany(Course::class, 'universitycourses')
					->withPivot('id', 'univ_course_commision', 'univ_course_fee', 'uc_about', 'uc_overview', 'uc_highlight', 'uc_cv_help', 'uc_collab', 'uc_expert', 'uc_subjects', 'uc_details', 'uc_assign', 'uc_job', 'univ_course_slug', 'univ_course_status', 'univ_course_detail_added');
	}
}
