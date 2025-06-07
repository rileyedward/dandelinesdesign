<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageView extends Model
{
    protected $table = 'page_views';

    protected $fillable = [
        'session_id',
        'ip_address',
        'user_agent',
        'url',
        'referrer',
    ];
}
