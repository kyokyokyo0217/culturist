import Vue from 'vue'
import VueRouter from 'vue-router'

import Landing from './components/Landing.vue'
import Login from './components/Login.vue'
import Signup from './components/Signup.vue'

import Feed from './components/Feed.vue'
import Trending from './components/Trending.vue'
import Likes from './components/Likes.vue'
import History from './components/History.vue'
import WorkDetail from './components/WorkDetail.vue'
import Upload from './components/Upload.vue'
import UserProfile from './components/UserProfile.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    component: Landing
  },
  {
    path: '/login',
    component: Login
  },
  {
    path: '/signup',
    component: Signup
  },
  {
    path: '/feed',
    component: Feed
  },
  {
    path: '/trending',
    component: Trending
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
    path: '/work/:workId',
    component: WorkDetail
  },
  {
    path: '/upload',
    component: Upload
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
