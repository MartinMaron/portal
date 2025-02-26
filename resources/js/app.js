require('./bootstrap');

import Alpine from 'alpinejs';
import mask from '@alpinejs/mask'
import * as ToastComponent from '../../vendor/usernotnull/tall-toasts/dist/js/tall-toasts'

Alpine.data('ToastComponent', ToastComponent)

Alpine.plugin(mask)

window.Alpine = Alpine;

Alpine.start();
