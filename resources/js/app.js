import "./bootstrap";

import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import mask from '@alpinejs/mask'
import ToastComponent from '../../vendor/usernotnull/tall-toasts/resources/js/tall-toasts'
Alpine.plugin(ToastComponent)
Alpine.plugin(mask)

Livewire.start()
