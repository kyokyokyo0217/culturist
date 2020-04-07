require('./bootstrap')

import Vue from 'vue'
import router from './router'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import '@mdi/font/css/materialdesignicons.css'

import App from './components/App.vue'
Vue.use(Vuetify)

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
