<x-theme theme="admin.sidebar">
    <x-theme-layout>
        <!-- Module Title Bar -->
        @if(Module::has('Titlebar'))
            @livewire('TitleBar', ['actions'=>$actions])
        @endif


        <ul>
            <li>
                <a href="/_admin/menu/code">메뉴코드</a>
            </li>
            <li>
                <a href="/_admin/menu/file">메뉴파일</a>
            </li>
        </ul>

        {{-- Admin Rule Setting --}}
        @include('jinytable::setActionRule')

    </x-theme-layout>
</x-theme>
