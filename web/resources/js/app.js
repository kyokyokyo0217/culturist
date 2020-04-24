require('./bootstrap')

import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import '@mdi/font/css/materialdesignicons.css'
import store from './store'
import router from './router'
import EventHub from './EventHub'

import App from './App.vue'

Vue.use(Vuetify)
Vue.use(EventHub)

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
