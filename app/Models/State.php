<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class State
 * 
 * @property int $id
 * @property string $state_name
 * @property string $state_short
 * 
 * @property Collection|Employee[] $employees
 * @property Collection|University[] $universities
 *
 * @package App\Models
 */
class State extends Model
{
	protected $table = 'states';
	public $timestamps = false;

	protected $fillable = [
		'state_name',
		'state_short'
	];

	public function employees()
	{
		return $this->hasMany(Employee::class, 'emp_state');
	}

	public function universities()
	{
		return $this->hasMany(University::class, 'univ_state')->with(['metadata','courses']);
	}
}
