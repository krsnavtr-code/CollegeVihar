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
    // Set default values
    $siteName = 'CollegeVihar';
    $baseUrl = url('/');
    $currentUrl = url()->current();
    
    // Process title
    $title = $meta['meta_title'] ?? "$siteName - Online Education Courses";
    $title = mb_strlen($title) > 60 ? mb_substr($title, 0, 57) . '...' : $title;
    
    // Process description
    $description = $meta['meta_description'] ?? "Explore top Online UG/PG courses at CollegeVihar. Compare universities, flexible study options, and career-focused programs.";
    $description = mb_strlen($description) > 160 ? mb_substr($description, 0, 157) . '...' : $description;
    
    // Default image
    $image = $meta['og_image'] ?? $baseUrl . '/images/web assets/logo_mini.jpeg';
    
    // Keywords
    $keywords = $meta['meta_keywords'] ?? "online courses, distance education, degree programs, online learning, college vihar, online certification";
    
    // Other meta
    $canonical = $meta['meta_canonical'] ?? $currentUrl;
    $other_meta_tags = $meta['other_meta_tags'] ?? "";
    
    // Generate meta tags
    $tags = [
        // Basic Meta
        "<title>$title</title>",
        "<meta name='description' content='$description' />",
        "<meta name='keywords' content='$keywords' />",
        
        // Canonical
        "<link rel='canonical' href='$canonical' />",
        
        // Open Graph / Facebook
        "<meta property='og:type' content='website' />",
        "<meta property='og:site_name' content='$siteName' />",
        "<meta property='og:title' content='$title' />",
        "<meta property='og:description' content='$description' />",
        "<meta property='og:url' content='$currentUrl' />",
        "<meta property='og:image' content='$image' />",
        "<meta property='og:image:width' content='1200' />",
        "<meta property='og:image:height' content='630' />",
        
        // Twitter Card
        "<meta name='twitter:card' content='summary_large_image' />",
        "<meta name='twitter:title' content='$title' />",
        "<meta name='twitter:description' content='$description' />",
        "<meta name='twitter:image' content='$image' />",
        
        // Additional Meta
        $other_meta_tags
    ];
    
    return $tags;
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

