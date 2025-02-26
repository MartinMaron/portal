<div class="">
    @if ($errors->isNotEmpty())
        <div class="block error-box">
            <span class="block sm:block"><strong class="font-bold">Uups! Einige Informationen fehlen oder sind nicht korrekt. </strong>
                @foreach ($errors->all() as $error)
                        <span class="block sm:block">- {{ $error  }}</span>
                @endforeach
            </span>
        </div>
    @endif
 
    <div class="{{ $cost->costtype->costinvoicingtype->id == 'HZ' ? 'block' : 'hidden' }}">
        <div class="detailinput flex items-center gap-1 bg-sky-200 dark:bg-slate-900 dark:text-gray-200 bg-opacity-50 p-0.5 rounded-lg">
            <!-- Datum -->            
            <div class="basis-1/6" >   
                <x-input.date
                    wire:model.lazy="current.datum"
                    id="user-costamount-detailinput-datum{{ $cost->id }}"
                    type="text"
                    :error="$errors->first('current.datum')"
                    style="-moz-appearance: textfield; margin: 0;"
                    class="{{ $inputWithDate || ($cost->fueltype_id !=null && $cost->fueltype->hasTank) ? 'block' : 'hidden' }} 
                    inputDisplay
                    {{ $errors->first('current.datum') ? 'bg-red-50 focus:border-red-900 border-red-900' : '' }}"
                    >
                </x-input.date>
            </div>
            <!-- Verbrauch -->        
            <div class="basis-1/6" >
                <input type="text"  
                    id="user-costamount-detailinput-consumption{{ $cost->id }}"
                    inputmode="numeric"  
                    placeholder="0"
                    wire:model.lazy="current.consumption_editing"
                    style="-moz-appearance: textfield; margin: 0;"
                    class="{{ $cost->consumption ? 'block' : 'hidden' }} 
                    inputDisplay 
                    {{ $errors->first('current.consumption') ? 'inputErrorDisplay' :'' }}"   
                >
            </div>
            <!-- haushaltsnah -->      
            
            <!-- CO2-Abgabe -->            
            <div class="basis-1/6" >   
                <input
                        wire:model.lazy="current.coconsupmtion"
                        id="user-costamount-detailinput-coconsupmtion{{ $cost->id }}"
                        type="text"
                        inputmode="numeric" 
                        style="-moz-appearance: textfield; margin: 0;"
                        class="{{ $cost->co2Tax ? 'block' : 'hidden' }}
                        inputDisplay 
                        {{ $errors->first('current.coconsupmtion') ? 'inputErrorDisplay' :'' }}"   
                >
            </div>
            <!-- CO2 Betrag -->        
            <div class="basis-1/6" >
                <input type="text"    
                    id="user-costamount-detailinput-co2betrag{{ $cost->id }}"
                    inputmode="numeric"  
                    wire:model.lazy= {{ $netto ? 'current.conetto' : 'current.cobrutto' }}
                    style="-moz-appearance: textfield; margin: 0;"
                    class="{{ $cost->co2Tax ? 'block' : 'hidden' }} 
                    inputDisplay 
                    {{ $errors->first('current.co2betrag') ? 'inputErrorDisplay' :'' }}"   
            >
            </div>
            <!-- Betrag -->        
            <div class="basis-1/6" >
                <input type="text"    
                    id="user-costamount-detailinput-betrag-{{ $cost->id }}"
                    wire:keyup.enter="save()"
                    inputmode="numeric"  
                    wire:model.lazy= {{ $netto ? 'current.netto' : 'current.brutto' }}
                    style="-moz-appearance: textfield; margin: 0;"
                    class="inputDisplay"   
                >
            </div>
            <button 
                class="basis-1/6 border text-justify bg-sky-300 dark:bg-slate-700 dark:hover:bg-slate-600 md:text-md hover:bg-sky-500 focus:bg-sky-500 focus:ring-indigo-500 p-1 px-2 m-0 focus:border-indigo-500 block sm:text-sm border-gray-900 rounded-md"   
                wire:click="save()"   
                >
                <span class="md:text-md "><i class="text-left pr-1 fa-solid fa-layer-plus"></i></i></span>
                <span class="md:text-md text-right">Einfg</span>
            </button>
        </div>
    </div>
</div>