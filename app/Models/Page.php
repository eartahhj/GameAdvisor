<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_it', 'title_en', 'html_it', 'html_en', 'url_it', 'url_en', 'user_creator_id'
    ];
}
