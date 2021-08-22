<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperTaskStatus
 */
class TaskStatus extends Model
{
    use HasFactory;

    public const DRAFT = 1; // 下書き
    public const DOING = 2; // 着手中
    public const PENDING = 3; // 保留
    public const DONE = 4; // 完了
}
