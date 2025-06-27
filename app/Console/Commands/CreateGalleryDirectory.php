<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateGalleryDirectory extends Command
{
    protected $signature = 'gallery:create-directory';
    protected $description = 'Create the gallery directory if it does not exist';

    public function handle()
    {
        $galleryPath = public_path('images/university/gallery');
        
        if (!File::exists($galleryPath)) {
            File::makeDirectory($galleryPath, 0755, true, true);
            $this->info('Gallery directory created successfully!');
        } else {
            $this->info('Gallery directory already exists.');
        }
        
        return 0;
    }
}
