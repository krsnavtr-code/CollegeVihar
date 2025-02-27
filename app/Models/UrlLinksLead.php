<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrlLinksLead extends Model
{
    use HasFactory;

    protected $table = 'url_links_leads';
    public $timestamps = false;

    protected $fillable = [
        'agent_name',
        'social_media_link_1',
        'social_media_link_2',
        'social_media_link_3',
        'social_media_link_4',
        'job_opening_link',
        'linkedin_profile_link_1',
        'linkedin_profile_link_2',
        'linkedin_profile_link_3',
        'linkedin_profile_link_4',
        'linkedin_profile_link_5',
        'linkedin_profile_link_6',
        'linkedin_profile_link_7',
        'linkedin_profile_link_8',
        'linkedin_profile_link_9',
        'linkedin_profile_link_10'
    ];
}
