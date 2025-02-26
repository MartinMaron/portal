<div class="detailinput">    
    <div class=" flex items-center ">
        <div class="basis-2/3 flex items-center  ">
            <button 
                class="basis-2/3  text-lg text-left px-2 flex rounded-md hover:bg-sky-300 dark:hover:bg-slate-500"
                wire:click="raise_EditCostModal({{ $cost }})"
                tabindex="-1">
                <span class="line-clamp-1">{{ $cost->caption }}</span>
            </button>
            <div class="basis-1/3 text-sm rounded-md text-center">
                <span class="line-clamp-1">{{$cost->noticeForUser }}</span>
            </div>            
        </div>
        <div class="basis-1/3 flex">
            <div class="basis-1/3">
                <input type="text"  
                    id="user-costamount-detailinput-consumption{{ $cost->id }}"
                    inputmode="numeric"  
                    placeholder="0,0"
                    wire:model.lazy="current.consumption_editing"
                    style="-moz-appearance: textfield; margin: 0;"
                    class="{{ $cost->consumption ? 'block' : 'hidden' }} 
                    inputDisplayHK
                    {{ $errors->first('current.consumption') ? 'inputErrorDisplay' :'' }}"   
                >   
            </div>
            <div class="basis-1/3">
                <input type="text"  
                    id="user-costamount_bk-detailinput-haushaltsnah{{ $cost->id }}"
                    inputmode="numeric"  
                    placeholder="1"
                    wire:model.lazy="current.haushaltsnah"
                    style="-moz-appearance: textfield; margin: 0;"
                    class="{{ $cost->haushaltsnah ? 'block' : 'hidden' }} 
                    inputDisplayHK
                    {{ $errors->first('current.haushaltsnah') ? 'inputErrorDisplay' :'' }}"   
                > 
            </div>
            <div class="basis-1/3">
                @if ($editable && !$this->cost->realestate->abrechnungssetting->heizkostenlisteDone)
                    <input type="text"    
                    id="user-costamount-bk-detailinput-betrag{{ $cost->id }}"
                    inputmode="numeric"  
                    wire:focusout="save()"
                    wire:model.lazy= {{ $netto ? 'current.netto' : 'current.brutto' }}
                    class="border inputDisplayHK"   
                    >
                @else
                    <div 
                    class="border inputDisplayHK-ro text-gray-600"   
                    style="-moz-appearance: textfield; margin: 0;"
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