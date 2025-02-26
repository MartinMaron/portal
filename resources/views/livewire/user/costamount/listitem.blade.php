<div class="flex items-center px-4 py-1 justify-around gap-6 border-b-2 bg-slate-100 border-white">

    <div id="user-costamount-listitem-consumption{{ $current->id }}"
        style="-moz-appearance: textfield; margin: 0;"
        class="{{ $cost->consumption ? 'block' : 'invisible' }} basis-1/5 md:text-md text-right "   >
            <span class="text-right mr-2">{{ $current->consumption }}</span>                      
    </div>
    <div id="user-costamount-listitem-haushaltsnah{{ $current->id }}"
        style="-moz-appearance: textfield; margin: 0;"
        class="{{ $cost->haushaltsnah ? 'block' : 'invisible' }} basis-1/5 md:text-md text-right "   >
            <span class="text-right mr-2">{{ $current->haushaltsnah }}</span>                      
    </div>
    <div id="user-costamount-listitem-datum{{ $current->id }}"
        style="-moz-appearance: textfield; margin: 0;"
        class="basis-1/5 md:text-md text-right {{ $withoutDatum ? 'invisible' : '' }} "   >
            <span class="text-right mr-2">{{ $current->datum }}</span>                      
    </div>
    <div id="user-costamount-listitem-betrag{{ $current->id }}"
        style="-moz-appearance: textfield; margin: 0;"
        class="basis-1/5 md:text-md text-right "   
        >
        @if($netto)
            <span class="text-right mr-2">{{ $current->netto }}</span>              
        @else
            <span class="text-right mr-2">{{ $current->brutto }}</span>  
        @endif
    </div>
       
    <div class="basis-1/5 ">
        <div class="flex">
            <div
                wire:click="raise_EditCostAmountModal" 
                class="border text-center bg-sky-300 md:text-md hover:bg-sky-500 focus:bg-sky-500 focus:ring-indigo-500 py-1 mr-2 m-0 focus:border-indigo-500 w-full sm:text-sm border-sky-600 rounded-md ">
                <x-icon.fonts.pencil class="text-xs ">                                       
                </x-icon.fonts.pencil>
            </div>
            <div
                wire:click="questionDeleteCostAmount" 
                class="border text-center bg-red-300 md:text-md hover:bg-red-500 focus:bg-sky-500 focus:ring-indigo-500 py-1 ml-2 m-0 focus:border-indigo-500 w-full sm:text-sm border-red-600 rounded-md ">
                <i class="text-red-800 fa-solid "></i>
            </div>
        </div>
    </div>
</div>

