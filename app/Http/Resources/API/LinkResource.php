<?php

namespace App\Http\Resources\API;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

/**
 * @mixin Link
 */
class LinkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => 'id',
            'url' => URL::to("links/$this->short_code"),
            'title' => $this->title,
            'tags' => $this->whenLoaded('tags', fn () => $this->tags->pluck('name')),
        ];
    }
}
