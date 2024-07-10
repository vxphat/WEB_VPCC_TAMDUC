<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;
use App\Traits\QueryScopes;

class PostCatalogue extends Model
{
    use HasFactory, SoftDeletes, QueryScopes;

    protected $fillable = [
        'name',
        'description',
        'canonical',
        'parent_id',
        'lft',
        'rgt',
        'level',
        'order',
        'image',
    ];

    protected $table = 'post_catalogues';

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_catalogue_post', 'post_catalogue_id', 'post_id');
    }

    public static function isNodeCheck($id = 0)
    {
        $postCatalogue = PostCatalogue::find($id);

        //Kiểm tra giá trị rgt - lft
        if ($postCatalogue->rgt - $postCatalogue->lft !== 1) {
            return false;
        }

        return true;

    }
}
