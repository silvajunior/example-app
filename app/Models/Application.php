<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'position', 'education', 'observations', 'file_path', 'submitted_at', 'ip_address',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
    ];
}
