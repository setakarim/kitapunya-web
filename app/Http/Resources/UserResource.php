<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UsersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        $path_photo = null;

        if ($this->file_name != null) {
            $path_photo = 'http://kitapunya.setakarim.xyz/uploads/profile/'.$this->file_name;
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'path_photo' => $path_photo,
        ];
    }
}
