<li {{ $attributes->merge(['class' => 'flex py-1 items-center']) }}>
    <i class="mt-1 fa-solid fa-check"></i>
    <span class="ml-2">
        {{ $slot }}
    </span>     
</li>