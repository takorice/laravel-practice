import React, { useState } from 'react';
import { useCreateTask } from '../../../queries/TaskQuery';
import { Button, Form, Input } from 'antd';

const TaskInput: React.VFC = () => {
    const [title, setTitle] = useState('');
    const createTask = useCreateTask();

    const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
        createTask.mutate(title);
        setTitle('');
    };

    return (
        <div className="inner">
            <Form className="task-form" layout="inline" onFinish={handleSubmit}>
                <Form.Item label="新しいタスク" >
                    <Input
                        name="new-task"
                        className="task-form-input"
                        placeholder="TODOを入力してください。"
                        value={title}
                        onChange={(e) => setTitle(e.target.value)}
                    />
                </Form.Item>
                <Form.Item className="task-form-submit">
                    <Button type="primary" htmlType="submit">追加</Button>
                </Form.Item>
            </Form>
        </div>
    );
};

export default TaskInput;
