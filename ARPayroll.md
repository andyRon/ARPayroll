薪酬系统API
----

https://laravelacademy.org/books/test-driven-apis-with-laravel



简单的薪资系统CRM

### CRM API 整体设计

CRM 系统主要包含三个功能模块：

- 部门
- 员工（国外分工薪员工和小时工，其中工薪员工按年薪/12每月发放，小时工按工作日志统计的时长*时薪每月发送）
- 支付

#### 用户故事

任何项目/需求开始写代码之前，都要经过整体技术方案设计，以及涉及到的技术栈的调研和准备工作，让编码工作在预设方案内执行，而不是想到什么写什么，让研发流程变成一团乱麻，最后失控。对于大型项目，目前比较流行通过领域驱动设计进行架构设计，对于本项目，由于比较简单，我们可以简化流程，但是必要的设计也是不可或缺的。

我们将从用户故事出发，将用户故事转化为业务需求：

| 名称         | 描述                                                         |
| ------------ | ------------------------------------------------------------ |
| 创建部门     | 用户可以通过名称和描述信息创建一个新的部门                   |
| 更新部门     | 用户可以更新已存在的部门信息                                 |
| 获取部门列表 | 用户可以查看所有部门列表                                     |
| 查看部门详情 | 用户可以查看指定部门详情，在部门详情页可以展示该部门下的所有员工 |
|              |                                                              |
| 创建员工     | 用户可以创建新员工                                           |
| 更新员工     | 用户可以更新已存在的员工                                     |
| 获取员工列表 | 用户可以查看所有员工列表，并进行筛选                         |
| 查看员工详情 | 用户可以查看指定员工详情，需要列出该员工所有薪资支付记录     |
| 删除员工     | 用户可以删除员工，同时删除关联的支付记录和工作时长日志（小时工） |
|              |                                                              |
| 支付日支付   | 在每月支付日为每个员工进行薪资校验、支付薪资（以创建薪资支票方式） |

这里面的核心业务逻辑是薪资支付：

- 每个员工根据类型有不同的支付方式，工薪员工按年薪/12发放，小时工按工作时长*时薪发放（按月支付）
- 小时工会关联工作时长日志，用于统计工作时长
- 在每月的支付日，我们需要为每个员工核验计算正确的薪资金额，创建对应的薪资支票（也就是发放工资）

#### 数据库设计

对于这个简单的项目，不需要搞什么领域划分、领域模型了，基于上面的业务需求和功能模块，直接设计底层数据库就好了，在小型项目中，数据模型和领域模型是一体的，不同数据模型的属性、关联关系如下所示：

```yaml
department:
  description: It holds information about a department inside a company
  attributes:
    - name
    - description
  relationships:
    - employees: A department has many employees
    - paychecks: A department has many paychecks through employees

employee:
  description: It holds information about an employee and his / her salary
  attributes:
    - full_name
    - email
    - department_id
    - job_title
    - payment_type:
        - salary
        - hourly_rate
    - salary: Only if payment_type is salary
    - hourly_rate: Only if payment_type is hourly_rate
  relationships:
    - department: An employee belongs to a department
    - paychecks: An employee has many paychecks
    - time_logs: An employee has many time_logs

paycheck:
  description: It holds information about an employee paycheck
  attributes:
    - employee_id
    - net_amount
    - payed_at
  relationships:
    - employee: A paycheck belongs to an employee

time_logs:
  description: Time tracked by an employee
  attributes:
    - employee_id
    - started_at
    - stopped_at
    - minutes
  relationships:
    - employee: A time_log belongs to an employee
```

#### 代码设计

这个系统虽然不复杂，但仍然有一些值得设计的地方：

- 浮点数处理优化：薪水（精确到分）、时间（分钟）可以通过调整单位将浮点数转化为整型处理，避免浮点数精度问题，这里可以引入值对象进行处理
- 两种支付类型的支付处理：可以引入枚举、工厂、策略模式让代码更优雅，扩展性和复用性更好
- 时间字段遵循 Laravel 默认设置 `xxx_at`，看起来更贴近实际语义

#### API 设计

