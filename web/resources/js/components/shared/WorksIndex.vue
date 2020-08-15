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
        <track-card :item="track" :edit="edit" @fetchTracks="fetchTracks"></track-card>
      </v-col>
      <v-col
        v-if="selectedChip == 'picture'"
        v-for="(picture, index) in pictures"
        :key="index"
        class="d-flex child-flex"
        :cols="cols"
      >
        <picture-card :item="picture" :edit="edit" @fetchPhotos="fetchPhotos"></picture-card>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
import TrackCard from "@components/shared/TrackCard.vue";
import PictureCard from "@components/shared/PictureCard.vue";
export default {
  components: {
    TrackCard,
    PictureCard,
  },
  props: {
    cols: {
      type: Number,
      required: true,
    },
    edit: {
      type: Boolean,
      default: false,
    },
    pictures: {
      type: Array,
      required: true,
    },
    tracks: {
      type: Array,
      required: true,
    },
  },
  computed: {
    selectedChip() {
      return this.$store.getters["selectChip/selectedChip"];
    },
  },
  methods: {
    fetchTracks() {
      this.$emit("fetchTracks");
    },
    fetchPhotos() {
      this.$emit("fetchPhotos");
    },
  },
};
</script>
