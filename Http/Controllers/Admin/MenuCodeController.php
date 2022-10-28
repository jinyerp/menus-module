<?php
/*
 * jinyPHP
 * (c) hojinlee <infohojin@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Modules\Menus\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 *  Admin Page
 *  메뉴 목록을 관리합니다.
 */
use Jiny\Table\Http\Controllers\AdminController;
class MenuCodeController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);

        ## 테이블 정보
        $this->actions['table'] = "menus";

        //$this->actions['view_title'] = "menus::admin.menu_code.title";
        $this->actions['view_filter'] = "menus::admin.menu_code.filter";
        $this->actions['view_list'] = "menus::admin.menu_code.list";
        $this->actions['view_form'] = "menus::admin.menu_code.form";



        // 테마에 적용할 메뉴를 설정합니다.
        //setMenu("menus/site.json");
    }


    public function hookDeleting($wire, $row)
    {
        //dd($row);
        // 메뉴 아이템을 같이 삭제합니다.
        DB::table("menu_items")->where('menu_id', $row['id'])->delete();
        return $row;
    }

}
