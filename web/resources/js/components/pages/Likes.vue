<template>
  <content-layout>
    <template v-slot:title>Likes</template>
    <template v-slot:content>
      <select-chip></select-chip>
      <div class="d-flex justify-center">
        <v-progress-circular v-if="loading" :size="70" :width="7" indeterminate class="mt-12"></v-progress-circular>
      </div>
      <works-index :cols="3" :pictures="pictures" :tracks="tracks"></works-index>
    </template>
  </content-layout>
</template>
<script>
import status from "@/constants.js";
import ContentLayout from "@components/core/ContentLayout.vue";
import WorksIndex from "@components/shared/WorksIndex.vue";
import SelectChip from "@components/shared/SelectChip.vue";
export default {
  components: {
    ContentLayout,
    WorksIndex,
    SelectChip,
  },
  data: function () {
    return {
      pictures: [],
      tracks: [],
      loading: false,
    };
  },
  computed: {
    selectedChip() {
      return this.$store.getters["selectChip/selectedChip"];
    },
  },
  methods: {
    async fetchPhotos() {
      this.loading = true;
      const response = await axios.get("/api/pictures/likes");

      if (response.status !== status.OK) {
        this.$store.commit("error/setCode", response.status);
        this.loading = false;
        return false;
      }

      this.pictures = response.data.data;
      this.loading = false;
    },
    async fetchTracks() {
      this.loading = true;
      const response = await axios.get("/api/tracks/likes");

      if (response.status !== status.OK) {
        this.$store.commit("error/setCode", response.status);
        this.loading = false;
        return false;
      }

      this.tracks = response.data.data;
      this.loading = false;
    },
  },
  watch: {
    selectedChip: {
      async handler() {
        if (this.selectedChip == "music") {
          await this.fetchTracks();
        } else if (this.selectedChip == "picture") {
          await this.fetchPhotos();
        }
      },
      immediate: true,
    },
  },
};
</script>
