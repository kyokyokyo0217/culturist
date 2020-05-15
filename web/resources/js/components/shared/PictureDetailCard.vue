<template>
  <!-- overlayはdefaultでdark-themeなので上書き -->
  <v-overlay
    :dark="false"
  >
    <v-card
      width="1200px"
      height="650px"
      class="mx-auto"
    >
      <v-list-item>
        <v-list-item-avatar color="white">
          <v-img :src="getProfilePictureUrl()"></v-img>
        </v-list-item-avatar>
        <v-list-item-content>
          <v-list-item-title class="headline">{{ item.title }}</v-list-item-title>
          <v-list-item-subtitle>
            by
            <router-link
              :to="{ name: 'user', params:{username: item.artist.user_name}}"
              class="user-link"
            >
              {{ item.artist.name }}
            </router-link>
          </v-list-item-subtitle>
        </v-list-item-content>
        <v-btn icon color="pink" @click="unlikePicture" v-if="item.liked_by_user">
          <v-icon>mdi-heart</v-icon>
        </v-btn>
        <v-btn icon color="pink" @click="likePicture" v-if="!item.liked_by_user">
          <v-icon>mdi-heart-outline</v-icon>
        </v-btn>
        <v-btn
          icon
          @click="closeDetail"
          color="black"
        >
          <v-icon>mdi-close</v-icon>
        </v-btn>
      </v-list-item>

      <v-row justify="center">
        <v-img
          :src="item.url"
          max-width="1000px"
          max-height="500px"
          contain
        >
        </v-img>
      </v-row>
    </v-card>
  </v-overlay>
</template>
<script>
import { CREATED, NO_CONTENT} from '../../util'
export default{
  props: {
    item: {
      type:Object,
      required: true,
    }
  },
  data(){
    return{
      overlay: false,
      avatar_src: '/img/avator.png',
    }
  },
  methods:{
    closeDetail(){
      this.$emit('closeDetail')
    },

    getProfilePictureUrl(){
      if(this.item.artist.profile_picture != null){
       return this.item.artist.profile_picture.url
      }else{
       return this.avatar_src
      }
     },

    async likePicture(){
      const response = await axios.post(`/api/picture/${this.item.id}/like`)

      if (response.status !== CREATED) {
        this.$store.commit('error/setCode', response.status)
        return false
      }

      this.item.liked_by_user = true
    },

    async unlikePicture(){
      const response = await axios.delete(`/api/picture/${this.item.id}/like`)

      if (response.status !== NO_CONTENT) {
        this.$store.commit('error/setCode', response.status)
        return false
      }

      this.item.liked_by_user = false
    },

  }
}
</script>
<style scoped>
  .user-link{
    text-decoration: none;
    color: grey;
  }
  .user-link:hover{
    color:black;
  }
</style>
