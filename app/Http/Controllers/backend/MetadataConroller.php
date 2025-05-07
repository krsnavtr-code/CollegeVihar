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
    
    public function updateSlug(Request $request)
    {
        $request->validate([
            'old_slug' => 'required|string',
            'new_slug' => 'required|string|unique:metadata,url_slug',
        ]);

        try {
            // Start transaction to ensure data consistency
            \DB::beginTransaction();

            // Get the metadata record to update
            $metadata = Metadata::where('url_slug', $request->old_slug)->firstOrFail();
            
            // Update all references to the old slug in other tables
            // Update courses table
            \DB::table('courses')
                ->where('course_slug', $request->old_slug)
                ->update(['course_slug' => $request->new_slug]);
                
            // Update other tables that might reference this slug
            // Add more tables as needed
            
            // Update the metadata table
            $metadata->url_slug = $request->new_slug;
            $metadata->save();

            \DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Slug updated successfully',
                'new_slug' => $request->new_slug
            ]);
            
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update slug: ' . $e->getMessage()
            ], 500);
        }
    }
}
