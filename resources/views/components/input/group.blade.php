

@props([
    'label',
    'for',
    'error' => false,
    'helpText' => false,
    'paddingless' => false,
    'borderless' => false,
    'bottom' => true,
    'labelless' => '',
    'inputBorderless' => false,
    'hohe' => 'h-10',
    'hoheOnError' => 'h-12',
    'hoheLabel' => 'h-auto',
    'hoheContent' => 'h-auto',
    'hoheContentOnError' => 'h-auto',
    'labelDirection' => 'text-right',
    'errorDirection' => 'text-right',
    'paddingLabel' => 'pt-3',
    'alignLabel' => 'align-bottom',
    'forceBlock' => 'block sm:flex',
    'labelsColSpan' => '2',
    'slotColSpan' => '4'
])
    <div
        class="{{ $forceBlock }} {{ $error ? $hoheOnError : $hohe }} {{ $error ? 'mb-2 sm:mb-1' : '' }} sm:mt-1 sm:grid sm:grid-cols-6 sm:gap-2 {{ $bottom ? 'sm:items-end' : 'sm:items-start' }}">
        <div class="sm:col-span-{{ $labelsColSpan }}
            {{ $alignLabel }}
            {{ $hoheLabel }}
            {{ $borderless ? '' : 'border-b-2 border-l-2 sm:border-r-2 sm:border-l-0 rounded border-sky-800/50 dark:border-slate-500' }}
            {{ $bottom ? '' : 'pt-2' }}
            {{ $error ? 'pb-2 text-red-500' : '' }}
            {{ $labelless ? 'hidden' : '' }}
            sm:{{ $labelDirection }}
            px-2 block sm:text-sm font-medium leading-5 text-sky-950 dark:text-slate-100">
            <label for="{{ $for }}"
                class="{{ $alignLabel }}
                       {{ $paddingLabel }}
                       {{ $hoheLabel }}">
                {{ $label }}
            </label>
        </div>
        <div class="flex
            {{ $error ? $hoheContentOnError : $hoheContent }}
            {{ $borderless || $inputBorderless ? '' : 'border-b-2 border-l-2 sm:border-r-0 border-solid rounded border-sky-800/50 dark:border-slate-500' }}
            {{ $labelless ? 'sm:col-span-6' : 'sm:col-span-'. $slotColSpan }}
            ">
            {{ $slot }}
            @if ($error)
            <div class="text-clip overflow-hidden  mt-1 {{ $errorDirection }} text-red-500 text-sm">{{ $error }}</div>
            @endif
        </div>
        
    </div>

