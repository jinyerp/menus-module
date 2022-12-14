<?php

namespace Modules\Menus\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

use Illuminate\Support\Facades\Blade;
use Livewire\Livewire;

class MenusServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Menus';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'menus';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));

        //메뉴 빌더를 호출
        Blade::component(\Modules\Menus\View\Components\Menu::class, "menu-json");

        // 마우스 오른쪽 클릭메뉴
        // context
        Blade::component(\Modules\Menus\View\Components\Context::class, "context-menu");
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);

        // 메뉴트리를 출력합니다.
        Livewire::component('menu-json', \Modules\Menus\Http\Livewire\Menu::class);
        Livewire::component('menu-sidebar', \Modules\Menus\Http\Livewire\Menu::class);


        Livewire::component('WireTreeDrag', \Modules\Menus\Http\Livewire\Admin\WireTreeDrag::class);

        // PopupForm을 상속 재구현한 tree 입력폼 처리루틴
        Livewire::component('PopupTreeFrom', \Modules\Menus\Http\Livewire\Admin\PopupTreeFrom::class);
        Livewire::component('WireUpload', \Modules\Menus\Http\Livewire\Admin\WireUpload::class);

    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (\Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }
}
