<x-app-layout>
    <x-slot name="header">
        <livewire:user.realestate.header :baseobject='$realestate'/>
    </x-slot>
    <x-slot name="slot">
        <div class="max-w-7xl w-full mx-auto">
            <livewire:user.cost.heizkostenliste :realestate='' :realestate='$realestate'/>
        </div>
    </x-slot>
</x-app-layout>
