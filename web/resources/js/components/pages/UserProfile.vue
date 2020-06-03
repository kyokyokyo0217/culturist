<template>
  <v-form>
  <v-card tile flat width="100%" height="100%">
    <v-img
      :src="getCoverPhotoUrl()"
      max-height="400px"
      :gradient="edit ? 'to bottom, rgba(0,0,0,0), rgba(100,100,100,25)' : undefined"
    >
      <v-container fluid class="fill-height" v-if="edit">
        <v-row>
          <!-- align-selfが効いてない -->
          <v-col cols="12" class="text-center" align-self="end">
            <!-- close-on~~ :付けないと動かない-->
            <v-menu
              v-model="backgroundMenu"
              :close-on-click="false"
              :close-on-content-click="false"
              :nudge-width="200"
              offset-y
            >
              <template v-slot:activator="{ on }">
                <v-btn
                  v-on="on"
                >
                  <v-icon class="mr-2">mdi-camera</v-icon>
                  Change Cover Photo
                </v-btn>
              </template>

              <!-- <image-upload-card :menu="backgroundMenu" @closeMenu="backgroundMenu= false"></image-upload-card> -->

              <v-card class="pa-4">
                <v-card-title>
                  <span>Add Image</span>
                  <v-spacer></v-spacer>
                  <v-btn icon x-small @click="backgroundMenu = !backgroundMenu">
                    <v-icon>mdi-close-thick</v-icon>
                  </v-btn>
                </v-card-title>
                <validation-errors-alert v-if="errors" :errors=errors.cover_photo></validation-errors-alert>
                <v-file-input id="cover" @change="onCoverPhotoFileChange"></v-file-input>
              </v-card>


            </v-menu>
          </v-col>
        </v-row>
      </v-container>
    </v-img>

    <v-card color="grey lighten-5" height="100%">

      <v-container class="profile-nm px-12">
        <v-row>
          <v-col class="text-right">
            <v-list-item-avatar size="200" color="white">
              <v-img :src="getProfilePictureUrl()">
                <v-menu
                  v-if="edit"
                  v-model="avatarMenu"
                  :close-on-click="false"
                  :close-on-content-click="false"
                  nudge-width="200"
                  offset-y
                >
                  <template v-slot:activator="{ on }">
                    <v-btn
                      v-on="on"
                      class="ma-auto"
                    >
                      <v-icon class="mr-2">mdi-camera</v-icon>
                      Change
                    </v-btn>
                  </template>
                  <!-- <image-upload-card :menu="avatarMenu" @closeMenu="avatarMenu= false"></image-upload-card> -->

                  <v-card class="pa-4">
                    <v-card-title>
                      <span>Add Image</span>
                      <v-spacer></v-spacer>
                      <v-btn icon x-small @click="avatarMenu = !avatarMenu">
                        <v-icon>mdi-close-thick</v-icon>
                      </v-btn>
                    </v-card-title>
                    <validation-errors-alert v-if="errors" :errors=errors.profile_picture></validation-errors-alert>
                    <v-file-input id="profile" @change="onProfilePictureFileChange"></v-file-input>
                  </v-card>



                </v-menu>
              </v-img>
            </v-list-item-avatar>
          </v-col>
          <v-col align-self="end" class="mb-6">
            <v-list-item-content>
              <v-list-item-title class="display-2">
                  {{ user.name }}
              </v-list-item-title>
              <v-list-item-subtitle class="headline">
                  @{{ user.user_name }}
              </v-list-item-subtitle>
            </v-list-item-content>
          </v-col>
          <v-col align-self="end" class="mb-12 text-center">
            <template v-if="isLogin">
              <template v-if="isAuthenticatedUser">
                <template v-if="edit">
                  <v-btn color="black" outlined @click="saveChange" :loading="loading">
                    Save Changes
                  </v-btn>
                </template>
                <v-btn  v-else color="black" outlined @click="edit =! edit">
                  Edit Page
                </v-btn>
              </template>
              <template v-else>
                <v-btn v-if="!user.followed_by_user" color="black" outlined @click="followUser">
                  Follow
                </v-btn>
                <v-btn  v-else color="black" class="white--text" flat @click="unfollowUser">
                  Following
                </v-btn>
              </template>
            </template>
          </v-col>
        </v-row>
      </v-container>

      <v-container fluid class="profile-nm px-12">
        <v-row>
          <v-col cols="4" class="pa-8">
            <v-card v-if="edit" class="pa-8" flat>
              <v-form>
                <validation-errors-alert v-if="errors" :errors=errors.bio></validation-errors-alert>
                <!-- default value が効かない -->
                <v-textarea
                  outlined
                  rows="5"
                  row-height="15"
                  background-color="white"
                  placeholder="About You"
                  v-model="bio"
                ></v-textarea>
                <!-- enterでイベント走っちゃう -->
                <validation-errors-alert v-if="errors" :errors=errors.location></validation-errors-alert>
                <v-text-field
                  outlined
                  background-color="white"
                  placeholder="Location"
                  v-model="location"
                ></v-text-field>
              </v-form>
            </v-card>

            <v-card-text v-else>
              <p>
                {{ user.bio }}
              </p>
              <p>{{ user.location }}</p>
            </v-card-text>

          </v-col>
          <v-col cols="8">
            <select-chip></select-chip>
            <div class="d-flex justify-center">
              <v-progress-circular
                v-if="loadingWorks"
                :size="70"
                :width="7"
                indeterminate
                class="mt-12"
              ></v-progress-circular>
            </div>
            <works-index :cols="4" :tracks=tracks :pictures=pictures></works-index>
          </v-col>
        </v-row>
      </v-container>

    </v-card>

  </v-card>
