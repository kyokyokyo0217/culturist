require('@/bootstrap')

import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import '@mdi/font/css/materialdesignicons.css'
import store from '@/store'
import router from '@/router'

import App from '@/App.vue'

Vue.use(Vuetify)

const createApp = async () => {
    await store.dispatch('auth/currentUser')

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
}

createApp()
