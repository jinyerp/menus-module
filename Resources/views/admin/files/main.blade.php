{{-- 목록을 출력하기 위한 템플릿 --}}
<x-theme theme="admin.sidebar">
    <x-theme-layout>

        <!-- Module Title Bar -->
        @if(Module::has('Titlebar'))
            @livewire('TitleBar', ['actions'=>$actions])
        @endif
        <!-- end -->

        @if(is_module('Files'))
        <div class="card">
            <div class="card-body">
                @livewire('Files',['path'=>"/resources/menus"])
            </div>
        </div>
        @else
        <p>관리자 페이지에서 Files 모듈을 먼저 설치해 주세요.</p>
        @endif

        @if(isSuper())
            @include('jinytable::setActionRule')
        @endif

    </x-theme-layout>
</x-theme>
