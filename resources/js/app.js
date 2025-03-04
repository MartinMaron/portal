require('./bootstrap');

import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import mask from '@alpinejs/mask'
const ToastComponent = require('../../vendor/usernotnull/tall-toasts/dist/js/tall-toasts');
Alpine.plugin(ToastComponent)
Alpine.plugin(mask)

Livewire.start()
