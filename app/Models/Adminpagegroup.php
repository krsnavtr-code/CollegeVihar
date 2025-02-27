<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Adminpagegroup
 * 
 * @property int $id
 * @property string $group_title
 * @property int $group_index
 * 
 * @property Collection|Adminpage[] $adminpages
 *
 * @package App\Models
 */
class Adminpagegroup extends Model
{
	protected $table = 'adminpagegroup';
	public $timestamps = false;

	protected $casts = [
		'group_index' => 'int'
	];

	protected $fillable = [
		'group_title',
		'group_index'
	];

	public function adminpages()
	{
		return $this->hasMany(AdminPage::class, 'page_group');
	}
}
