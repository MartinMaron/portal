require('./bootstrap');

import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import mask from '@alpinejs/mask'
import ToastComponent from '../../vendor/usernotnull/tall-toasts/dist/js/tall-toasts'

Alpine.data('ToastComponent', ToastComponent)
Alpine.plugin(ToastComponent)
Alpine.plugin(mask)

Livewire.start()
