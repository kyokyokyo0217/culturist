<template>
  <v-app>
    <navigation-drawer v-if="isLogin"></navigation-drawer>
    <app-bar></app-bar>
    <main-view></main-view>
    <audio-player v-if="visible" :file="nowPlaying"></audio-player>
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
        visible: false,
      }
    },
    computed: {
      isLogin () {
        return this.$store.getters['auth/check']
      },
      nowPlaying () {
        return this.$store.getters['track/track']
      }
    },
    watch: {
      nowPlaying (val, old) {
        this.visible = true
      }
    }
  }
</script>
