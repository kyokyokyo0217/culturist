<template>
  <v-app>
    <navigation-drawer></navigation-drawer>
    <app-bar></app-bar>
    <main-view></main-view>
    <audio-player :file="audio"></audio-player>
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
        audio: '/audio/jinglebells.mp3'
      }
    },
  }
</script>
