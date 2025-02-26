<x-app-layout>
    <x-slot name="slot">
        <x-slot name="header">
            <livewire:user.realestate.header :baseobject='$realestate'/>
        </x-slot>
        <div class="">
            <livewire:user.realestate.invoices-list :realestate='$realestate'/>
        </div>
    </x-slot>
</x-app-layout>
