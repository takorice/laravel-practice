import React, { useState } from 'react';
import { useLogin } from '../../queries/AuthQuery';
import { Button, Form, Input } from 'antd';
import { LockOutlined, UserOutlined } from '@ant-design/icons';

const LoginPage: React.VFC = () => {
    const login = useLogin();
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');

    const handleLogin = (values: Object) => {
        login.mutate({ email, password });
    };
    return (
        <>
            <Form
                name="login"
                className="login-form"
                initialValues={{ remember: true }}
                onFinish={handleLogin}
            >
                <Form.Item
                    name="email"
                    rules={[{ required: true, message: 'Please input your Email address!' }]}
                >
                    <Input
                        type="email"
                        prefix={<UserOutlined className="site-form-item-icon"/>}
                        placeholder="e-mail address"
                        value={email}
                        onChange={e => setEmail(e.target.value)}
                    />
                </Form.Item>
                <Form.Item
                    name="password"
                    rules={[{ required: true, message: 'Please input your Password!' }]}
                >
                    <Input
                        prefix={<LockOutlined className="site-form-item-icon"/>}
                        type="password"
                        placeholder="Password"
                        value={password}
                        onChange={e => setPassword(e.target.value)}
                    />
                </Form.Item>
                <Form.Item>
                    <Button type="primary" htmlType="submit" className="login-form-button">
                        Log in
                    </Button>
                </Form.Item>
            </Form>
        </>
    );
};

export default LoginPage;
