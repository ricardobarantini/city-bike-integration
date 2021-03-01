require('./bootstrap');

import Vue from 'vue';

import PageIndex from './pages/Index';

const app = new Vue({
    el: '#app',
    components: {
        PageIndex,
    }
});
