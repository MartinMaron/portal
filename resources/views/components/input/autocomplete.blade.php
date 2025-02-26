@props([
    'error' => false,
    'leadingAddOn' => false,
    'customPlaceholder' => false,
    'customId' => false,
    'fieldname' => 'input',
    'data' => '',
])

<div
    {{ $attributes->merge(['class' => 'autocomplete placeholder-gray-300 flex-1 block w-full transition duration-150 ease-in-out focus:outline-none focus:border focus:border-blue-900 sm:rounded sm:text-sm sm:leading-5' . ($leadingAddOn ? ' rounded-none rounded-r-md' : '')]) }}
>
    <input
    {{ $attributes->whereDoesntStartWith('wire:model') }}
    x-data="
        {
            data:'',
            currentFocus: -1,
            value: @entangle($attributes->wire('model')),

            closeAllLists(elmnt) {
                /*close all autocomplete lists in the document,
                except the one passed as an argument:*/
                var x = document.getElementsByClassName('input-autocomplete-items');
                for (var i = 0; i < x.length; i++) {
                    if (elmnt != x[i] && elmnt != $refs.{{ $fieldname }})
                    {
                        x[i].parentNode.removeChild(x[i]);
                    }
                }
            },

            removeActive(x,cf) {
                /*a function to remove the 'active' class from all autocomplete items:*/
                for (var i = 0; i < x.length; i++) {
                    x[i].classList.remove('input-autocomplete-active');
                }
            },

            addActive(x, cf) {
                if (!x) return false;
                this.removeActive(x, cf);
                if (cf >= x.length) cf = 0;
                if (cf < 0) cf = (x.length - 1);
                x[cf].classList.add('input-autocomplete-active');
                return cf;
            },

            }"
    x-init="
            this.data={{ $data }}


            $el.addEventListener('input', function(e) {
                var data = {{ $data }} ;
                console.log(data);

                var a, b, c, d, i, val = this.value;
                closeAllLists();
                if (!val) { return false;}
                currentFocus = -1;
                a = document.createElement('div');
                a.setAttribute('id', '{{ $customId }}' + '_autocomplete_' + '{{ $fieldname }}');
                a.setAttribute('class', 'input-autocomplete-items');
                this.parentNode.appendChild(a);
                for (i = 0; i < data.length; i++) {
                    if (data[i].substr(0, val.length).toUpperCase() == val.toUpperCase())
                    {
                        b = document.createElement('div');
                        b.setAttribute('class', 'flex');
                            c = document.createElement('span');
                            c.setAttribute('class', 'input-autocomplete-filtered-string');
                            c.innerHTML = data[i].substr(0, val.length);
                            d = document.createElement('span');
                            d.setAttribute('class', 'input-autocomplete-normal-string');
                            d.innerHTML = data[i].substr(val.length);
                            e = document.createElement('input');
                            e.setAttribute('type', 'hidden');
                            e.value = data[i];
                        b.appendChild(c);
                        b.appendChild(d);
                        b.appendChild(e);
                        b.addEventListener('click', function(e) {
                            $el.value = this.getElementsByTagName('input')[0].value;
                            
                        });
                        a.appendChild(b);
                    }
                }

            });

            $el.addEventListener('keydown', function(e) {
                var x = document.getElementById('{{ $customId }}' + '_autocomplete_' + '{{ $fieldname }}');
                if (x) x = x.getElementsByTagName('div');

                if (typeof this.currentFocus === 'undefined')
                {
                    this.currentFocus = -1
                }

                if (e.keyCode == 40) {
                    this.currentFocus++;
                    this.currentFocus = addActive(x,this.currentFocus);
                } else if (e.keyCode == 38) { //up
                    this.currentFocus--;
                    this.currentFocus = addActive(x,this.currentFocus);
                } else if (e.keyCode == 13) {
                    e.preventDefault();
                    if (this.currentFocus > -1) {
                    if (x) x[this.currentFocus].click();
                    }
                }
            });

            document.addEventListener('click', function (e) {
                closeAllLists(e.target);
            });

            "
    x-ref="{{ $fieldname }}"
    x-bind:value="value"
    class="autocomplete-input transition pl-1 duration-150 ease-in-out focus:outline-none focus:border focus:border-blue-500"
/>

    @if ($error)
        <div class="mt-1 text-red-500 text-sm">{{ $error }}</div>
    @endif

</div>




