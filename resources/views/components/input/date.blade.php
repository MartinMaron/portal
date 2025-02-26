
@props([
     'readonly' => false,
     'disabled' => false,
     'placeholder' => "TT.MM.JJJJ"
])

<div class="flex rounded-md  ">
    <input  
        placeholder= {{ $placeholder }}
        x-mask="99.99.9999"
        {{ $attributes->merge(['class' => 'border-0 flex-1 pl-1 block w-full 
                                            transition duration-150 ease-in-out 
                                            focus:outline-none focus:border focus:border-blue-500 
                                            rounded text-sm lg:text-sm sm:leading-5 
                                            border-gray-300 dark:bg-slate-700 dark:text-slate-100']) }}
                                            {{ $readonly ?? false ? 'readonly' :'' }}
                                            {{ $disabled ?? false ? 'disabled' :'' }}
                                            />
</div>  


