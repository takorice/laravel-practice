<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperTask
 */
class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'task',
        'task_status_id',
        'assigned_user_id',
    ];

    /**
     * is_done
     * @return bool
     */
    public function getIsDoneAttribute()
    {
        return $this->task_status_id === TaskStatus::DONE;
    }
}
