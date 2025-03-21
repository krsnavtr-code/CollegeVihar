<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Employee
 * 
 * @property int $id
 * @property string $emp_name
 * @property string $emp_username
 * @property string|null $emp_pic
 * @property string|null $emp_contact
 * @property string|null $emp_email
 * @property string|null $emp_company_email
 * @property string $emp_password
 * @property string|null $emp_address
 * @property string $emp_gender
 * @property Carbon $emp_dob
 * @property Carbon $emp_joining_date
 * @property int $emp_job_role
 * @property int|null $emp_salary
 * @property int $emp_state
 * @property string $emp_type
 * @property string|null $emp_docs
 * @property int|null $emp_team
 * @property int $emp_status
 * @property Carbon $created_at
 * 
 * @property Team|null $team
 * @property State $state
 * @property Jobrole $jobrole
 * @property Collection|Lead[] $leads
 * @property Collection|Team[] $teams
 *
 * @package App\Models
 */
class Employee extends Model
{
	protected $table = 'employees';
	public $timestamps = false;

	protected $casts = [
		'emp_dob' => 'datetime',
		'emp_joining_date' => 'datetime',
		'emp_job_role' => 'int',
		'emp_salary' => 'int',
		'emp_state' => 'int',
		'emp_team' => 'int',
		'emp_status' => 'int'
	];

	protected $hidden = [
		// Comment because password is not hidden required for password change
		// 'emp_password'
	];

	protected $fillable = [
		'emp_name',
		'emp_username',
		'emp_pic',
		'emp_contact',
		'emp_email',
		'emp_company_email',
		'emp_password',
		'emp_address',
		'emp_gender',
		'emp_dob',
		'emp_joining_date',
		'emp_job_role',
		'emp_salary',
		'emp_state',
		'emp_type',
		'emp_docs',
		'emp_team',
		'emp_status'
	];

	public function team()
	{
		return $this->belongsTo(Team::class, 'emp_team');
	}

	public function state()
	{
		return $this->belongsTo(State::class, 'emp_state');
	}

	public function jobrole()
	{
		return $this->belongsTo(JobRole::class, 'emp_job_role');
	}

	public function leads()
	{
		return $this->hasMany(Lead::class, 'lead_owner');
	}

	public function teams()
	{
		return $this->hasMany(Team::class, 'team_leader');
	}
}
