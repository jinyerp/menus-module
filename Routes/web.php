<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


// 관리자 접속 prefix 확인
$prefix = admin_prefix();

/** ----- ----- ----- ----- -----
 *  Site-Menu 관리자
 */
Route::middleware(['web','auth:sanctum', 'verified', 'admin'])
->name('admin.site.')
->prefix($prefix.'/site')->group(function () {

    Route::get('/menu',function(){
        return view('menus::admin.dashboard');
    });

    ## 메뉴 코드 관리
    Route::resource('menu/code', \Modules\Menus\Http\Controllers\Admin\MenuController::class);

    ## 메뉴 아이템 설정
    Route::get('menu/{menu_id}/items',[\Modules\Menus\Http\Controllers\Admin\MenuItemController::class,"index"]);



    ## 메뉴 파일
    Route::resource('menu/file', \Modules\Menus\Http\Controllers\Admin\MenuFileController::class);

    // fure css Modal test용
    Route::resource('modal/menu/code', \Modules\Menus\Http\Controllers\Admin\ModalMenuController::class);

});


/** ----- ----- ----- ----- -----
 *  Design UI mode
 */
Route::middleware(['web','auth:sanctum', 'verified'])
->name('admin.easy.')
->prefix('/admin/easy')->group(function () {

    Route::resource('/menu/{menu_id}/items',
        \Modules\Menus\Http\Controllers\Admin\EasyMenuItem::class);

});


/** ----- ----- ----- ----- -----
 *  menu ajax api 설정
 */
Route::middleware(['web','auth:sanctum', 'verified'])
->prefix('/api')->group(function () {
    Route::post('menu/pos',[\Modules\Menus\API\Controllers\Pos::class,"index"]);
});

