<template>
  <content-layout>
    <template v-slot:content>
      <v-container class="container-width">
        <v-subheader>Users</v-subheader>
        <v-divider></v-divider>
        <user-profiles :cols="3"></user-profiles>
        <v-subheader>Works</v-subheader>
        <v-divider></v-divider>
      </v-container>
    </template>
  </content-layout>
</template>
<script>
import ContentLayout from '../core/ContentLayout.vue'
import UserProfiles from '../shared/UserProfiles.vue'
export default {
  components: {
    ContentLayout,
    UserProfiles
  }
}
</script>
<style scoped>
  .container-width{
    width: 70%;
  }
</style>
