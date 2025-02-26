<div class=" dark:bg-slate-900 detailinputBK ">    
    <div class="flex justify-around items-center text-lg font-normal text-center columnheader gap-1 ">
        <div class="basis-2/3 flex items-center ">
            <button 
                class="basis-1/3 text-lg text-left px-2 flex rounded-md hover:bg-sky-300 "
                wire:click="raise_EditCostModal({{ $cost }})"
                tabindex="-1">
                <span class="py-1 line-clamp-1">{{ $cost->caption }}</span>
            </button>
            <div class="basis-1/3 text-sm rounded-md  text-center">
                <span class="line-clamp-1">{{$cost->noticeForUser }}</span>
            </div>
            <div class="basis-1/3 px-4 rounded-md ">
                <div class="flex justify-evenly gap-3 my-1 items-center bg-sky-100 dark:bg-slate-800 dark:text-slate-200 border border-sky-300 rounded-md font-light">
                    <span class="text-right text-sm line-clamp-1 px-2 basis-1/2">{{ $cost->prevyear_amountgros_view. ' €'}}</span> -
                    <span class="text-right text-sm line-clamp-1 px-2 basis-1/2">{{ $cost->prevyear_quantity_view. ' '. $cost->costkey->einheit->shortname   }}</span>
                </div>
            </div>
        </div>
        <div class="basis-1/3 flex gap-2">
            <div class="basis-1/3">
                {{-- @if ($cost->consumption) --}}
                <input type="text"  
                    id="user-costamount-detailinput-consumption{{ $cost->id }}"
                    inputmode="numeric"  
                    placeholder="0,0"
                    wire:model.lazy="current.consumption_editing"
                    style="-moz-appearance: textfield; margin: 0;"
                    class="{{ $cost->consumption ? 'block' : 'hidden' }} 
                    inputDisplayBK
                    {{ $errors->first('current.consumption') ? 'inputErrorDisplay' :'' }}" 
                >   
                {{-- @endif --}}
            </div>
            <div class="basis-1/3">
                {{-- @if ($cost->haushaltsnah) --}}
                <input type="text"  
                    id="user-costamount_bk-detailinput-haushaltsnah{{ $cost->id }}"
                    inputmode="numeric"  
                    placeholder="1"
                    wire:model.lazy="current.haushaltsnah"
                    style="-moz-appearance: textfield; margin: 0;"
                    class="{{ $cost->haushaltsnah ? 'block' : 'hidden' }} 
                    inputDisplayBK
                    {{ $errors->first('current.haushaltsnah') ? 'inputErrorDisplay' :'' }}" 
                > 
            </div>
            <div class="basis-1/3">
                @if ($editable && !$this->cost->realestate->abrechnungssetting->betreibskostenDone)
                    <input type="text"    
                    id="user-costamount-bk-detailinput-betrag{{ $cost->id }}"
                    inputmode="numeric"  
                    wire:focusout="save()"                    
                    wire:model.lazy= {{ $netto ? 'current.netto' : 'current.brutto' }}
                    style="-moz-appearance: textfield; margin: 0;"
                    class="border inputDisplayBK"   
                    >
                @else
                    <div 
                    class="border inputDisplayBK-ro"   
                    >{{ $netto ? $current->netto : $current->brutto }}
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