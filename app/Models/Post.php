<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use App\Models\Category;
use App\Models\User;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;
use Illuminate\Database\Eloquent\softDeletes;

class Post extends Model implements  TranslatableContract
{ 
    use Translatable,softDeletes;
    public $translatedAttributes = ['title', 'content' , 'smallDesc','tags' ];
    protected $fillable = ['id', 'image', 'category_id', 'created_at', 'updated_at', 'deleted_at' ,'user_id' ];
    use HasFactory;
    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
