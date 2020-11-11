<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\TaskResource;
use App\Http\Resources\GetAllListsResource;

class GetOneListResource extends JsonResource
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
            'id' => $this['taskList']->id,
            'name' => $this['taskList']->name,
            'is_opened' => $this['taskList']->is_opened,
            'created_at' => $this['taskList']->created_at->format('d/m/Y H:i'),
            'updated_at' => $this['taskList']->updated_at->format('d/m/Y H:i'),
            'tasks' => TaskResource::collection($this['tasks']),
            'sub_lists' => GetAllListsResource::collection($this['sublists']),
        ];
    }
}
