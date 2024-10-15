<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
USE  App\Models\Setting;
USE  App\Models\Category;
USE  App\Models\Post;
use App\Models\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //بعرف امرر الداتا لكل الموقع
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
        $settings=Setting::checkSettings();
        $categories = Category::with('children')->where('parent' , 0)->orWhere('parent' , null)->get();
        $lastFivePosts = Post::with('category','user')->orderBy('id')->limit(5)->get();
        View()->share([
            'setting'=>$settings,
            'categories'=>$categories,
            'lastFivePosts'=>$lastFivePosts,

            
        ]);
    }
}
