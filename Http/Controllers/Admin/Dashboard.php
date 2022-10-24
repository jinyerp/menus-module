<?php

namespace Modules\Menus\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use Jiny\Table\Http\Controllers\DashboardController;
class Dashboard extends DashboardController
{
    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);
    }

    public function index(Request $request)
    {
        // Request값 Action 병합
        $this->checkRequestNesteds($request);
        $this->checkRequestQuery($request);

        // 메뉴 설정
        /*
        $user = Auth::user();
        if($user) {
            $this->setUserMenu($user);
        }
        */
        $this->menu_init();

        // 권한
        $this->permitCheck();
        if($this->permit['read']) {
            return view("menus::admin.dashboard.main",[
                'actions'=>$this->actions
            ]);
        }

        // 권한 접속 실패
        return view("jinytable::error.permit",[
            'actions'=>$this->actions,
            'request'=>$request
        ]);
    }


}
