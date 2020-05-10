<template>
  <content-layout>
    <template v-slot:title>
      Likes
    </template>
    <template v-slot:content>
      <select-chip></select-chip>
      <works-index :cols="3" :pictures=pictures :tracks=tracks></works-index>
    </template>
  </content-layout>
</template>
<script>
  import ContentLayout from '../core/ContentLayout.vue'
  import WorksIndex from '../shared/WorksIndex.vue'
  import SelectChip from '../shared/SelectChip.vue'
  export default {
    components: {
      ContentLayout,
      WorksIndex,
      SelectChip
    },
    data: function(){
      return{
        pictures: [],
        tracks: []
      }
    },
    computed: {
      selectedChip(){
        return this.$store.getters['selectChip/selectedChip']
      }
    },
    methods:{
      async fetchPhotos () {
        const response = await axios.get('/api/pictures/likes')

        // if (response.status !== OK) {
        //   this.$store.commit('error/setCode', response.status)
        //   return false
        // }

        this.pictures = response.data.data

      },
      async fetchTracks () {
        const response = await axios.get('/api/tracks/likes')
        this.tracks = response.data.data
      }
    },
    mounted(){
        this.$store.commit('selectChip/selectChip', 'music')
    },
    // 最初pictureの時がある バグ
    watch: {
      selectedChip: {
        async handler () {
          if(this.selectedChip ==  "music"){
            await this.fetchTracks()
          }else if (this.selectedChip ==  "picture") {
            await this.fetchPhotos()
          }
        },
        immediate: true
      }
    }
  }
</script>
