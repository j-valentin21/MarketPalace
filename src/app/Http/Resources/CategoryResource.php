<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'identifier' => (int)$this->id,
            'title' => (string)$this->name,
            'details' => (string)$this->description,
            'creationDate' => (string)$this->created_at,
            'lastChange' => (string)$this->updated_at,
            'deletedDate' => isset($category->deleted_at) ? (string) $category->deleted_at : null,
        ];
    }
}
