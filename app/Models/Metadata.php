<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Metadata
 * 
 * @property int $id
 * @property string $url_slug
 * @property string $meta_title
 * @property string $meta_h1
 * @property string $meta_description
 * @property string $meta_keywords
 * @property string|null $meta_image
 * @property string $meta_canonical
 * @property string|null $other_meta_tags
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Course[] $courses
 * @property Collection|University[] $universities
 * @property Collection|Universitycourse[] $universitycourses
 *
 * @package App\Models
 */
class Metadata extends Model
{
	protected $table = 'metadata';

	protected $fillable = [
		'slug_id',
		'url_slug',
		'meta_title',
		'meta_h1',
		'meta_description',
		'meta_keywords',
	];

	public function courses()
	{
		return $this->hasMany(Course::class, 'course_slug');
	}

	public function universities()
	{
		return $this->hasMany(University::class, 'univ_slug');
	}

	public function universitycourses()
	{
		return $this->hasMany(Universitycourse::class, 'univ_course_slug');
	}

	public function blogs()
	{
		return $this->hasMany(Blog::class, 'slug_id');
	}
}
