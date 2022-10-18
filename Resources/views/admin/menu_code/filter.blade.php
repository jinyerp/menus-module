<!-- 검색 필터 -->
<p>
<button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#searchFilters" aria-expanded="false" aria-controls="searchFilters">
    <div class="d-flex">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel" viewBox="0 0 16 16">
            <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2h-11z"/>
        </svg>       

        <span class="ml-2">
            Filter
        </span>
    </div>
</button>
</p>
<div class="collapse" id="searchFilters">
    <x-card>
        <x-card-body>
            <x-table-filter>

                <x-row>
                    <x-col-6>
                        <x-form-hor>
                            <x-form-label>코드</x-form-label>
                            <x-form-item>
                                {!! xInputText()
                                    ->setWire('model.defer',"filter.code")
                                    ->setWidth("small")
                                !!}
                            </x-form-item>
                        </x-form-hor>
                    </x-col-6>
                    <x-col-6>

                    </x-col-6>
                </x-row>

            </x-table-filter>
        </x-card-body>
    </x-card>
</div>
