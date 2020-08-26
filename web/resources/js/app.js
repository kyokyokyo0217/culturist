require('@/bootstrap')

import Vue from 'vue'
import Vuetify from 'vuetify'
import store from '@/store'
import router from '@/router'

import 'vuetify/dist/vuetify.min.css'
import '@mdi/font/css/materialdesignicons.css'
import '../css/global.css'

import App from '@/App.vue'

Vue.use(Vuetify)

new Vue({
    el: '#app',
    store,
    router,
    vuetify: new Vuetify({
        icons: {
            iconfont: 'mdi',
        },
    }),
    components: { App },
    template: '<App />'
})
