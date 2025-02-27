<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Adminpage
 * 
 * @property int $id
 * @property string $admin_page_title
 * @property string $admin_page_url
 * @property int|null $page_group
 * @property int $can_display
 * @property int $admin_page_status
 * 
 * @property Adminpagegroup|null $adminpagegroup
 *
 * @package App\Models
 */
class Adminpage extends Model
{
	protected $table = 'adminpages';
	public $timestamps = false;

	protected $casts = [
		'page_group' => 'int',
		'can_display' => 'int',
		'admin_page_status' => 'int'
	];

	protected $fillable = [
		'admin_page_title',
		'admin_page_url',
		'page_group',
		'can_display',
		'admin_page_status'
	];

	public function adminpagegroup()
	{
		return $this->belongsTo(Adminpagegroup::class, 'page_group');
	}
}
