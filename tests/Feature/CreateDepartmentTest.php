<?php

use App\Models\Department;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use function Pest\Laravel\postJson;

//it('has createdepartment page', function () {
//    $response = $this->get('/createdepartment');
//
//    $response->assertStatus(200);
//});

// 测试部门创建接口是否可以调用成功：
it('should create a department', function () {
    // 创建部门接口需要认证
    Sanctum::actingAs(User::factory()->create(), ['*']);
    // 调用 API 接口
    $department = postJson(route('departments.store'), [
        'name' => 'Development',
        'description' => 'Awesome developers across the board!',
    ])->json('data');

    // TODO
    // 断言响应数据
    expect($department)
        ->toHaveAttribute('name')->toBe('Development')
        ->toHaveAttribute('description')->toBe('Awesome developers across the board!');
});

//it('should return 422 if name is invalid', function (?string $name) {
//    Sanctum::actingAs(User::factory()->create(), ['*']);
//
//    // 通过模型工厂先创建一个同名部门
//    Department::factory([
//        'name' => 'Development',
//    ])->create();
//
//    // 通过 assertInvalid 方法断言 name 是否校验不通过
//    postJson(route('departments.store'), [
//        'name' => $name,
//        'description' => 'description',
//    ])->assertInvalid(['name']);
//})->with([
//    '',
//    null,
//    'Development'
//]); // 传递不同值作为 $name 参数进行测试
