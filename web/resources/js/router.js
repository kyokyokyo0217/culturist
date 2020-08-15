import Vue from 'vue'
import VueRouter from 'vue-router'

import store from '@/store'

import Login from '@components/pages/Login.vue'
import SignUp from '@components/pages/SignUp.vue'
import Explore from '@components/pages/Explore.vue'
import Feed from '@components/pages/Feed.vue'
import Setting from '@components/pages/Setting.vue'
import Likes from '@components/pages/Likes.vue'
import Upload from '@components/pages/Upload.vue'
import UserProfile from '@components/pages/UserProfile.vue'
import SearchResult from '@components/pages/SearchResult.vue'
import SystemError from '@components/pages/SystemError.vue'
import NotFoundError from '@components/pages/NotFoundError.vue'

Vue.use(VueRouter)

const routes = [
    {
        path: '/login',
        component: Login,
        beforeEnter(to, from, next) {
            if (store.getters['auth/check']) {
                next('/explore')
            } else {
                next()
            }
        }
    },
    {
        path: '/',
        redirect: '/explore'
    },
    {
        path: '/signup',
        component: SignUp,
        beforeEnter(to, from, next) {
            if (store.getters['auth/check']) {
                next('/explore')
            } else {
                next()
            }
        }
    },
    {
        path: '/explore',
        component: Explore,
    },
    {
        path: '/feed',
        component: Feed,
        beforeEnter(to, from, next) {
            if (store.getters['auth/check']) {
                next()
            } else {
                next('/explore')
            }
        }
    },
    {
        path: '/likes',
        component: Likes,
        beforeEnter(to, from, next) {
            if (store.getters['auth/check']) {
                next()
            } else {
                next('/explore')
            }
        }
    },
    {
        path: '/setting',
        component: Setting,
        beforeEnter(to, from, next) {
            if (store.getters['auth/check']) {
                next()
            } else {
                next('/explore')
            }
        }
    },
    {
        path: '/upload',
        component: Upload,
        beforeEnter(to, from, next) {
            if (store.getters['auth/check']) {
                next()
            } else {
                next('/explore')
            }
        }
    },
    {
        path: '/search*',
        component: SearchResult
    },
    {
        path: '/user/:username',
        component: UserProfile,
        name: 'user'
    },
    {
        path: '/500',
        component: SystemError
    },
    {
        path: '*',
        component: NotFoundError
    },
]

const router = new VueRouter({
    mode: 'history',
    routes
})

export default router
