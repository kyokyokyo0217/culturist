<template>
  <v-card tile outlined>
    <v-hover v-slot:default="{ hover }">
      <v-img @click="overlay = true" :src="item.url" aspect-ratio="1" class="picture-card">
        <div v-if="edit" class="fill-height ma-0 text-right">
          <v-btn
            @click.stop="dialog = true"
            fab
            small
            style="opacity: 0"
            color="white"
            :class="{'show-btn': hover }"
          >
            <v-icon style="opacity: 0" color="black" :class="{'show-btn': hover }">mdi-delete</v-icon>
          </v-btn>
          <v-dialog v-model="dialog" max-width="290">
            <v-card>
              <v-card-title>Are You Sure ?</v-card-title>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn text @click="dialog = false">Cancel</v-btn>
                <v-btn color="red" outlined @click="deletePicture" :loading="loading">Delete</v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </div>
      </v-img>
    </v-hover>

    <picture-detail-card v-if="overlay" @close-detail="overlay = false" :item="item"></picture-detail-card>
  </v-card>
</template>
<script>
import status from "@/constants.js";
import PictureDetailCard from "@components/shared/PictureDetailCard.vue";
export default {
  components: {
    PictureDetailCard,
  },
  props: {
    item: {
      type: Object,
      required: true,
    },
    edit: {
      type: Boolean,
      required: true,
    },
  },
  data() {
    return {
      overlay: false,
      liked: false,
      dialog: false,
      loading: false,
    };
  },
  methods: {
    async deletePicture() {
      this.loading = true;
      const response = await axios.delete(`/api/pictures/${this.item.id}`);

      if (response.status !== stats.NO_CONTENT) {
        this.$store.commit("error/setCode", response.status);
        return false;
      }

      this.dialog = false;
      this.loading = false;

      this.$emit("fetch-photos");

      // this.$router.replace({path: this.$router.currentRoute.path}).catch(err => {})
    },
  },
};
</script>
<style scoped>
.picture-card:hover {
  cursor: zoom-in;
}
</style>
