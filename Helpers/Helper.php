<?php
use \Jiny\Html\CTag;
use Illuminate\Support\Facades\DB;

/**
 * 메뉴를 설정합니다.
 */
if(!function_exists('setMenu'))
{
    function setMenu($code)
    {
        return xMenu()->setPath($code);
    }
}



function xMenu() {
    return \Modules\Menus\Http\Menu::instance();
}



function xMenuPath() {

}

/*
function xMenuJson($json) {
    return (new \Jiny\Menu\MenuBuilder($json))->make()->addClass("sidebar-nav");
}
*/
/**
 * 메뉴트리 HTML을 빌드합니다.
 */
if(!function_exists('xMenuTree')) {
    function xMenuTree($tree) {
        // 루트 ul은 패딩 0로 설정
        return (new \Modules\Menus\Http\Builder\Tree($tree))->make();//->addClass('p-0');
    }
}



/**
 * 메뉴 코드의 목록을 Select로 표시합니다.
 * 기본적으로는 enable된 항목만 출력합니다.
 */
function xMenuSelect($value=null, $enable=true) {
    $select = new \Jiny\Html\CTag('select',true);

    $db = DB::table('menus');
    if($enable) {
        $rows = $db->where('enable',1)->get();
    } else {
        $rows = $db->get();
    }

    $_option = new \Jiny\Html\CTag('option',true);
    foreach($rows as $row) {
        $option = clone $_option;
        $option->setAttribute('value', $row->id);
        $option->addItem($row->code);
        if ($value && $value == $row->id) {
            $option->setAttribute('selected',"selected");
        }

        $select->addItem($option);
    }

    if(empty($value)) {
        $select->items[0]->setAttribute('selected',"selected");
    }

    $select->addClass('form-select'); //bootstrap

    return $select;
}


if (!function_exists('xEnableText')) {
    function xEnableText($item, $obj)
    {
        if(is_object($item)) {
            if(isset($item->enable) && $item->enable) {
                return $obj;
            } else {
                return xSpan($obj)->style("text-decoration:line-through;");
            }
        } else {
            if(isset($item['enable']) && $item['enable']) {
                return $obj;
            } else {
                return xSpan($obj)->style("text-decoration:line-through;");
            }
        }
    }
}


