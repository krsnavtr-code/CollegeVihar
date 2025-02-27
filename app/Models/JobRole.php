<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Jobrole
 * 
 * @property int $id
 * @property string $job_role_title
 * @property string|null $permissions
 * @property int $role_sensitive
 * 
 * @property Collection|Employee[] $employees
 *
 * @package App\Models
 */
class Jobrole extends Model
{
	protected $table = 'jobroles';
	public $timestamps = false;

	protected $casts = [
		'role_sensitive' => 'int'
	];

	protected $fillable = [
		'job_role_title',
		'permissions',
		'role_sensitive'
	];

	public function employees()
	{
		return $this->hasMany(Employee::class, 'emp_job_role');
	}
}
