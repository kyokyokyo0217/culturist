require('@/bootstrap')

import Vue from 'vue'

import store from '@/store'
import router from '@/router'
import vuetify from '@/vuetify'

import '../css/global.css'

import App from '@/App.vue'

new Vue({
    el: '#app',
    store,
    router,
    vuetify,
    components: { App },
    template: '<App />'
})
