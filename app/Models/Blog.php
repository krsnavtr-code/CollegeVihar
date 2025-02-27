<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Blog
 * 
 * @property int $id
 * @property string $blog_title
 * @property string $blog_author
 * @property string $blog_content
 * @property string $blog_pic
 * @property int $blog_status
 * @property Carbon $created_on
 *
 * @package App\Models
 */
class Blog extends Model
{
	protected $table = 'blogs';
	public $timestamps = false;

	protected $casts = [
		'blog_status' => 'int',
		'slug_id' => 'int',
		'created_on' => 'datetime'
	];

	protected $fillable = [
		'blog_title',
		'blog_author',
		'blog_content',
		'blog_pic',
		'blog_status',
		'created_on'
	];

	public function metadata()
	{
		return $this->belongsTo(Metadata::class, 'slug_id');
	}
}
