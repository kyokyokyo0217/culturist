<template>
  <content-layout>
    <template v-slot:title>
      Upload
    </template>

    <template v-slot:content>
      <v-card tile outlined class="px-8 py-4">
        <v-tabs
          v-model="tab"
          background-color="transparent"
          color="basil"
        >
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
  import ContentLayout from '../core/ContentLayout.vue'
  import UploadPictureTab from '../shared/UploadPictureTab.vue'
  import UploadTrackTab from '../shared/UploadTrackTab.vue'
  export default {
    components: {
      ContentLayout,
      UploadPictureTab,
      UploadTrackTab
    },
    data: function () {
      return {
        tab: 0,
      }
    },
  }
</script>
<style scoped>
 .container-height{
   height: 100%;
 }
</style>
