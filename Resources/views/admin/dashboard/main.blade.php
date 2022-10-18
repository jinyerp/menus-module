<x-theme theme="admin.sidebar">
    <x-theme-layout>
        <!-- Module Title Bar -->
        @if(Module::has('Titlebar'))
            @livewire('TitleBar', ['actions'=>$actions])
        @endif

        <div class="row">
			<div class="col-12 col-md-6 col-xl-auto flex-grow-1 d-flex">
				<div class="card flex-fill">
					<div class="card-body py-4">
                        {{--
                        <div class="float-end text-danger">
                            -5.28%
                        </div>
                        --}}
                        <h4 class="mb-2">
                            <a href="/jiny/_admin/menu/code">메뉴코드</a>
                        </h4>
                        {{--
                        <div class="mb-1">
                            <strong>0.001416</strong> $16.61
                        </div>
                        <div>
                            Volume: 2,692.47 BTC
                        </div>
                        --}}
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xl-auto flex-grow-1 d-flex">
				<div class="card flex-fill">
					<div class="card-body py-4">
                        {{--
                        <div class="float-end text-danger">
                            -5.28%
                        </div>
                        --}}
                        <h4 class="mb-2">
                            <a href="/jiny/_admin/menu/file">메뉴파일</a>
                        </h4>
                        {{--
                        <div class="mb-1">
                            <strong>0.001416</strong> $16.61
                        </div>
                        <div>
                            Volume: 2,692.47 BTC
                        </div>
                        --}}
                    </div>
                </div>
            </div>
						
		</div>

        

        @if(isSuper())
            @include('jinytable::setActionRule')
            {{-- @livewire('setActionRule', ['actions'=>$actions]) --}}
        @endif
        

    </x-theme-layout>
</x-theme>
