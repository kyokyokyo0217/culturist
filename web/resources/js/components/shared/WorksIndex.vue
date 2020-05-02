<template>
  <v-container fluid>
    <v-row>
      <v-col
        v-if="selectMusic"
        v-for="(track, index) in tracks"
        :key="index"
        class="d-flex child-flex"
        :cols="cols"
      >
        <track-card :item=track></track-card>
      </v-col>
      <v-col
        v-if="selectPicture"
        v-for="(picture, index) in pictures"
        :key="index"
        class="d-flex child-flex"
        :cols="cols"
      >
        <picture-card :item=picture></picture-card>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
import TrackCard from './TrackCard.vue'
import PictureCard from './PictureCard.vue'
export default {
  components:{
    TrackCard,
    PictureCard
  },
  props:{
    cols: Number,
    pictures: Array,
    tracks: Array
  },
  mounted: function () {
    this.$eventHub.$on('selectMusic', this.getMusic)
    this.$eventHub.$on('selectPicture', this.getPicture)
  },
  data(){
    return{
      selectMusic: true,
      selectPicture: false,
    }
  },
  methods:{
    getMusic(){
      this.selectMusic = !this.selectMusic
      this.selectPicture = !this.selectPicture
      console.log('get music!')
    },
    getPicture(){
      this.selectMusic = !this.selectMusic
      this.selectPicture = !this.selectPicture
      console.log('get picture!')
    }
  }
}
</script>
