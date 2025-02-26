@props([
    'id' => "toggle",
    'width' => 60,
    'readonly' => false,
    'height' => 16,
    'text_value1' => "Ja",
    'text_value0' => "Nein",
    'value1' => 1,
    'value0' => 0,
    'title' => "Überschrift",
    'title_font_size' => "text-sm",
    'aria_label' => "RadioGroup",
])
<div class="border-2 rounded-md border-sky-300 dark:border-sky-950 text-sky-950 dark:text-sky-100 bg-sky-100 dark:bg-slate-800 {{ ' w-'. $width }} {{ ' h-'. $height }} my-1 " aria-label="{{ $aria_label }}">
    <div class="p-1 font-semibold {{ $title_font_size }} {{ ' w-'. $width }} border-b border-sky-800">{{ $title }}
    </div>
    <div class="flex mt-1">
        <label class="flex cursor-pointer items-center justify-start rounded-md px-1 py-1 text-sm font-semibold focus:outline-none sm:flex-1">
            <input type="radio" name="{{ $aria_label. '_radio_0' }}" 
            value={{ $value0 }} 
            {{ $attributes->merge(['class' => '' ]) }}
            />
            <div class="pl-2 ">{{ $text_value0 }}</div>
        </label>
        <label class="flex cursor-pointer items-center justify-start rounded-md px-1 py-1 text-sm font-semibold focus:outline-none sm:flex-1">
            <input type="radio" name="{{ $aria_label. '_radio_1' }}" 
            value={{ $value1 }} 
            {{ $attributes->merge(['class' => '' ]) }}
            />
            <div white-space="nowrap" class="pl-2 ">{{ $text_value1 }}</div>
        </label>
    </div>
</div>
