<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Setting extends Model implements  TranslatableContract
{
    use HasFactory;
    use Translatable;
    public $translatedAttributes = ['title', 'content', 'address'];
    protected $fillable = ['id', 'logo', 'favicon', 'facebook', 'instagram', 'phone',
    'email', 'created_at', 'updated_at', 'deleted_at'];
    //chech if there is setting exsists and its id=1 then it will return this setting if it doesnt exsist you can create new settings
    public static function checkSettings()
    {
        $settings = Self::all();
        if (count($settings) < 1) {
            $data = [
                'id' => 1,
            ];
            foreach (config('app.languages') as $key => $value) {
                $data[$key]['title'] = $value;
            }
            Self::create($data);
        }

        return Self::first();
    }

    }

