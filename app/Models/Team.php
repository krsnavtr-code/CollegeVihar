<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Team
 * 
 * @property int $id
 * @property string $team_name
 * @property int $team_leader
 * 
 * @property Employee $employee
 * @property Collection|Employee[] $employees
 *
 * @package App\Models
 */
class Team extends Model
{
	protected $table = 'team';
	public $timestamps = false;

	protected $casts = [
		'team_leader' => 'int'
	];

	protected $fillable = [
		'team_name',
		'team_leader'
	];

	public function employee()
	{
		return $this->belongsTo(Employee::class, 'team_leader');
	}

	public function employees()
	{
		return $this->hasMany(Employee::class, 'emp_team');
	}
}
