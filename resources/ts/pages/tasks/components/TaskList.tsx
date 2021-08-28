import React, { useState } from 'react';
import { useDeleteTask, useTasks, useUpdateDoneTask, useUpdateTask } from '../../../queries/TaskQuery';
import { Button, Checkbox, Form, Input, Popconfirm, Space, Spin, Table, Tag } from 'antd';
import { Task } from '../../../types/Task';
import { toast } from 'react-toastify';

const TaskList: React.VFC = () => {
    const [form] = Form.useForm();
    const [editingKey, setEditingKey] = useState(0);
    const [editTitle, setEditTitle] = useState<string | undefined>(undefined);

    const { data: tasks, status } = useTasks();
    const updateTask = useUpdateTask();
    const updateDoneTask = useUpdateDoneTask();
    const deleteTask = useDeleteTask();

    const isEditing = (task: Task) => task.id === editingKey;

    const handleInputChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        setEditTitle(e.target.value);
    };

    const handleUpdate = (task: Task) => {
        if (!editTitle) {
            toast.error('タイトルを入力してください');
            return;
        }

        const newTask = { ...task };
        newTask.title = editTitle;

        updateTask.mutate({
            id: task.id,
            task: newTask
        });

        setEditTitle(undefined);
        setEditingKey(0);
    };

    const handleOnKey = (e: React.KeyboardEvent<HTMLInputElement>) => {
        if (['Escape', 'Tab'].includes(e.key)) {
            setEditTitle(undefined);
        }
    };

    const edit = (task: Partial<Task> & { id: React.Key }) => {
        form.setFieldsValue({ title: '', ...task });
        setEditingKey(task.id);
    };

    const cancel = () => {
        setEditingKey(0);
    };

    const columns = [
        // チェックボックス
        {
            title: '',
            key: 'task-list-check-box',
            render: (task: Task) => (
                <Checkbox checked={task.is_done} onChange={() => updateDoneTask.mutate(task)}/>
            )
        },
        // ステータス
        {
            title: 'ステータス',
            key: 'task-list-status',
            render: (task: Task) => (
                task.is_done
                    ? <Tag color="cyan">完了</Tag>
                    : <Tag color="magenta">未完了</Tag>
            )
        },
        // TODOのタイトル
        {
            title: 'TODO',
            dataIndex: 'title',
            width: '60%',
            key: 'task-list-title',
            editable: true,
            render: (dataIndex: string, task: Task) => {
                const editable = isEditing(task);

                return editable ? (
                    <Form.Item
                        name={dataIndex}
                        style={{ margin: 0 }}
                        rules={[
                            {
                                required: true,
                                message: `必須項目です`,
                            },
                        ]}
                    >
                        <Input
                            defaultValue={dataIndex}
                            onChange={handleInputChange}
                            onKeyDown={handleOnKey}
                        />
                    </Form.Item>
                ) : (
                    dataIndex
                );
            }
        },
        // アクションボタン
        {
            title: '',
            key: 'task-list-actions',
            render: (task: Task) => {
                const editable = isEditing(task);

                return editable ? (
                    <>
                        <Space>
                            <Popconfirm title="編集をキャンセルしますか？" onConfirm={cancel}>
                                <a style={{ fontSize: '12px' }}>キャンセル</a>
                            </Popconfirm>
                            <Button type="primary" onClick={() => handleUpdate(task)} htmlType="submit">保存</Button>
                        </Space>
                    </>
                ) : (
                    <>
                        <Space>
                            <Button disabled={editingKey !== 0} onClick={() => edit(task)}>編集</Button>
                            <Popconfirm title="削除してもよろしいですか？" onConfirm={() => deleteTask.mutate(task.id)}>
                                <Button disabled={editingKey !== 0} danger>削除</Button>
                            </Popconfirm>
                        </Space>
                    </>
                );
            }
        }
    ];

    if (status === 'loading') {
        return <Spin className={'loading-content'} tip="Loading..." size="large"/>;
    } else if (status === 'error') {
        return <div className="align-center">データの読み込みに失敗しました。</div>;
    } else if (!tasks || tasks.length <= 0) {
        return <div className="align-center">登録されたタスクはありません。</div>;
    }

    return (
        <>
            <div className="inner">
                <Form form={form} component={false}>
                    <Table columns={columns} dataSource={tasks} rowKey="id"/>
                </Form>
            </div>
        </>
    );
};

export default TaskList;
