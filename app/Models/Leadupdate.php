<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Leadupdate
 * 
 * @property int $id
 * @property int|null $lead_id
 * @property string $update_text
 * @property Carbon $created_at
 * 
 * @property Lead|null $lead
 *
 * @package App\Models
 */
class Leadupdate extends Model
{
	protected $table = 'leadupdates';
	public $timestamps = false;

	protected $casts = [
		'lead_id' => 'int'
	];

	protected $fillable = [
		'lead_id',
		'update_text'
	];

	public function lead()
	{
		return $this->belongsTo(Lead::class);
	}
}
