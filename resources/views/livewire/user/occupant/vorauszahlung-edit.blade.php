<div class="">

<input     
    type="text"
    inputmode="numeric" 
    wire:model.lazy="vorauszahlung"
    wire:focusout ="confirmPrePaid()"
    style="-moz-appearance: textfield; margin: 0;"
    class="text-center border md:text-md focus:ring-black p-1 px-2 m-0 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"   
>

</div>
{{-- <input type="text"  
                    id="user-costamount_bk-detailinput-haushaltsnah"
                    inputmode="numeric"  
                    placeholder="1"
                    wire:model.lazy="current.haushaltsnah"
                    style="-moz-appearance: textfield; margin: 0;"
                    class="text-center border md:text-md focus:ring-black p-1 px-2 m-0 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"   
                    > 
                    @if ($errors->first('current.haushaltsnah'))
                    <div class="mt-1 text-red-500 text-sm">{{ $errors->first('current.haushaltsnah') }}</div>
                    @endif --}}