@props([
    'id' => "toggle",
    'width' => 20,
    'readonly' => false,
])
<div class="relative inline-block my-1 mr-6 {{ 'w-'. $width }}  align-middle select-none transition duration-200 ease-in">
    <input {{ $attributes }}
        id= {{ $id }}
        type="checkbox"
        class="toggle-checkbox absolute my-1 block w-4 h-4 rounded-full bg-sky-100 border-1 appearance-none cursor-pointer"
    />
   <label for={{ $id }} class="toggle-label pl-8 block overflow-hidden h-6 rounded-full cursor-pointer">                        
        <span class="text-md font-medium text-gray-900"> {{ $slot }}  </span>
    </label>
</div>