</v-form>
</template>
<script>
import { OK, CREATED,  NO_CONTENT, UNPROCESSABLE_ENTITY} from '../../util'
import ValidationErrorsAlert from '../shared/ValidationErrorsAlert.vue'
import ImageUploadCard from '../shared/ImageUploadCard.vue'
import WorksIndex from '../shared/WorksIndex.vue'
import SelectChip from '../shared/SelectChip.vue'
export default {
  components:{
    ImageUploadCard,
    WorksIndex,
    SelectChip,
    ValidationErrorsAlert
  },
  data(){
    return{
      background_src: '/img/background.jpg',
      avatar_src: '/img/avator.png',
      edit: false,
      avatarMenu: false,
      backgroundMenu: false,
      user: null,
      coverPhotoPreview: null,
      profilePicturePreview: null,
      coverPhotoFile: null,
      profilePictureFile: null,
      bio: '',
      location: '',
      pictures: [],
      tracks: [],
      errors: null,
      loading: false,
      loadingWorks: false
    }
  },
  computed: {
    isLogin(){
      return this.$store.getters['auth/check']
    },
    // 名前微妙
    isAuthenticatedUser(){
      return this.$store.getters['auth/username'] == this.user.user_name
    },
    selectedChip(){
      return this.$store.getters['selectChip/selectedChip']
    }
  },
  methods: {
    getCoverPhotoUrl(){
       if(this.coverPhotoPreview){
         return this.coverPhotoPreview
       }else if(this.user.cover_photo != null){
         return this.user.cover_photo.url
       }else{
         return this.background_src
       }
     },

     getProfilePictureUrl(){
        if(this.profilePicturePreview){
          return this.profilePicturePreview
        }else if(this.user.profile_picture != null){
          return this.user.profile_picture.url
        }else{
          return this.avatar_src
        }
      },

    onCoverPhotoFileChange (event) {

      if (!event) {
        this.coverPhotoFileReset()
        return false
      }

      const coverPhotoReader = new FileReader()

      coverPhotoReader.onload = e => {
        this.coverPhotoPreview = e.target.result
      }

      coverPhotoReader.readAsDataURL(event)

      this.coverPhotoFile = event
    },

    onProfilePictureFileChange (event) {

      if (!event) {
        this.profilePictureFileReset()
        return false
      }

      const profilePictureReader = new FileReader()

      profilePictureReader.onload = e => {
        this.profilePicturePreview = e.target.result
      }

      profilePictureReader.readAsDataURL(event)

      this.profilePictureFile = event
    },

    coverPhotoFileReset () {
      this.coverPhotoPreview = ''
      this.coverPhotoFile = null
      // Error: Cannot set property 'value' of null 原因不明 /uploadは問題なく動く
      // this.$el.querySelector('#cover').value = null
    },

    profilePictureFileReset () {
      this.profilePicturePreview = ''
      this.profilePictureFile = null
      // this.$el.querySelector('#profile').value = null
    },

    async saveChange(){
      this.loading = true
      const formData = new FormData()
      //  laravel側のvalidationでnullableを通すため ='null' ではなく =null にする
      if(this.profilePictureFile){
        formData.append('profile_picture', this.profilePictureFile)
      }
      if(this.coverPhotoFile){
        formData.append('cover_photo', this.coverPhotoFile)
      }
      formData.append('bio', this.bio)
      formData.append('location', this.location)
// バグ putではfileを送れないためpost, headderでputに書き換え
      const response = await axios.post(`/api/users/${this.$route.params.username}`, formData, {
        headers: {
          'X-HTTP-Method-Override': 'PUT'
        }
      })

      if (response.status === UNPROCESSABLE_ENTITY) {
        this.errors = response.data.errors
        this.loading = false
        return false
      }

      this.coverPhotoFileReset()
      this.profilePictureFileReset()
      this.avatarMenu = false
      this.backgroundMenu= false
      this.edit =! this.edit

      if (response.status !== NO_CONTENT) {
        this.$store.commit('error/setCode', response.status)
        return false
      }

      this.loading = false
// navigationdrawerのプロフ画再取得したい
      this.fetchUser()
    },

    async fetchUser(){
      const response = await axios.get(`/api/users/${this.$route.params.username}`)

      if (response.status !== OK) {
        this.$store.commit('error/setCode', response.status)
        return false
      }

      this.user = response.data
    },

    async fetchPhotos () {
      this.loadingWorks = true
      const response = await axios.get(`/api/pictures/user/${this.$route.params.username}`)

      if (response.status !== OK) {
        this.$store.commit('error/setCode', response.status)
        this.loadingWorks = false
        return false
      }

      this.pictures = response.data.data
      this.loadingWorks = false
    },

    async fetchTracks () {
      this.loadingWorks = true
      const response = await axios.get(`/api/tracks/user/${this.$route.params.username}`)

      if (response.status !== OK) {
        this.$store.commit('error/setCode', response.status)
        this.loadingWorks = false
        return false
      }

      this.tracks = response.data.data
      this.loadingWorks = false
    },

    async followUser(){
      const response = await axios.post(`/api/${this.$route.params.username}/follow`)

      if (response.status !== CREATED) {
        this.$store.commit('error/setCode', response.status)
        return false
      }

      this.user.followed_by_user = true
    },

    async unfollowUser(){
      const response = await axios.delete(`/api/${this.$route.params.username}/follow`)

      if (response.status !== NO_CONTENT) {
        this.$store.commit('error/setCode', response.status)
        return false
      }

      this.user.followed_by_user = false
    },
  },

  mounted(){
      this.$store.commit('selectChip/selectChip', 'music')
  },

  watch: {
    $route: {
      async handler () {
        await this.fetchUser()
      },
      immediate: true
    },

    selectedChip: {
      async handler () {
        if(this.selectedChip ==  "music"){
          await this.fetchTracks()
        }else if (this.selectedChip ==  "picture") {
          await this.fetchPhotos()
        }
      },
      immediate: true
    }
  }
}
</script>
<style scoped>
  .profile-nm{
    position: relative;
    top: -100px;
  }
</style>
