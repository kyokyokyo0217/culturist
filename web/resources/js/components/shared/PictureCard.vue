<template>
  <v-card
    tile
    outlined
  >
    <v-img
      @click="overlay = true"
      :src="item.url"
      aspect-ratio="1"
      class="picture-card"
    >
    </v-img>

    <picture-detail-card
      v-if="overlay"
      @closeDetail="overlay = false"
      :item=item
    ></picture-detail-card>
  </v-card>
</template>
<script>
import PictureDetailCard from './PictureDetailCard.vue'
export default{
  components:{
    PictureDetailCard
  },
  props: {
    item: Object
  },
  data(){
    return{
      overlay: false,
      liked: false
    }
  },
  methods:{
    like(){
      this.liked = true
    },
    unlike(){
      this.liked = false
    }
  }
}
</script>
<style scoped>
  .picture-card:hover{
    cursor: zoom-in;
  }
</style>
