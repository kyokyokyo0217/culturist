<template>
  <v-container fluid>
    <v-row>
      <v-col
        v-for="(picture, index) in pictures"
        :key="index"
        class="d-flex child-flex"
        :cols="cols"
      >
      <!-- <track-card v-if="selectMusic" :item=work :pictures=pictures></track-card> -->
      <picture-card :item=picture v-if="selectPicture"></picture-card>
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
    pictures: Array
  },
  mounted: function () {
    this.$eventHub.$on('selectMusic', this.getMusic)
    this.$eventHub.$on('selectPicture', this.getPicture)
  },
  data(){
    return{
      selectMusic: true,
      selectPicture: false,
      works:[
          {title: 'muscle', userName: 'muscleman', src: '/img/muscle.png'},
          {title: 'avatar', userName: 'avatarman', src: '/img/avator.png'},
          {title: 'back', userName: 'photoman', src: '/img/background.jpg'}
      ]
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
