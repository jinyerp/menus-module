<?php
/*
 * jinyPHP
 * (c) hojinlee <infohojin@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Modules\Menus\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 *  Admin Page
 *  선택한 메뉴코드의 아이템을 관리합니다.
 */
use Jiny\Table\Http\Controllers\ResourceController;
class MenuItemController extends ResourceController
{
    const MENU_PATH = "menus";
    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);

        ## 테이블 정보
        $this->actions['table'] = "menu_items";

        // 메인화면을 재지정합니다.
        $this->actions['view_main'] = "menus::admin.menu_item.main";

        //$this->actions['view_title'] = "menus::admin.menu_code.title";
        //$this->actions['view_filter'] = "menus::admin.menu_code.filter";
        $this->actions['view_list'] = "menus::admin.menu_item.tree";
        $this->actions['view_form'] = "menus::admin.menu_item.form";

    }

    // index 오버라이딩,
    // 목록코드가 없는 경우 접속을 제한합니다.
    public function index(Request $request)
    {
        $menu_id = $request->menu_id;
        $code = DB::table('menus')->where('id',$menu_id)->first();
        if ($code) {
            return parent::index($request);
        } else {
            return $menu_id." 존재하지 않는 메뉴 코드 입니다.";
        }
    }


}
