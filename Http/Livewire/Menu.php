<?php
namespace Modules\Menus\Http\Livewire;

use Illuminate\Support\Facades\Blade;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Menus;

class Menu extends Component
{
    public $css=[];
    public $menuName;
    public $filename;

    public function mount($path=null)
    {
        if ($path) {
            // path 경로를 설정합니다.
            \Modules\Menus\Http\Menu::instance()->setPath($path);
            $this->filename = $path;
        } else {
            // 컨트롤러에서 설정된 path 정보를 읽어 옵니다.
            $this->filename = \Modules\Menus\Http\Menu::instance()->path;
        }
    }


    public function render()
    {
        if($this->filename) {
            $menuFilePath = resource_path().DIRECTORY_SEPARATOR.$this->filename;
            if(file_exists($menuFilePath)) {
                // json menu file읽기

                $jsonBody = file_get_contents($menuFilePath);
                $tree = json_decode($jsonBody, true); // 배열로 변환
                $menu_id = $this->getMenuId($this->filename);

            } else {
                // 파일이 없는 경우 DB에서 읽어서 처리
                $menu_id = $this->getMenuId($this->filename);
                $tree = $this->load($menu_id); // 메뉴트리 생성
            }
        } else {
            // 파일이 없는 경우 DB에서 읽어서 처리
            $menu_id = $this->getMenuId($this->filename);
            $tree = $this->load($menu_id); // 메뉴트리 생성
        }



        // 메뉴 HTML UI 생성
        $builder = new \Modules\Menus\Http\Builder\Bootstrap($this->css);
        $builder->setData($tree);
        $builder->menu_id = $menu_id;

        if(!$this->menuName) {
            $this->menuName = "sidebar-nav"; // 부트스트랩 최상위 클래스 이름설정
        }

        $menuTree = $builder->make()->addClass($this->menuName);

        // 메뉴트리, css, javascript 코드 출력
        return view('menus::livewire.menu', ['menuTree'=>$menuTree]);
    }

    private function getMenuId($filename)
    {
        // path정보를 통하여, 메뉴 code id를 확인 합니다.
        $temp = explode(DIRECTORY_SEPARATOR, $filename);
        $key = array_key_last($temp);

        $menu_id = str_replace(".json", "", $temp[$key]);

        return $menu_id;
    }



    /** ----- ----- ----- ----- -----
     *
     */
    private function load($menu_id)
    {
        ## 메뉴코드 정보를 읽어 옵니다.
        $code = DB::table('menus')->where('id',$menu_id)->first();
        if ($code) {

            ## 메뉴데이터를 읽어 옵니다.
            $rows = DB::table('menu_items')
                ->where('menu_id', $menu_id)
                //->where('enable', 1)
                ->orderBy('level',"desc")
                ->orderBy('pos',"asc")
                ->get();

            ## row 데이터를 계층형으로 tree 구조를 생성합니다.
            $trees = $this->toTree($rows); //전처리
            $menuTree = []; //초기화
            foreach($trees as $tree) {
                // view 전달시, key 이름으로 자동정렬 되기 때문에
                // index로 변환하여 전달함.
                $menuTree []= $tree;
            }

            return $menuTree;
        }

        return [];
    }


    private function toTree($rows)
    {
        $tree = [];

        // 배열변환
        foreach ($rows as $row) {
            $id = $row->id;
            foreach ($row as $key => $value) {
                $tree[$id][$key] = $value;
            }
        }

        // 계층이동
        foreach($tree as $i => $item) {
            if($item['level'] != 1) {
                $ref = $item['ref'];
                $tree[$ref]['sub'] []= $tree[$i];
                unset($tree[$i]);
            }
        }

        return $tree;
    }


}
