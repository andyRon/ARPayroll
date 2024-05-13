<?php
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

// 用于在每次执行测试用例前后迁移/清理数据库
uses(Tests\TestCase::class, LazilyRefreshDatabase::class)->in('Feature');

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

function something()
{

}
