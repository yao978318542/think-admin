<?php

declare(strict_types=1);

/*
 * This file is part of TAnt.
 * @link     https://github.com/edenleung/think-admin
 * @document https://www.kancloud.cn/manual/thinkphp6_0
 * @contact  QQ Group 996887666
 * @author   Eden Leung 758861884@qq.com
 * @copyright 2019 Eden Leung
 * @license  https://github.com/edenleung/think-admin/blob/6.0/LICENSE.txt
 */

use think\facade\Route;
use xiaodi\JWTAuth\Middleware\Jwt;
use app\admin\middleware\Permission;

Route::get('/', function () {
    return 'Hello,ThinkPHP6!';
});

Route::get('/hello', function () {
    return 'Hello,ThinkPHP6!';
});

Route::group('/auth', function () {
    Route::post('/login', 'auth/login');
    Route::post('/logout', 'auth/logout');
    Route::get('/refresh_token', 'auth/refreshToken');
});

// 规则
Route::group('/permission', function () {
    Route::rule('/', 'system.permission/list', 'GET')->middleware(Permission::class, 'PermissionGet');
    Route::rule('/', 'system.permission/create', 'POST')->middleware(Permission::class, 'PermissionAdd');
    Route::rule('/:id', 'system.permission/update', 'PUT')->middleware(Permission::class, 'PermissionUpdate');
    Route::rule('/:id', 'system.permission/delete', 'DELETE')->middleware(Permission::class, 'PermissionDelete');
})->middleware(Jwt::class);

// 角色
Route::group('/role', function () {
    Route::rule('/', 'system.role/list', 'GET')->middleware(Permission::class, 'RoleGet');
    Route::rule('/', 'system.role/create', 'POST')->middleware(Permission::class, 'RoleAdd');
    Route::rule('/all$', 'system.role/all', 'GET');
    Route::rule('/:id$', 'system.role/update', 'PUT')->middleware(Permission::class, 'RoleUpdate');
    Route::rule('/:id$', 'system.role/delete', 'DELETE')->middleware(Permission::class, 'RoleDelete');
    Route::rule('/:id/mode', 'system.role/mode', 'PUT');
})->middleware(Jwt::class);

// 用户
Route::group('/user', function () {
    Route::rule('/data', 'system.user/data', 'GET');
    //获取 个人信息
    Route::rule('/current$', 'system.user/current', 'GET');
    //更新 个人信息
    Route::rule('/current$', 'system.user/updateCurrent', 'PUT');
    //更新 头像
    Route::rule('/avatar$', 'system.user/avatar', 'POST');
    //更新 密码
    Route::rule('/reset-password$', 'system.user/resetPassword', 'PUT');
    Route::rule('/', 'system.user/list', 'GET')->middleware(Permission::class, 'AccountGet');
    Route::rule('/', 'system.user/create', 'POST')->middleware(Permission::class, 'AccountAdd');
    Route::rule('/info$', 'system.user/info', 'GET');
    Route::rule('/:id', 'system.user/update', 'PUT')->middleware(Permission::class, 'AccountUpdate');
    Route::rule('/:id', 'system.user/delete', 'DELETE')->middleware(Permission::class, 'AccountDelete');
    Route::rule('/:id', 'system.user/getInfo', 'GET');
})->middleware(Jwt::class);

// 日志
Route::group('/log', function () {
    Route::rule('/acount', 'log.AccountLog/list', 'GET')->middleware(Permission::class, 'LogAccountGet');
    Route::rule('/acount', 'log.AccountLog/delete', 'DELETE')->middleware(Permission::class, 'LogAccountDelete');
    Route::rule('/db', 'log.DataBaseLog/list', 'GET')->middleware(Permission::class, 'LogDbGet');
    Route::rule('/db', 'log.DataBaseLog/delete', 'DELETE')->middleware(Permission::class, 'LogDbDelete');
})->middleware(Jwt::class);

Route::group('/system', function () {
    Route::rule('/dept', 'system.dept/list', 'GET')->middleware(Permission::class, 'DeptGet');
    Route::rule('/dept', 'system.dept/create', 'POST')->middleware(Permission::class, 'DeptAdd');
    Route::rule('/dept/:id', 'system.dept/update', 'PUT')->middleware(Permission::class, 'DeptUpdate');
    Route::rule('/dept/:id', 'system.dept/delete', 'DELETE')->middleware(Permission::class, 'DeptDelete');

    Route::rule('/post', 'system.post/create', 'POST')->middleware(Permission::class, 'PostAdd');
    Route::rule('/post', 'system.post/all', 'GET')->middleware(Permission::class, 'PostGet');
    Route::rule('/post/:id', 'system.post/update', 'PUT')->middleware(Permission::class, 'PostUpdate');
    Route::rule('/post/:id', 'system.post/delete', 'DELETE')->middleware(Permission::class, 'PostDelete');
})->middleware(Jwt::class);

Route::group('/article', function () {
    Route::get('/category$', 'system.articleCategory/list');
    Route::post('/category$', 'system.articleCategory/create');
    Route::put('/category/:id$', 'system.articleCategory/update');
    Route::delete('/category/:id$', 'system.articleCategory/delete');

    Route::get('/', 'system.article/list');
    Route::get('/:id$', 'system.article/info');
    Route::post('/', 'system.article/create');
    Route::put('/:id', 'system.article/update');
    Route::delete('/:id', 'system.article/delete');
})->middleware(Jwt::class);

// 模拟数据（可删除）
Route::group('/mock', function () {
    Route::rule('/list/search/projects', 'mock/projects', 'GET');
    Route::rule('/workplace/activity', 'mock/activity', 'GET');
    Route::rule('/workplace/radar', 'mock/radar', 'GET');
    Route::rule('/workplace/teams', 'mock/teams', 'GET');
});
