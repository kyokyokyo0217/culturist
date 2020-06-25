<template>
  <v-card
    tile
    outlined
  >
    <v-hover v-slot:default="{ hover }">
    <v-img
      :src="item.artwork.url"
      aspect-ratio="1"
      contain
      :class="{'image-clickable': hover}"
      :gradient="hover ? 'to top, rgba(0, 0, 0, 0.4) 0%, transparent 180px' : undefined"
      @click="playTrack"
    >
      <v-row
        class="fill-height ma-0"
        align="center"
        justify="center"
      >
        <v-icon
          size="100"
          style="opacity: 0"
          color="white"
          :class="{'show-btn': hover }"
        >
          mdi-arrow-right-drop-circle
        </v-icon>
      </v-row>
    </v-img>
  </v-hover>
    <v-card-text class="py-0">
      <p class="ma-0 subtitle-1 black--text">{{ item.title }}</p>
      <span>by</span>
      <router-link
        :to="{ name: 'user', params:{username: item.artist.user_name}}"
        class="user-link"
      >
        {{ item.artist.user_name }}
      </router-link>
      <template v-if="isLogin">
        <v-btn v-if="item.liked_by_user" icon color="pink" @click="unlikeTrack">
          <v-icon>mdi-heart</v-icon>
        </v-btn>
        <v-btn v-if="!item.liked_by_user" icon color="pink" @click="likeTrack">
          <v-icon>mdi-heart-outline</v-icon>
        </v-btn>
        <v-btn v-if="edit" small color="red" outlined @click.stop="dialog = true">
          Delete
        </v-btn>
        <v-dialog
          v-model="dialog"
          max-width="290"
        >
          <v-card>
            <v-card-title>
              Are You Sure ?
            </v-card-title>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn
                text
                @click="dialog = false"
              >
                Cancel
              </v-btn>
              <v-btn
                color="red"
                outlined
                @click="deleteTrack"
                :loading = loading
              >
                Delete
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </template>
    </v-card-text>
  </v-card>
</template>
<script>
import { CREATED, NO_CONTENT} from '../../util'
export default{
  props: {
    item: {
       type:Object,
       required: true
     },
     edit: {
       type: Boolean,
     }
   },
   data (){
     return {
       dialog: false,
       loading: false
     }
   },
   computed:{
     isLogin () {
       return this.$store.getters['auth/check']
     },
   },
   methods:{
     playTrack(){
       this.$store.dispatch('track/nowPlaying', this.item)
     },

     async likeTrack(){
       const response = await axios.post(`/api/track/${this.item.id}/like`)

       if (response.status !== CREATED) {
         this.$store.commit('error/setCode', response.status)
         return false
       }

       this.item.liked_by_user = true
     },

     async unlikeTrack(){
       const response = await axios.delete(`/api/track/${this.item.id}/like`)

       if (response.status !== NO_CONTENT) {
         this.$store.commit('error/setCode', response.status)
         return false
       }

       this.item.liked_by_user = false
     },

     async deleteTrack(){
       this.loading = true
       const response = await axios.delete(`/api/tracks/${this.item.id}`)

       if (response.status !== NO_CONTENT) {
         this.$store.commit('error/setCode', response.status)
         return false
       }

       this.dialog = false
       this.loading = false

       this.$emit('fetchTracks')

       // this.$router.replace({path: this.$router.currentRoute.path}).catch(err => {})
     }
   }
}
</script>
<style scoped>
  .show-btn{
    opacity: 1 !important;
  }
  .image-clickable{
    cursor: pointer;
  }
  .user-link{
    text-decoration: none;
    color: grey;
  }
  .user-link:hover{
    color:black;
  }
</style>
