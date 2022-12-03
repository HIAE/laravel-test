<?php

namespace App\Http\Resources\Comment;

use App\Http\Resources\Idea\IdeaResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->uuid,
            'commentary' => $this->commentary,
            'user' => new UserResource($this->whenLoaded('user')),
            'idea' => new IdeaResource($this->whenLoaded('idea')),
        ];
    }
}
