import * as api from '../api/TaskApi';

import { useMutation, useQuery, useQueryClient } from 'react-query';
import { toast } from 'react-toastify';
import { AxiosError } from 'axios';
import { Task } from '../types/Task';

const useTasks = () => {
    return useQuery<Task[]>('tasks', () => api.getTasks());
};

const useUpdateDoneTask = () => {
    const queryClient = useQueryClient();

    return useMutation(api.updateDoneTask, {
        onSuccess: () => {
            queryClient.invalidateQueries('tasks');
        },
        onError: () => {
            toast.error('更新に失敗しました。');
        }
    });
};

const useCreateTask = () => {
    const queryClient = useQueryClient();

    return useMutation(api.createTask, {
        onSuccess: () => {
            queryClient.invalidateQueries('tasks');
            toast.success('登録に成功しました。');
        },
        onError: (error: AxiosError) => {
            if (error.response?.data.errors) {
                Object.values(error.response?.data.errors).map(
                    (messages: any) => {
                        messages.map((message: string) => {
                            toast.error(message);
                        });
                    }
                );
            } else {
                toast.error('登録に失敗しました。');
            }
        }
    });
};

const useUpdateTask = () => {
    const queryClient = useQueryClient();

    return useMutation(api.updateTask, {
        onSuccess: () => {
            queryClient.invalidateQueries('tasks');
            toast.success('更新に成功しました。');
        },
        onError: (error: AxiosError) => {
            if (error.response?.data.errors) {
                Object.values(error.response?.data.errors).map(
                    (messages: any) => {
                        messages.map((message: string) => {
                            toast.error(message);
                        });
                    }
                );
            } else {
                toast.error('更新に失敗しました。');
            }
        }
    });
};

const useDeleteTask = () => {
    const queryClient = useQueryClient();

    return useMutation(api.deleteTask, {
        onSuccess: () => {
            queryClient.invalidateQueries('tasks');
            toast.success('削除に成功しました。');
        },
        onError: () => {
            toast.error('削除に失敗しました。');
        }
    });
};

export {
    useTasks,
    useUpdateDoneTask,
    useCreateTask,
    useUpdateTask,
    useDeleteTask
};
