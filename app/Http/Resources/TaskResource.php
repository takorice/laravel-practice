<?php

namespace App\Http\Resources;

use App\Models\Task;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Task $this */
        return [
            'id'      => $this->id,
            'title'   => $this->title,
            'task'    => $this->task,
            'is_done' => $this->is_done, // accessor
        ];
    }
}
