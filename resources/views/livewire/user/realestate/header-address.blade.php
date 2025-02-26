<div>
    <div class="hidden sm:block rounded-md">
        <span class="flex w-32 text-center md:w-auto md:text-xl">
            {{ $this->realestate->address }}
        </span>
        <x-input.select
        class="text-left h-10 border-b bg-sky-200 dark:bg-slate-800 sm:h-8 dark:focus:border-slate-800 focus:border-0 w-full" wire:model="realestate.abrechnungssetting_id" id="realestate-header-address-abrechnungssetting-id" value="">
            @foreach ($this->realestate->abrechnungssettings as $label)
            <option class="h-10 rounded-r-none text-left dark:bg-slate-900" value="{{ $label->id }}">
                <span class="rounded-r-none dark:bg-slate-900">
                    {{$label->period_from_editing. ' - '. $label->period_to_editing   }}
                </span>
            </option>
            @endforeach
        </x-input.select>
    </div>

    <div class="block sm:hidden">
        <span class="flex text-sm text-center sm:w-auto sm:text-sm">
            {{ $this->realestate->street }}
        </span>
        <span class="flex text-sm text-center sm:w-auto sm:text-sm">
            {{ $this->realestate->postCode }}
            {{ $this->realestate->city }}
        </span>
        
    </div>
</div>