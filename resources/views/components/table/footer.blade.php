<div {{ $attributes->merge(['class' => 'py-3 bg-cool-gray-50'])->only('class') }}>   
    <span class="text-center text-md leading-4 font-semibold uppercase text-cool-gray-500 tracking-wider">{{ $slot }}</span>
</div>

