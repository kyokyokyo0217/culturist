<template>
  <content-layout>
    <template v-slot:title>
      Feed
    </template>
    <template v-slot:content>
      <works-index :cols="3" :pictures=pictures :tracks=tracks></works-index>
    </template>
  </content-layout>
</template>
<script>
  import ContentLayout from '../core/ContentLayout.vue'
  import WorksIndex from '../shared/WorksIndex.vue'
  export default {
    components: {
      ContentLayout,
      WorksIndex
    },
    data: function(){
      return{
        pictures: [],
        tracks: []
      }
    },
    methods:{
      async fetchPhotos () {
        const response = await axios.get('/api/pictures')

        // if (response.status !== OK) {
        //   this.$store.commit('error/setCode', response.status)
        //   return false
        // }

        this.pictures = response.data.data
      },
      async fetchTracks () {
        const response = await axios.get('/api/tracks')
        this.tracks = response.data.data
      }
    },
    watch: {
      $route: {
        async handler () {
          await this.fetchTracks()
          // await this.fetchPhotos()
        },
        immediate: true
      }
    }
  }
</script>
