<template>
  <v-app>
    <navigation-drawer v-if="isLogin"></navigation-drawer>
    <app-bar></app-bar>
    <main-view></main-view>
    <audio-player :file="audio" v-if="isLogin"></audio-player>
  </v-app>
</template>

<script>
  import NavigationDrawer from './components//core/NavigationDrawer.vue'
  import AudioPlayer from './components/core/AudioPlayer.vue'
  import MainView from './components/core/MainView.vue'
  import AppBar from './components/core/AppBar.vue'
  export default {
    components: {
      NavigationDrawer,
      AppBar,
      MainView,
      AudioPlayer,
    },
    data(){
      return{
        audio: '/audio/jinglebells.mp3',
        auth: false
      }
    },
    computed: {
      isLogin () {
        return this.$store.getters['auth/check']
      },
    },
  }
</script>
