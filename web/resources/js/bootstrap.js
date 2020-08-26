window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) { }

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import { getCookieValue } from './util'
import store from '@/store'
import status from '@/constants.js'

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.timeout = 10000;

window.axios.interceptors.request.use(config => {
    config.headers['X-XSRF-TOKEN'] = getCookieValue('XSRF-TOKEN')

    return config
})

window.axios.interceptors.response.use(
    //成功時
    response => response,
    //エラー時
    function (error) {
        if (error.code === 'ECONNABORTED') {
            //axiosのタイムアウト時
            store.dispatch('error/setCode', status.REQUEST_TIMEOUT)
            return error
        } else if (error.response) {
            //The request was made and the server responded with a status code
            // 非同期が失敗した場合はreponseオブジェクトを代入→そのままstatuscodeとか使える
            return error.response
        } else if (error.request) {
            // The request was made but no response was received
            // `error.request` is an instance of XMLHttpRequest in the browser
            return error.request
        }
    }
)

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
  // broadcaster: 'pusher',
  // key: process.env.MIX_PUSHER_APP_KEY,
  // cluster: process.env.MIX_PUSHER_APP_CLUSTER,
  // encrypted: true
// });
