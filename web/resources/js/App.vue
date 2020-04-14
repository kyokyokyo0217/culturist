<template>
  <v-app>
    <navigation-drawer></navigation-drawer>
    <main-view></main-view>
    <audio-player :file="audio"></audio-player>
  </v-app>
</template>

<script>
  import NavigationDrawer from './components//core/NavigationDrawer.vue'
  import AudioPlayer from './components/core/AudioPlayer.vue'
  import MainView from './components/core/View.vue'
  export default {
    components: {
      NavigationDrawer,
      AudioPlayer,
      MainView
    },
    data(){
      return{
        audio: '/audio/jinglebells.mp3'
      }
    },
  }
</script>
