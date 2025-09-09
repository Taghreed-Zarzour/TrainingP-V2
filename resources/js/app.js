import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;


require('./bootstrap');

// استدعاء المكونات الأخرى
try {
    window.Vue = require('vue');
    Vue.component('example-component', require('./components/ExampleComponent.vue').default);
    
    const app = new Vue({
        el: '#app',
    });
} catch (e) {
    console.log('Vue not loaded');
}