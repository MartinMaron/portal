import './bootstrap';
import Alpine from 'alpinejs';
import mask from '@alpinejs/mask';
import ToastComponent from '../../vendor/usernotnull/tall-toasts/resources/js/tall-toasts';

// Register Alpine plugins
Alpine.plugin(mask);
Alpine.plugin(ToastComponent);

// Make Alpine available on the window object
window.Alpine = Alpine;

// Start Alpine
Alpine.start();
