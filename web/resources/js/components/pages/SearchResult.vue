<template>
  <content-layout>
    <template v-slot:title>
      Showing Results for "{{ $route.query.result }}"
    </template>
    <template v-slot:content>
      <v-subheader>Users</v-subheader>
      <v-divider></v-divider>
      <profiles-index :cols="3" :users=users></profiles-index>
      <v-subheader>Works</v-subheader>
      <select-chip></select-chip>
      <v-divider></v-divider>
      <works-index :cols="4" :pictures=pictures :tracks=tracks></works-index>
    </template>
  </content-layout>
</template>
<script>
  import ContentLayout from '../core/ContentLayout.vue'
  import ProfilesIndex from '../shared/ProfilesIndex.vue'
  import WorksIndex from '../shared/WorksIndex.vue'
  import SelectChip from '../shared/SelectChip.vue'
  export default {
    components: {
      ContentLayout,
      ProfilesIndex,
      WorksIndex,
      SelectChip
    },
    data(){
      return{
        users: [],
        pictures: [],
        tracks: []
      }
    },
    watch: {
      $route: {
        async handler () {
          this.$store.commit('selectChip/selectChip', 'music')
          const response = await axios.post('/api/search', {keyword: this.$route.query.result});
          this.users = response.data.users
          this.pictures = response.data.pictures
          this.tracks = response.data.tracks
        },
        immediate: true
      },
    }
  }
</script>
