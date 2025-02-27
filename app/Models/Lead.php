<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


/**
 * Class Lead
 * 
 * @property int $id
 * @property string $lead_name
 * @property string|null $lead_dob
 * @property string $lead_contact
 * @property string|null $lead_email
 * @property string $lead_types
 * @property string|null $lead_old_qualification
 * @property int|null $lead_university
 * @property int|null $lead_course
 * @property string|null $lead_query
 * @property string|null $lead_source
 * @property int|null $lead_owner
 * @property string $lead_status
 * @property Carbon $created_at
 * 
 * @property University|null $university
 * @property Course|null $course
 * @property State|null $state
 * @property Collection|Leadupdate[] $leadupdates
 *
 * @package App\Models
 */
class Lead extends Model
{
	protected $table = 'leads';
	public $timestamps = false;

	protected $casts = [
		'lead_university' => 'int',
		'lead_course' => 'int',
		'state_id' => 'int',
	];

	protected $fillable = [
		'agent_name',
		'lead_name',
		'lead_dob',
		'lead_contact',
		'lead_email',
		'lead_old_qualification',
		'lead_university',
		'lead_course',
		'lead_status',
		'social_site_links',
        'mode_of_admission',
        'state_id'

	];



	public function university()
	{
		return $this->belongsTo(University::class, 'lead_university');
	}

	public function course()
	{
		return $this->belongsTo(Course::class, 'lead_course');
	}

	public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

	public function leadupdates()
	{
		return $this->hasMany(Leadupdate::class);
	}


	
}
