<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Metadata;
use Illuminate\Http\Request;


class MetadataConroller extends Controller
{
    function check_existBySlug($slug)
    {
        $page = Metadata::where("url_slug", $slug)->first();
        return count($page ? $page->toArray() : []) > 0;
    }
    
    function create_page($params)
    {
        return self::add_metadata($params);
    }

    private function add_metadata($params)
    {
        if (self::check_existBySlug($params['url_slug'])) {
            return ["success" => false, "msg" => "Slug Already Exists."];
        }
        $page = new Metadata($params);
        return ["success" => $page->save(), "slugId" => $page->id];
    }
   
}
