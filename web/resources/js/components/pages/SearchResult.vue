<template>
  <content-layout>
    <template v-slot:content>
      <v-subheader>Users</v-subheader>
      <v-divider></v-divider>
      <profiles-index :cols="3"></profiles-index>
      <v-subheader>Works</v-subheader>
      <v-divider></v-divider>
      <works-index :cols="4"></works-index>
    </template>
  </content-layout>
</template>
<script>
  import ContentLayout from '../core/ContentLayout.vue'
  import ProfilesIndex from '../shared/ProfilesIndex.vue'
  import WorksIndex from '../shared/WorksIndex.vue'
  export default {
    components: {
      ContentLayout,
      ProfilesIndex,
      WorksIndex
    }
  }
</script>
