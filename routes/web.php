<?php

use App\Models\Department;
use Illuminate\Support\Facades\Route;
use function Pest\Laravel\getJson;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return 'login';
})->name('login');

Route::get('/test', function () {
    $development = Department::factory(['name' => 'Development3', 'description' => 'dev is very good3'])->create();

//    print_r(route('departments.show', ['department' => $development]));
    print_r('sdfasdfsadf');
    $department = getJson(route('departments.show', ['department' => $development]))
        ->json('data');
//    dd($development);

});
