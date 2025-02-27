<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Metadata;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    function get_blogsBySlug($slug){
        
    $webpage = Metadata::where("url_slug", "blogs/" . "$slug")->first();


    if (!$webpage) {
        return ["success" => false, "blog" => null];
    }

    $blog = Blog::with(['metadata'])->where('slug_id', $webpage->id)->first();

    if (!$blog) {
        return ["success" => false, "blog" => null];
    }
    return ["success" => true, "blog" => $blog->toArray()];
    }

 
    function ui_view_blogs()
    {
        $data = [
            "blogs" => Blog::with(['metadata:id,url_slug'])->get()->toArray(),
            "recent" => Blog::with(['metadata:id,url_slug'])->orderBy("created_on", "DESC")->limit(4)->get()->toArray(),
        ];
        return view('user.blog.view_blogs', $data);
    }
    
    function ui_view_blog($slug){
    // dd($slug);
    $blogData = self::get_blogsBySlug($slug);

    if (!$blogData['success']) {
        abort(404);
    }

    $data = [
        "blog" => $blogData['blog'],
        "recent" => Blog::with(['metadata:id,url_slug'])->orderBy("created_on", "DESC")->limit(3)->get()->toArray(),
    ];

    return view('user.blog.view_blog', $data);
    }


}
