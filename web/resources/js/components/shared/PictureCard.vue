<template>
  <v-card
    tile
    outlined
  >
    <!-- <v-hover v-slot:default="{ hover }">
      <v-img
        @click="overlay = true"
        :src="item.src"
        aspect-ratio="1"
        :class="{'image-clickable': hover}"
        :gradient="hover ? 'to top, rgba(0, 0, 0, 0.4) 0%, transparent 180px' : undefined"
      >
      </v-img>
    </v-hover> -->

    <v-img
      @click="overlay = true"
      :src="item.src"
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
    item: {
      type:Object,
      required: true,
    }
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
