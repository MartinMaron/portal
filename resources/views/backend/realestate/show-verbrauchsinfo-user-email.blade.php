<x-app-layout>
    <x-slot name="slot">
        <x-slot name="header">
            <livewire:user.realestate.header :baseobject='$realestate'/>
        </x-slot>
        <div class="">
            <livewire:user.realestate.verbrauchsinfo-user-email.search-list :realestate='$realestate' :wire:key="'realestate.verbrauchsinfo-user-email-list-item-'.$realestate->id"/>
        </div>
    </x-slot>
</x-app-layout>
