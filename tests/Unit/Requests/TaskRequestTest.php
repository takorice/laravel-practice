<?php

namespace Tests\Unit\Requests;

use App\Http\Requests\TaskRequest;
use Tests\TestCase;
use Tests\Unit\Requests\Traits\RequestAssertions;

class TaskRequestTest extends TestCase
{
    use RequestAssertions;

    public function testTitleValidation(): void
    {
        $this->assertFieldPass((new TaskRequest()), 'title', [
            ''      => false,
            'title' => true,
        ]);
        $this->assertFieldError((new TaskRequest()), 'title', [
            ''                   => 'タイトルは、必ず指定してください。',
            str_repeat('a', 256) => 'タイトルは、255文字以下にしてください。',
        ]);
    }
}
