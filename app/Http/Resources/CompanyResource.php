<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'phone_number' => $this->phone_number,
            'average_rating' => $this->averageRating(),
            'count_comment' => $this->countComment(),
            'comments' => $this->whenLoaded('comments', function () {
                return CommentResource::collection($this->comments->load('user'));
            }),
        ];
    }
}
