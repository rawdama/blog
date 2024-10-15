<?php

namespace App\Http\Resources;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
       //resource deal with one thing  instead we use collection
       return [
        'id'=>$this->id,
        'image'=>asset($this->logo),
        'created'=>$this->created_at->format('Y-M-D'),
        'parent'=>$this->parent,
        'title'=>$this->title,
        'children'=>CategoryCollection::make($this->whenLoaded('children')),
        'posts'=>PostResource::collection($this->whenLoaded('posts')),
        
            
    ];
    
    }
}
