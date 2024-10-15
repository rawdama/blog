<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'image'=>asset($this->image),
            'created'=>$this->created_at->format('Y-M-D'),
            'title'=>$this->title,
            'content'=>$this->content,
            'smallDesc'=>$this->smallDesc,
            'writer'=>$this->whenLoaded('user'),
            
            
                
        ];
    }
}
