<template>
  <v-container fluid>
    <v-row>
      <v-col
        v-if="selectedChip == 'music'"
        v-for="(track, index) in tracks"
        :key="index"
        class="d-flex child-flex"
        :cols="cols"
      >
        <track-card :item=track :edit=edit @fetchTracks="fetchTracks"></track-card>
      </v-col>
      <v-col
        v-if="selectedChip == 'picture'"
        v-for="(picture, index) in pictures"
        :key="index"
        class="d-flex child-flex"
        :cols="cols"
      >
        <picture-card :item=picture :edit=edit @fetchPhotos="fetchPhotos"></picture-card>
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
    tracks: Array,
    edit: Boolean
  },
  // すまーとじゃない
  computed: {
    selectedChip(){
      return this.$store.getters['selectChip/selectedChip']
    }
  },
  methods:{
    fetchTracks(){
      this.$emit('fetchTracks')
    },
    fetchPhotos(){
      this.$emit('fetchPhotos')
    }
  }
}
</script>
