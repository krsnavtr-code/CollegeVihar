<?php

namespace App\Http\Middleware;

use App\Models\Course;
use App\Models\Metadata;
use App\Models\State;
use App\Models\University;
use Closure;
use Illuminate\Http\Request;

function get_meta($meta)
{
    $title = $meta['meta_title'] ?? "CollegeVihar";
    $description = $meta['meta_description'] ?? "CollegeVihar";
    $keywords = $meta['meta_keywords'] ?? "CollegeVihar";
    $canonical = $meta['meta_canonical'] ?? '';
    $other_meta_tags = $meta['other_meta_tags'] ?? "";
    return [
        "<title>$title</title>",
        "<meta name='description' content='$description' />",
        "<meta name='keywords' content='$keywords' />",
        $other_meta_tags
    ];
}
// "<link rel='canonical' href='$canonical' />",

class Frontend
{
    public function handle(Request $request, Closure $next)
    {
        $slug = request()->getPathInfo();
        $slug = substr($slug, 1);
        $raw_meta = Metadata::where('url_slug', $slug)->first();
        $raw_meta = $raw_meta ? $raw_meta->toArray() : [];
        
        $request->merge([
            'universities' => University::with(['courses:id,course_name,course_short_name,course_type,course_duration,course_eligibility_short,course_slug,course_status', 'metadata:id,url_slug'])
                                ->where('univ_status', 1)
                                ->where('univ_detail_added', 1)
                                ->get(['id', 'univ_name', 'univ_slug', 'univ_logo', 'univ_state', 'univ_image', 'univ_type'])
                                ->toArray(),
            'state_univ' => State::with('universities')->get()->toArray(),
            'courses' => Course::with(['metadata:id,url_slug', 'universities:id,univ_type,univ_logo,univ_image,univ_slug,univ_status,univ_detail_added'])
                            ->where('course_detail_added', '1')
                            ->get(['id', 'course_name', 'course_short_name', 'course_type', 'course_slug', 'course_online','course_img'])
                            ->toArray(),
            'metadata' => get_meta($raw_meta),
            'raw_meta' => ['id' => $raw_meta['id'] ?? null, 'url_slug' => $raw_meta['url_slug'] ?? null],
        ]);

        return $next($request);
    }
}

