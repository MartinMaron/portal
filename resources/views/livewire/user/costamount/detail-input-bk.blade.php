<div class=" dark:bg-slate-900 detailinputBK ">
    <div class="flex justify-around items-center text-lg font-normal text-center columnheader gap-1 ">
        <div class="basis-2/3 flex items-center font-semibold">
            <button
                class="basis-2/3 text-left px-2 flexhover:bg-sky-300 hover:bg-sky-300 dark:hover:bg-slate-500 rounded-md"
                wire:click="EditCostModal({{ $cost }})"
                tabindex="-1">
                <span class="py-1 line-clamp-1">{{ $cost->caption . ($cost->noticeForUser ? ' (' . $cost->noticeForUser . ')' : '') }} </span>
            </button>
               
           <div class="basis-1/3 px-4 ">
                <div class="flex justify-evenly gap-3 my-1 items-center bg-sky-100 dark:bg-slate-800 dark:text-slate-200 border border-sky-300 rounded-md font-light">
                    <span class="text-right text-sm font-semibold line-clamp-1 px-2 basis-1/2">{{ $cost->prevyear_amountgros_view. ' €'}}</span> -
                    <span class="text-right text-sm font-semibold line-clamp-1 px-2 basis-1/2">{{ $cost->prevyear_quantity_view. ' '. $cost->costkey->einheit->shortname   }}</span>
                </div>
            </div>
        </div>
        <div class="basis-1/3 flex gap-2">
            <div class="basis-1/3 ">
                @if ($this->cost->editable && !$this->cost->realestate->abrechnungssetting->betreibskostenDone)
                    <input type="text"
                        id="user-costamount-detailinput-consumption{{ $cost->id }}"
                        inputmode="numeric"
                        placeholder="0,0"
                        wire:model.lazy="consumption"
                        style="-moz-appearance: textfield; margin: 0;"
                        class=" {{ $cost->consumption ? 'block' : 'hidden' }}
                        inputDisplayBK"
                    >
                 @else
                    <div class="inputDisplayBK-ro font-semibold {{ $cost->consumption ? '0,0' : 'hidden' }}">
                        {{ $this->consumption }}
                    </div>
                @endif
            </div>
            <div class="basis-1/3">
                @if ($this->cost->editable && !$this->cost->realestate->abrechnungssetting->betreibskostenDone)
                    <input type="text"
                        id="user-costamount_bk-detailinput-haushaltsnah{{ $cost->id }}"
                        inputmode="numeric"
                        placeholder="0,00"
                        wire:model.blur="haushaltsnah"
                        style="-moz-appearance: textfield; margin: 0;"
                        class="{{ $cost->haushaltsnah ? 'block' : 'hidden' }}
                        inputDisplayBK
                        {{ $errors->first('current.haushaltsnah') ? 'inputErrorDisplay' :'' }}"
                    >
                 @else
                    @if ($haushaltsnah !='0,00')
                        <div class="inputDisplayBK-ro font-semibold {{ $haushaltsnah ? '0,00' : 'hidden' }}">
                            {{ $haushaltsnah}}
                        </div>
                    @endif
                @endif
            </div>
            <div class="basis-1/3">
                @if ($this->cost->editable && !$this->cost->realestate->abrechnungssetting->betreibskostenDone)
                    <input type="text"
                           id="user-costamount-bk-detailinput-betrag{{ $cost->id }}"
                           inputmode="numeric"
                           wire:model.blur="betrag"
                           style="-moz-appearance: textfield; margin: 0;"
                           class="border inputDisplayBK font-semibold"
                    >
                @else
                    <div
                        class="inputDisplayBK-ro font-semibold"
                    >{{ $betrag}}
                    </div>
                @endif
            </div>
        </div>
    </div>
    @if ($errors->isNotEmpty())
        <div class="block text-sm bg-red-100 border border-red-400 text-red-700 px-1 py-1 rounded relative mb-2" role="alert">
            <span class="block sm:block"><strong class="font-bold">Uups! Einige Informationen fehlen oder sind nicht korrekt. </strong>
                @foreach ($errors->all() as $error)
                        <span class="block sm:block">- {{ $error  }}</span>
                @endforeach
            </span>
        </div>
    @endif
</div>
