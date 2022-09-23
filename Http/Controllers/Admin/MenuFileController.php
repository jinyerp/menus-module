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

use Jiny\Table\Http\Controllers\FileController;
class MenuFileController extends FileController
{
    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);

        $this->actions['path'] = "/resources/menus";
        if(is_dir($this->actions['path'])) {
            mkdir();
        }

        $this->actions['view_main'] = "menus::admin.files.main";
    }
}
