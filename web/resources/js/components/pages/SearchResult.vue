<template>
  <content-layout>
    <template v-slot:title>
      Showing Results for "{{ $route.query.result }}"
    </template>
    <template v-slot:content>
      <v-subheader>Users</v-subheader>
      <v-divider></v-divider>
      <p v-if="noUser">Seems Like Your Search Did Not Match Any Users ...</p>
      <profiles-index :cols="3" :users=users></profiles-index>
      <v-subheader>Works</v-subheader>
      <select-chip></select-chip>
      <v-divider></v-divider>
      <p v-if="noPicture && selectedChip === 'picture'">Seems Like Your Search Did Not Match Any Pictures ...</p>
      <p v-if="noTrack && selectedChip === 'music'">Seems Like Your Search Did Not Match Any Tracks ...</p>
      <works-index :cols="4" :pictures=pictures :tracks=tracks></works-index>
    </template>
  </content-layout>
</template>
<script>
import { OK } from '../../util'
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
      tracks: [],
      noUser: false,
      noPicture: false,
      noTrack: false
    }
  },
  computed: {
    selectedChip(){
      return this.$store.getters['selectChip/selectedChip']
    }
  },
  watch: {
    $route: {
      async handler () {
        this.$store.commit('selectChip/selectChip', 'music')
        this.noUser = false
        this.noTrack =  false
        this.noPicture = false
        const response = await axios.post('/api/search', {keyword: this.$route.query.result})

        if (response.status !== OK) {
          this.$store.commit('error/setCode', response.status)
          return false
        }
        // 無駄が多い気がする
        this.users = response.data.users
        if(this.users.length === 0){
          this.noUser = true
        }
        this.pictures = response.data.pictures
        if(this.pictures.length === 0){
          this.noPicture = true
        }
        this.tracks = response.data.tracks
        if(this.tracks.length === 0){
          this.noTrack = true
        }
      },
      immediate: true
    },
  }
}
</script>
