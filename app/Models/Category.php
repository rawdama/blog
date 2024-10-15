<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use App\Models\Post;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;

class Category extends Model implements  TranslatableContract //interface
{
    use Translatable;
    //translatable implements all methods inside thar interface
    use HasFactory;
    public $translatedAttributes = ['title', 'content'];
    protected $fillable = [ 'id', 'image', 'parent', 'created_at', 'updated_at', 'deleted_at'];
    
    //mdel between tables and its self,each category have parent and child
    public function getParent()
    {
        return $this->belongsTo(Category::class,'parent');
    }
    
    public function children()
    {
        return $this->hasMany(Category::class,'parent');
    }
    public function posts(){
        return $this->hasMany(Post::class);
    }


}