每个用户故事都可以转化为一个对应的 API 接口：

```sh
POST /departments                                 # 新建部门
PUT /departments                                  # 更新部门
GET /departments                                  # 获取部门列表
GET /departments/{department}                     # 获取指定部门
GET /departments/{department}/employees           # 获取指定部门下的所有员工

POST /employees                                   # 新建员工
PUT /employees                                    # 更新员工
GET /employees                                    # 获取员工列表
GET /employees/{employee}                         # 获取指定员工
DELETE /employees/{employee}                      # 删除指定员工
GET /employees/{employee}/payhecks                # 获取指定员工支付记录

POST /payday                                      # 创建支付日检查、薪资支付
```

#### 测试框架

将使用 [Pest](https://pestphp.com/) 替代默认的 [PHPUnit](https://phpunit.de/)。对比

```php
/** @test */
public function it_should_return_an_employee()
{
    $employee = $this->getJson(route('emplyoees'))->json('data');
    
    $this->assertEquals('John Doe', $employee['name']);
    $this->assertEquals('salary', $employee['payment']['type']);
    $this->assertEquals('$50,000', $employee['payment']['amount']['dollars']);
}
```

Pest 测试:

```php
it('should return an employee', function () {
    $employee = getJson(route('emplyoees'))->json('data');
    
    expect($employee)
        ->name->toBe('John Doe')
        ->payment->type->toBe('salary')
        ->payment->amount->dollars->toBe('$50,000');
});
```

相比 PHPUnit 这种传统的单元测试代码风格，Pest 的链式调用使用起来更直观，更贴近行为驱动测试，更重要的，它可以和用户故事紧密结合，很自然的完成所有用户故事的验收，让团队除开发人员以外的更多人参与到测试验收环节中。



> 简而言之，`laravel-shift/blueprint` 是一个代码生成工具，用于自动化生成 Laravel 应用程序的多个组件，而 `\Illuminate\Database\Schema\Blueprint` 是 Laravel 内置的一个类，用于在数据库迁移中定义数据库表的结构。两者都与 Laravel 应用程序的构建有关，但它们的应用场景和具体功能是不同的。



#### 关于DDD

现在很多中大型项目都流行通过领域驱动设计（Domain-Driven Design，简称DDD）完成架构设计，对于这个小项目，不需要那么重的设计，但是也可以把一些好的 DDD 理念引入进来，锦上添花：

- Value Objects（值对象）: 通过封装到对象来处理标量数据，让标量数据从单一的数值演进到具备更多行为，例如，我们可以将金额值封装为一个 Money 对象，这样就可以提供行为方法将金额转化为不同单位币种的字符串展示格式了。
- Data Transfer Objects(DTO): PHP成也数组，败也数组，在大型项目中，所有方法参数、返回值都是数组类型的话维护起来是灾难性的，你永远不知道这些非结构化的参数、返回值里面具体包含什么数据，你一定很熟悉那些 `undefined index` 报错吧。为此，我们可以通过把关联数组转化为 DTO 对象，从而方便处理关联数组表示的参数、返回值，让代码语义性更好，维护起来也更省心。
- Actions: 这个不是 DDD 中的概念，实际上是 Laravel 提供的一个特性，我们可以**将所有用户故事表示为独立可复用的类**，封装到 Action 中，这是一种单一职责的设计原则体现，也是避免“胖服务”的有效方式。



### 项目初始化



```sh
composer create-project laravel/laravel ARPayroll  10.x

composer require timacdonald/json-api:'v1.*'

composer require spatie/laravel-query-builder
php artisan vendor:publish --provider="Spatie\QueryBuilder\QueryBuilderServiceProvider" --tag="query-builder-config"
```



```sh
composer require --dev laravel-shift/blueprint

php artisan blueprint:new --config
```





```sh
php artisan blueprint:build
```



```sh
php artisan migrate
```







#### UUID

```sh
composer require ramsey/uuid
```



#### 配置 Pest

```sh
composer require pestphp/pest --dev --with-all-dependencies
composer require pestphp/pest-plugin-laravel --dev
php artisan pest:install
```

