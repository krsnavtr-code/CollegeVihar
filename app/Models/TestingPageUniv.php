<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestingPageUniv extends Model
{
    use HasFactory;

    protected $table = 'testing_page_univ';

    protected $fillable = [
        // Fillable fields here
    ];

    protected $guarded = [
        'id',
    ];

}
