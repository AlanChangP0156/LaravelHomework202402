<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = new UserResource($this->whenLoaded('user'));
        //$company = new CompanyResource($this->company);
        return [
            'id' => $this->id,
            'rating' => $this->rating,
            'comment' => $this->comment,
            'user_name' => $user->name ?? $this->user_id ,
            'company_id' => $this->company_id,
            'updated_at' => $this->updated_at->toDateTimeString(),  //加上toDateTimeString，會自動轉為設定的時區顯示
        ];
    }
}
