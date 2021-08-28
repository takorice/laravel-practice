import React, { useEffect, useState } from 'react';
import { BrowserRouter, Link, Redirect, Route, RouteProps, Switch } from 'react-router-dom';
import TaskPage from './pages/tasks';
import HelpPage from './pages/help';
import LoginPage from './pages/login';
import NotFoundPage from './pages/error';
import { useLogout, useUser } from './queries/AuthQuery';
import { useAuth } from './hooks/AuthContext';
import { BackTop, Layout, Menu, Spin } from 'antd';
import { HomeOutlined, UserOutlined, } from '@ant-design/icons';

const Router = () => {
    const logout = useLogout();
    const { isAuth, setIsAuth } = useAuth();
    const { isLoading, data: authUser } = useUser();
    const { Header, Content, Footer, Sider } = Layout;

    const [isCollapsed, setIsCollapsed] = useState<boolean>(true);

    useEffect(() => {
        if (authUser) {
            setIsAuth(true);
        }
    }, [authUser]);

    const GuardRoute = (props: RouteProps) => {
        if (!isAuth) {
            return <Redirect to="/login"/>;
        }
        return <Route {...props} />;
    };

    const LoginRoute = (props: RouteProps) => {
        if (isAuth) {
            return <Redirect to="/"/>;
        }
        return <Route {...props} />;
    };

    const onCollapse = () => {
        setIsCollapsed(!isCollapsed);
    };

    const navigation = (
        <Menu className={'header-menu-content'} theme="dark" mode="horizontal">
            <Menu.Item key="logout" icon={<UserOutlined/>} onClick={() => logout.mutate()}>
                ログアウト
            </Menu.Item>
        </Menu>
    );

    const loginNavigation = (
        <Menu className={'header-menu-content'} theme="dark" mode="horizontal">
            <Menu.Item key="logout" icon={<UserOutlined/>}>
                <Link to="/login">ログイン</Link>
            </Menu.Item>
        </Menu>
    );

    const siderMenu = () => {
        return (
            <Sider className={'sider-content'} collapsible collapsed={isCollapsed} onCollapse={onCollapse}>
                <div className="logo"/>
                <Menu theme="dark" mode="inline">
                    <Menu.Item key="task" icon={<HomeOutlined/>}>
                        <Link to="/">ホーム</Link>
                    </Menu.Item>
                </Menu>
            </Sider>
        );
    };

    if (isLoading) {
        return <Spin className={'loading-content'} tip="Loading..." size="large"/>;
    }

    return (
        <>
            <BackTop/>
            <BrowserRouter>
                <Layout>
                    {isAuth ? siderMenu() : null}
                    <Header className={'header-content'}>
                        <div className="logo"/>
                        {isAuth ? navigation : loginNavigation}
                    </Header>
                    <Layout>
                        <Content className="site-layout">
                            <div className="site-layout-background">
                                <Switch>
                                    <Route path="/help">
                                        <HelpPage/>
                                    </Route>
                                    <LoginRoute path="/login">
                                        <LoginPage/>
                                    </LoginRoute>
                                    <GuardRoute exact path="/">
                                        <TaskPage/>
                                    </GuardRoute>
                                    <Route component={NotFoundPage}/>
                                </Switch>
                            </div>
                        </Content>
                        <Footer style={{ marginTop: 'auto' }}> </Footer>
                    </Layout>
                </Layout>
            </BrowserRouter>
        </>
    );
};

export default Router;
