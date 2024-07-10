<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\QueryScopes;

class UserCatalogue extends Model
{
    use HasFactory, SoftDeletes, QueryScopes;

    protected $fillable = [
        'name',
        'description',
        'publish',
    ];

    protected $table = 'user_catalogues';

    public function users()
    {
        //HasMany: phương thức của Eloquent để thiết lập mối quan hệ "một nhiều" (one-to-many)
        return $this->hasMany(User::class, 'user_catalogue_id', 'id');

        //Cho phép bạn lấy tất cả các bản ghi của đối tượng User mà có user_catalogue_id bằng với id của đối tượng hiện tại
    }



    // public function permissions(){
    //     return  $this->belongsToMany(Permission::class, 'user_catalogue_permission' , 'user_catalogue_id', 'permission_id');
    // }
}
