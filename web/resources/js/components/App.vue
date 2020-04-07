<template>
  <v-app>
   <Navigation></Navigation>
    <v-content>
      <v-container
        class="fill-height pa-0"
        fluid
      >
        <RouterView />
      </v-container>
    </v-content>
    <AudioPlayer :file="audio"></AudioPlayer>
  </v-app>
</template>

<script>
  import Navigation from './Navigation.vue'
  import AudioPlayer from './AudioPlayer.vue'
  export default {
    components: {
      Navigation,
      AudioPlayer
    },
    data(){
      return{
        audio: '/audio/jinglebells.mp3'
      }
    },
  }
</script>
