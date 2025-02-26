
<div class="flex rounded-md">
    <input {{ $attributes }}
        type="checkbox"
        class="checkbox block sm:ml-1 sm:mt-1 transition duration-150 ease-in-out sm:text-sm text-sky-300 focus:outline-none focus:border-2 focus:border-sky-300 sm:rounded-sm"
    />
    <div class="h-6 text-left sm:mt-1 sm:text-right sm:col-span-2 pl-2 border-blue-200/50 block lg:text-sm sm:text-sm font-normal leading-5 text-gray-500 sm:pt-0 sm:pb-0">
        {{ $slot }}
    </div>
</div>
