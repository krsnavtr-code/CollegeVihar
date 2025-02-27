<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MainLead
 * 
 * @property int $id
 * @property string|null $lead_name
 * @property string|null $getNumber
 * @property string|null $getEmail
 * @property string|null $getAddress
 * @property string|null $getCourse
 * @property string|null $getDescription
 * @property string|null $lead_types
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class MainLead extends Model
{
	protected $table = 'main_leads';

	protected $fillable = [
		'lead_name',
		'getNumber',
		'getEmail',
		'getAddress',
		'getCourse',
		'getDescription',
		'lead_types'
	];

	public function course()
	{
		return $this->belongsTo(Course::class, 'getCourse');
	}
}
