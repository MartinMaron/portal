import "./bootstrap";

import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import mask from '@alpinejs/mask'
import '../../vendor/usernotnull/tall-toasts/resources/js/tall-toasts'
Alpine.plugin(mask)
Livewire.start()
