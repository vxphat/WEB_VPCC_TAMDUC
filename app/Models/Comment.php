<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'post_id',
        'user_id',
    ];

    protected $table = 'comments';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
