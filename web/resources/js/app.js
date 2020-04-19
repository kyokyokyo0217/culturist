require('./bootstrap')

import Vue from 'vue'
import router from './router'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import '@mdi/font/css/materialdesignicons.css'
import EventHub from './EventHub'

import App from './App.vue'

Vue.use(Vuetify)
Vue.use(EventHub)

new Vue({
    el: '#app',
    router,
    vuetify: new Vuetify({
      icons: {
        iconfont: 'mdi',
      },
    }),
    components: { App },
    template: '<App />'
})
