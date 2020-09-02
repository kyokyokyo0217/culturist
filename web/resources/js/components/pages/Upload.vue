<template>
  <content-layout>
    <template v-slot:title>Upload</template>

    <template v-slot:content>
      <v-card tile outlined class="px-8 py-4">
        <v-tabs v-model="tab" background-color="transparent" color="black">
          <v-tab>Picture</v-tab>
          <v-tab>Track</v-tab>
        </v-tabs>

        <v-tabs-items v-model="tab">
          <v-tab-item>
            <upload-picture-tab></upload-picture-tab>
          </v-tab-item>
          <v-tab-item>
            <upload-track-tab></upload-track-tab>
          </v-tab-item>
        </v-tabs-items>
      </v-card>
    </template>
  </content-layout>
</template>
<script>
import ContentLayout from "@components/core/ContentLayout.vue";
import UploadPictureTab from "@components/shared/UploadPictureTab.vue";
import UploadTrackTab from "@components/shared/UploadTrackTab.vue";
export default {
  components: {
    ContentLayout,
    UploadPictureTab,
    UploadTrackTab,
  },
  data() {
    return {
      tab: 0,
    };
  },
};
</script>
