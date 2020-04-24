import Vue from 'vue'
import VueRouter from 'vue-router'

import Login from './components/pages/Login.vue'
import SignUp from './components/pages/SignUp.vue'
import Feed from './components/pages/Feed.vue'
import Trending from './components/pages/Trending.vue'
import Likes from './components/pages/Likes.vue'
import History from './components/pages/History.vue'
import Upload from './components/pages/Upload.vue'
import UserProfile from './components/pages/UserProfile.vue'
import SearchResult from  './components/pages/SearchResult.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/login',
    component: Login,
  },
  {
    path: '/signup',
    component: SignUp,
  },
  {
    path: '/feed',
    component: Feed,
  },
  {
    path: '/trending',
    component: Trending,
  },
  {
    path: '/likes',
    component: Likes
  },
  {
    path: '/history',
    component: History
  },
  {
    path: '/upload',
    component: Upload
  },
  {
    path: '/search*',
    component: SearchResult
  },
  {
    path: '/:userId',
    component: UserProfile
  }
]

const router = new VueRouter({
  mode: 'history',
  routes
})

export default router
