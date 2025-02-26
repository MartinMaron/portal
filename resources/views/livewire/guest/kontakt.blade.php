<form class="space-y-6" wire:submit.prevent="send">
   
    
    <div class="grid grid-cols-6 gap-6">
        <div class="col-span-6 sm:col-span-6">
            <x-input.group labelless="true" borderless="true" for="first-name" label="first-name" :error="$errors->first('nachname')">
                <label for="first-name" class="block text-sm font-medium text-gray-700" :error="$errors->first('nachname')" >Name</label>
                <input type="text" wire:model="nachname" name="first-name" id="first-name" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </x-input.group>
        </div>
        <div class="col-span-6 sm:col-span-6">
            <x-input.group labelless="true" borderless="true" for="email-address" label="email-address" :error="$errors->first('email')">
                <label for="email-address" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="text" wire:model="email" name="email-address" id="email-address" autocomplete="email" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </x-input.group>
        </div>
        <div class="col-span-6 sm:col-span-6">
            <x-input.group labelless="true" borderless="true" for="telefon" label="telefon" :error="$errors->first('telefon')">
                <label for="telefon" class="block text-sm font-medium text-gray-700">Telefon</label>
                <input type="text" wire:model="telefon" name="telefon" id="telefon" autocomplete="telefon" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </x-input.group>
        </div>
        <div class="col-span-6 sm:col-span-6">
            <x-input.group labelless="true" borderless="true" for="Liegenschaftsadresse" label="Liegenschaftsadresse" :error="$errors->first('adresse')">
                <label for="Liegenschaftsadresse" class="block text-sm font-medium text-gray-700">Telefon</label>
                <input type="text" wire:model="adresse" name="Liegenschaftsadresse" id="Liegenschaftsadresse" autocomplete="Liegenschaftsadresse" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </x-input.group>
        </div>

        <div class="h-48 col-span-6 sm:col-span-6">
            <x-input.group class="" errorDirection="text-left" labelless="true" borderless="true" for="anliegen" label="anliegen" :error="$errors->first('anliegen')">
                <label for="about" class="block text-sm font-medium text-gray-700"> Ihr Anliegen </label>
                <div class="mt-1">
                  <textarea id="about" wire:model="anliegen" name="about" rows="8" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="..."></textarea>
                </div>
            </x-input.group>
        </div>
        <div class="col-span-6 sm:col-span-6">
            <div class="mt-3 flex justify-end">
                <button type="submit" class="ml-3 w-40 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Senden</button>
            </div>
        </div>
       
        
      </div>

    
  </form>
