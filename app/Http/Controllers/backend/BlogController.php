<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Metadata;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    protected const IMG_PATH = parent::IMG_PATH . "blogs/";
    
    function ui_view_blogs()
    {
        $data = ["blogs" => Blog::all()];
        return view("admin.blog.view_blogs", $data);    
    }
    function ui_editor()
    {
        return view("admin.blog.editor");
    }



    function web_editor(Request $request)
    {
        $params = [
            "webpage_params" => [
                "url_slug" => 'blogs/' . $request->page_slug,
                "meta_title" => $request->page_title,
                "meta_h1" => $request->page_head,
                "meta_description" => $request->page_desc,
                "meta_keywords" => $request->page_keywords,
                "other_meta_tags" => $request->other_meta
            ],
            "blog_params" => [
                "blog_title" => $request->blog_title,
                "blog_author" => $request->blog_author,
                "blog_content" => $request->blog_content,
                "blog_pic" => $request->blog_pic,
            ]
        ];
        session()->flash("success", self::editor($params)['success']);
        return redirect()->back();
    }

    private function editor($params)
    {

        $webpage = new MetadataConroller();
        $result = $webpage->create_page($params['webpage_params']);
        if ($params['blog_params']['blog_pic']) {
            $moved = $this->move_file($params['blog_params']['blog_pic']);
            $params['blog_params']['blog_pic'] = $moved['filename'];
        }
        if ($result['success']) {
            $blog = new Blog($params['blog_params']);
            $blog->slug_id = $result['slugId'];
            return ["success" => $blog->save()];
        }
    }
}
