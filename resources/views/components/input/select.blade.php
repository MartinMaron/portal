@props([
    'placeholder' => null,
    'trailingAddOn' => null,  
    'disabled' => false,  
])

<div class="flex w-full bg-sky-200 dark:bg-slate-800 dark:text-sky-100">
  <select {{ $attributes->merge(['class' => ' placeholder-gray-300 dark:bg-slate-700 dark:text-slate-100 block w-full pl-1 py-1 font-semibold pr-10 sm:text-sm sm:border-b sm:border-sky-300 sm:text-sm lg:text-sm sm:leading-5' . ($trailingAddOn ? ' rounded-r-none' : '')]) }}
        {{ $disabled ?? false ? 'disabled' :'' }}
        style="border-width:0px; border-bottom-width:0px"
        position="absolute"
        >
        @if ($placeholder)
            <option class="dark:bg-slate-700 dark:text-slate-100" value="">{{ $placeholder }}</option>
        @endif
     
       {{ $slot }}
  </select>

  @if ($trailingAddOn)
    {{ $trailingAddOn }}
  @endif
</div>
