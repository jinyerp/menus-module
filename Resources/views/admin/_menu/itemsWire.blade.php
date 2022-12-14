<div>
    <x-button success wire:click="encodeToJson">Apply</x-button>

    <br>

    <x-link wire:click="popupNew">+</x-link>


    <ul class="tree" drag-root="reorder">
        @foreach ($tree as $item1)
            <li drag-item="{{$item1['id']}}" draggable="true" wire:key="{{$item1['pos']}}">
                ({{$item1['id']}})
                ({{$item1['pos']}}) :

                <x-link wire:click="popupEdit({{$item1['id']}})">
                    {{$item1['title']}} ({{$item1['ref']}})
                </x-link>

                <x-link class="ml-2" wire:click="popupRef({{$item1['id']}})">
                    +
                </x-link>

                @if(isset($item1['sub']))
                <ul class="tree">
                    @foreach ($item1['sub'] as $item2)
                        <li>
                            <x-link wire:click="popupEdit({{$item2['id']}})">
                                {{$item2['title']}} ({{$item2['ref']}})
                            </x-link>

                            <x-link class="ml-2" wire:click="popupRef({{$item2['id']}})">
                                +
                            </x-link>

                            @if(isset($item2['sub']))
                            <ul class="tree">
                                @foreach ($item2['sub'] as $item3)
                                    <li>

                                        <x-link wire:click="popupEdit({{$item3['id']}})">
                                            {{$item3['title']}} ({{$item3['ref']}})
                                        </x-link>

                                        <x-link class="ml-2" wire:click="popupRef({{$item3['id']}})">
                                            +
                                        </x-link>


                                        @if(isset($item3['sub']))

                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
                @endif
            </li>
        @endforeach
    </ul>


    <x-jet-dialog-modal wire:model="popup">
        <x-slot name="title">
            {{ __('??????') }}
        </x-slot>

        <x-slot name="content">
            ?????????
            <input type="text" wire:model="forms.title">

            <br>

            href
            <input type="text" wire:model="forms.href">

        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="popupDelete" wire:loading.attr="disabled">
                {{ __('??????') }}
            </x-jet-secondary-button>

            <x-jet-secondary-button wire:click="popupClose" wire:loading.attr="disabled">
                {{ __('??????') }}
            </x-jet-secondary-button>

            @if (isset($form['id']))
                <x-jet-danger-button class="ml-2" wire:click="popupEditSubmit" wire:loading.attr="disabled">
                    {{ __('??????') }}
                </x-jet-danger-button>
            @else
            <x-jet-danger-button class="ml-2" wire:click="popupNewSubmit" wire:loading.attr="disabled">
                {{ __('??????') }}
            </x-jet-danger-button>
            @endif

        </x-slot>
    </x-jet-dialog-modal>


</div>


{{-- ????????? --}}
<script>
    window.addEventListener('contentChanged', event => {
        console.log("livewire reflash");
    });

    let root = document.querySelector('[drag-root]');
    let prevY;
    console.log("drag list");
    console.log(new Date());

    console.log(root.querySelectorAll('[drag-item]'));
    root.querySelectorAll('[drag-item]').forEach(el => {
        el.addEventListener('click', e => {
            console.log('click');
            //e.target.draggable="true";
        });

        console.log(el)
        el.addEventListener('dragstart', e => {
            //console.log('start');
            e.target.classList.add('bg-blue-100');
            e.target.setAttribute('dragging', true); // ????????? ????????? ??????
            prevY = e.pageY;
            console.log("START=" + prevY);
        });

        el.addEventListener('drop', e => {
            //console.log('drop');

            let draggingEl = root.querySelector('[dragging]');
            draggingEl.classList.remove('bg-blue-100');
            //console.log(draggingEl )

            console.log("DRAG=" + e.pageY);
            if (prevY < e.pageY) {
                //console.log("???????????? ??????");
                e.target.parentElement.after(draggingEl);

            } else {
                //console.log("????????? ??????");
                e.target.parentElement.before(draggingEl);
            }

            // ?????? ????????? ??????
            e.target.parentElement.classList.remove('bg-yellow-100');

            // ?????????????????? ??????
            let component = Livewire.find(
                e.target.closest('[wire\\:id]').getAttribute('wire:id')
            );

            let orderIds = Array.from(root.querySelectorAll('[drag-item]'))
                .map(itemEl =>
                    itemEl.getAttribute('drag-item')
                );
            //console.log(orderIds);
            let method = root.getAttribute('drag-root');
            component.call(method, orderIds);



        });

        el.addEventListener('dragover', e => {
            e.preventDefault(); // drop ????????? ??????
        });

        el.addEventListener('dragenter', e => {
            e.target.parentElement.classList.add('bg-yellow-100');
            //console.log("enter = " + e.target);
            e.preventDefault(); // drop ????????? ??????
        });

        el.addEventListener('dragleave', e => {
            e.target.parentElement.classList.remove('bg-yellow-100');
            //console.log("leave = " + e.target);
        });

        el.addEventListener('dragend', e => {
            e.target.removeAttribute('dragging'); // ????????? ????????? ??????
        });

    })
</script>

