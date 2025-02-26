@props([
    'leadingAddOn' => false,
    'customPlaceholder' => false,
    'customId' => false,
    'customName' => false,
])

<div class="flex rounded-md sm:pt-0">
    @if ($leadingAddOn)
        <span class="inline-flex items-center px-3 rounded-l-md  border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
            {{ $leadingAddOn }}
        </span>
    @endif
    <div
        x-data="select({
            name: 'lokalart',
            placeholder: 'Auswahlbox',
            value: '' })"
        x-init="init()"
        {{-- @click.away="closeListbox()"
        @keydown.escape="closeListbox()" --}}
        class="relative"
    >
        <input id={{ $customId }}
            type="text"
            name={{ $customName }}
            placeholder={{ $customPlaceholder }}
            {{ $attributes->merge(['class' => 'autocomplete-input placeholder-gray-300 flex-1 pl-1 form-input  block w-full transition duration-150 ease-in-out focus:outline-none focus:border-2 focus:border-sky-300 sm:rounded sm:text-sm lg:text-sm sm:leading-5' . ($leadingAddOn ? ' rounded-none rounded-r-md' : '')]) }}
        />


    <script>
        function select(config) {
            return {
                data: config.data,

                emptyOptionsMessage: '',

                focusedOptionIndex: null,

                name: config.name,

                open: false,

                options: {},

                placeholder: config.placeholder ?? 'Select an option',

                search: '',

                id:28,

                value: config.value,

                input_autocomplete_active_class: 'input-autocomplete-active',
                input_autocomplete_filtered_string_class:'input-autocomplete-filtered-string',
                input_autocomplete_items_class:'c',
                id_suffix:'autocmplete-list',

                countries: ['Afghanistan','Albania','Algeria','Andorra','Angola','Anguilla','Antigua & Barbuda','Argentina','Armenia','Aruba','Australia','Austria','Azerbaijan','Bahamas','Bahrain','Bangladesh','Barbados','Belarus','Belgium','Belize','Benin','Bermuda','Bhutan','Bolivia','Bosnia & Herzegovina','Botswana','Brazil','British Virgin Islands','Brunei','Bulgaria','Burkina Faso','Burundi','Cambodia','Cameroon','Canada','Cape Verde','Cayman Islands','Central Arfrican Republic','Chad','Chile','China','Colombia','Congo','Cook Islands','Costa Rica','Cote D Ivoire','Croatia','Cuba','Curacao','Cyprus','Czech Republic','Denmark','Djibouti','Dominica','Dominican Republic','Ecuador','Egypt','El Salvador','Equatorial Guinea','Eritrea','Estonia','Ethiopia','Falkland Islands','Faroe Islands','Fiji','Finland','France','French Polynesia','French West Indies','Gabon','Gambia','Georgia','Germany','Ghana','Gibraltar','Greece','Greenland','Grenada','Guam','Guatemala','Guernsey','Guinea','Guinea Bissau','Guyana','Haiti','Honduras','Hong Kong','Hungary','Iceland','India','Indonesia','Iran','Iraq','Ireland','Isle of Man','Israel','Italy','Jamaica','Japan','Jersey','Jordan','Kazakhstan','Kenya','Kiribati','Kosovo','Kuwait','Kyrgyzstan','Laos','Latvia','Lebanon','Lesotho','Liberia','Libya','Liechtenstein','Lithuania','Luxembourg','Macau','Macedonia','Madagascar','Malawi','Malaysia','Maldives','Mali','Malta','Marshall Islands','Mauritania','Mauritius','Mexico','Micronesia','Moldova','Monaco','Mongolia','Montenegro','Montserrat','Morocco','Mozambique','Myanmar','Namibia','Nauro','Nepal','Netherlands','Netherlands Antilles','New Caledonia','New Zealand','Nicaragua','Niger','Nigeria','North Korea','Norway','Oman','Pakistan','Palau','Palestine','Panama','Papua New Guinea','Paraguay','Peru','Philippines','Poland','Portugal','Puerto Rico','Qatar','Reunion','Romania','Russia','Rwanda','Saint Pierre & Miquelon','Samoa','San Marino','Sao Tome and Principe','Saudi Arabia','Senegal','Serbia','Seychelles','Sierra Leone','Singapore','Slovakia','Slovenia','Solomon Islands','Somalia','South Africa','South Korea','South Sudan','Spain','Sri Lanka','St Kitts & Nevis','St Lucia','St Vincent','Sudan','Suriname','Swaziland','Sweden','Switzerland','Syria','Taiwan','Tajikistan','Tanzania','Thailand','Timor LEste','Togo','Tonga','Trinidad & Tobago','Tunisia','Turkey','Turkmenistan','Turks & Caicos','Tuvalu','Uganda','Ukraine','United Arab Emirates','United Kingdom','United States of America','Uruguay','Uzbekistan','Vanuatu','Vatican City','Venezuela','Vietnam','Virgin Islands (US)','Yemen','Zambia','Zimbabwe'],

                autocomplete: function (inp, arr)
                {
                    alert("28_autocomplete_inpLage")
                    /*the autocomplete function takes two arguments,
                    the text field element and an array of possible autocompleted values:*/
                    var currentFocus;
                    /*execute a function when someone writes in the text field:*/
                    inp.addEventListener("input", function(e) {
                        var a, b, i, val = this.value;
                        /*close any already open lists of autocompleted values*/
                        closeAllLists();
                        if (!val) { return false;}
                        currentFocus = -1;
                        /*create a DIV element that will contain the items (values):*/
                        a = document.createElement("div");
                        a.setAttribute("id", "28_autocomplete_inpLage");
                        a.setAttribute("class", this.input_autocomplete_items_class);
                        /*append the DIV element as a child of the autocomplete container:*/
                        this.parentNode.appendChild(a);
                        /*for each item in the array...*/
                        for (i = 0; i < arr.length; i++) {
                            /*check if the item starts with the same letters as the text field value:*/
                            if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                            /*create a DIV element for each matching element:*/
                            b = document.createElement("div");
                            /*make the matching letters bold:*/
                            b.innerHTML = "<strong class='" + this.input_autocomplete_filtered_string_class + "'>" + arr[i].substr(0, val.length) + "</strong>";
                            b.innerHTML += arr[i].substr(val.length);
                            /*insert a input field that will hold the current array item's value:*/
                            b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                            /*execute a function when someone clicks on the item value (DIV element):*/
                                b.addEventListener("click", function(e) {
                                    /*insert the value for the autocomplete text field:*/
                                    inp.value = this.getElementsByTagName("input")[0].value;
                                /*close the list of autocompleted values,
                                (or any other open lists of autocompleted values:*/
                                closeAllLists();
                            });
                            a.appendChild(b);
                            }
                        }
                    });
                    /*execute a function presses a key on the keyboard:*/
                    inp.addEventListener("keydown", function(e) {
                        var x = document.getElementById("28_autocomplete_inpLage");
                        if (x) x = x.getElementsByTagName("div");
                        if (e.keyCode == 40) {
                            /*If the arrow DOWN key is pressed,
                            increase the currentFocus variable:*/
                            currentFocus++;
                            /*and and make the current item more visible:*/
                            addActive(x);
                        } else if (e.keyCode == 38) { //up
                            /*If the arrow UP key is pressed,
                            decrease the currentFocus variable:*/
                            currentFocus--;
                            /*and and make the current item more visible:*/
                            addActive(x);
                        } else if (e.keyCode == 13) {
                            /*If the ENTER key is pressed, prevent the form from being submitted,*/
                            e.preventDefault();
                            if (currentFocus > -1) {
                            /*and simulate a click on the "active" item:*/
                            if (x) x[currentFocus].click();
                            }
                        }
                    });
                    function addActive(x) {
                        /*a function to classify an item as "active":*/
                        if (!x) return false;
                        /*start by removing the "active" class on all items:*/
                        removeActive(x);
                        if (currentFocus >= x.length) currentFocus = 0;
                        if (currentFocus < 0) currentFocus = (x.length - 1);
                        /*add class "autocomplete-active":*/
                        x[currentFocus].classList.add('input-autocomplete-active');
                    }
                    function removeActive(x) {
                        /*a function to remove the "active" class from all autocomplete items:*/
                        for (var i = 0; i < x.length; i++) {
                        x[i].classList.remove('input-autocomplete-active');
                        }
                    }
                    function closeAllLists(elmnt) {
                        /*close all autocomplete lists in the document,
                        except the one passed as an argument:*/
                        var x = document.getElementsByClassName(this.input_autocomplete_items_class);
                        for (var i = 0; i < x.length; i++) {
                        if (elmnt != x[i] && elmnt != inp) {
                            x[i].parentNode.removeChild(x[i]);
                        }
                        }
                    }
                    /*execute a function when someone clicks in the document:*/
                    document.addEventListener("click", function (e) {
                        closeAllLists(e.target);
                    });
                },

                init: function () {
                    this.options = this.data
                    this.autocomplete(document.getElementById("28_autocomplete_inpLage"), this.countries);

                },
            }
        }
    </script>

    </div>

</div>
