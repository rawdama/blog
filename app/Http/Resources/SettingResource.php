<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        //to clean data and retrived it in a good format to front,controll data want to retrive
        $data=[
            'logo'=>asset($this->logo),
            'website-title'=>$this->title,
            'created'=>$this->created_at->format('Y-M-D'),
            'FACEBOOK'=>$this->facebook,
            'INSTAGRAM'=>$this->instagram,
        ];
        return $data;
    }
}
