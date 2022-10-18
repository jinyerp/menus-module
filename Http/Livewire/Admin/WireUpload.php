<?php
/*
 * jinyPHP
 * (c) hojinlee <infohojin@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Modules\Menus\Http\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\MenuItems;

use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class WireUpload extends Component
{
    use WithFileUploads;
    public $actions = [];
    public $menu_id;
    public $user_id;

    public function mount()
    {
        $this->user_id = Auth::user()->id;
    }


    public function render()
    {
        return view("menus::livewire.upload");
    }


    /**
     * 파일 업로드
     */
    public $filename;
    public function fileUpload()
    {
        $validatedData = $this->validate([
            'filename'=> 'required'
        ]);

        $filename = $this->filename->store('menus','public');

        if($this->menu_id) {
            $this->decodeTo($filename);

            session()->flash('message', "file Successfully uploaded!");
        } else {
            session()->flash('message', "메뉴코드가 지정되어 있지 않습니다!");
        }

        ## 파일 삭제
        Storage::disk('public')->delete($filename);

        // Livewire Table을 갱신을 호출합니다.
        $this->emit('refeshTable');
    }


    private function decodeTo($filename)
    {
        // menu json파일 읽기
        $path = storage_path('app/public');
        $json = file_get_contents($path.DIRECTORY_SEPARATOR.$filename);
        $rows = json_decode($json, true);


        // 마지막 id값 확인
        $maxid = DB::table('menu_items')->max('id');
        if(!$maxid) {
            $maxid = 1;
        } else {
            $maxid += 1;
        }

        
        // 계층 데이터를 1차원 배열로 변환
        $this->treeToRows($rows, $maxid);

        // tree id값 재정렬
        for($i=0;$i<count($this->rows);$i++) {
            $id = $this->rows[$i]['id'];
            $this->rows[$i]['id'] = $maxid;
            for($j=0; $j<count($this->rows);$j++) {
                if($this->rows[$j]['ref'] == $id) {
                    $this->rows[$j]['ref'] = $maxid;
                }
            }
            $maxid++;        
        }

        // 데이터 DB 삽입
        $db = DB::table('menu_items')->insert($this->rows);

    }

    // 재귀호출
    private $rows = [];
    private function treeToRows($rows, $maxid)
    {
        foreach($rows as &$item) {
            $item['id'] += $maxid;

            ## 루트가 아닌경우
            if($item['ref'] != 0) {
                $item['ref'] += $maxid;
            }

            // 메뉴코드 Id값 변경
            $item['menu_id'] = $this->menu_id;

            // 재귀호출
            if(isset($item['sub'])) {
                $this->treeToRows($item['sub'], $maxid);
                unset($item['sub']);
            }

            //unset($item['user_id']);
            $item['user_id'] = $this->user_id;

            // 1차원 배열로 변환
            $this->rows []= $item;
        }        
    }

    /**
     * 파일 다운로드
     */
    public function export()
    {
        $menuInfo = DB::table('menus')->where('id', $this->menu_id)->first();
        if($menuInfo) {
            $path = resource_path('menus');
            $filePath = $path.DIRECTORY_SEPARATOR.$menuInfo->code.".json";
            if(file_exists($filePath)) {
                session()->flash('message', "메뉴 설정 json 파일을 다운로드 합니다.");
                return response()->download($filePath); // storage_path(storage_path())
            } else {
                session()->flash('message', "먼저 json 변환후에 다운로드를 해야 합니다.");
            }
        }      
    }

}
