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

              <v-card>
                <v-card-title>
                  <span>Add Image</span>
                  <v-spacer></v-spacer>
                  <v-btn icon x-small @click="backgroundMenu = !backgroundMenu">
                    <v-icon>mdi-close-thick</v-icon>
                  </v-btn>
                </v-card-title>

                <v-file-input @change="onCoverPhotoFileChange"></v-file-input>
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

                  <v-card>
                    <v-card-title>
                      <span>Add Image</span>
                      <v-spacer></v-spacer>
                      <v-btn icon x-small @click="avatarMenu = !avatarMenu">
                        <v-icon>mdi-close-thick</v-icon>
                      </v-btn>
                    </v-card-title>

                    <v-file-input @change="onProfilePictureFileChange"></v-file-input>
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
                <v-btn v-if="edit" color="black" outlined @click="saveChange">
                  Save Changes
                </v-btn>
                <v-btn  v-else color="black" outlined @click="edit =! edit">
                  Edit Page
                </v-btn>
              </template>
              <template v-else>
                <v-btn v-if="!user.followed_by_user" color="black" outlined @click="followUser">
                  Follow
                </v-btn>
                <v-btn  v-else color="black" outlined @click="unfollowUser">
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
                <v-textarea
                  outlined
                  rows="5"
                  row-height="15"
                  background-color="white"
                  placeholder="About You"
                  v-model="bio"
                ></v-textarea>
                <!-- enterでイベント走っちゃう -->
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
              <p>joined Feburary 2020</p>
            </v-card-text>

          </v-col>
          <v-col cols="8">
            <select-chip></select-chip>
            <works-index :cols="6" :tracks="user.tracks"></works-index>
          </v-col>
        </v-row>
      </v-container>

    </v-card>

  </v-card>
</v-form>
</template>
<script>
  import ImageUploadCard from '../shared/ImageUploadCard.vue'
  import WorksIndex from '../shared/WorksIndex.vue'
  import SelectChip from '../shared/SelectChip.vue'
  export default {
    components:{
      ImageUploadCard,
      WorksIndex,
      SelectChip
    },
    props:{
      cols: Number
    },
    data(){
      return{
        background_src: '/img/background.jpg',
        avatar_src: '/img/avator.png',
        muscle_src: '/img/muscle.png',
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
        coverPhotoSrc: '/img/background.jpg'
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

        if (event.length === 0) {
          return false
        }

        const imageReader = new FileReader()

        imageReader.onload = e => {
          this.coverPhotoPreview = e.target.result
        }

        imageReader.readAsDataURL(event)

        this.coverPhotoFile = event
      },
      onProfilePictureFileChange (event) {

        if (event.length === 0) {
          return false
        }

        const imageReader = new FileReader()

        imageReader.onload = e => {
          this.profilePicturePreview = e.target.result
        }

        imageReader.readAsDataURL(event)

        this.profilePictureFile = event
      },


      // reset () {
      //   this.preview = ''
      //   this.file = null
      //   this.$el.querySelector('input[type="file"]').value = null
      // },

      async saveChange(){
        const formData = new FormData()
        formData.append('profile_picture', this.profilePictureFile)
        formData.append('cover_photo', this.coverPhotoFile)
        formData.append('bio', this.bio)
        formData.append('location', this.location)
// バグ putではfileを送れないためpost, headderでputに書き換え
        const response = await axios.post(`/api/users/${this.$route.params.username}`, formData, {
          headers: {
            'X-HTTP-Method-Override': 'PUT'
          }
        })
        this.edit =! this.edit;
        this.fetchUser();
      },
      async fetchUser(){
        // route直す
        const response = await axios.get(`/api/users/${this.$route.params.username}`)

        this.user = response.data

        this.getImageUrl()
      },
      async followUser(){
        const response = await axios.post(`/api/${this.$route.params.username}/follow`)
        this.user.followed_by_user = true
        console.log('success!')
      },
      async unfollowUser(){
        const response = await axios.delete(`/api/${this.$route.params.username}/follow`)
        this.user.followed_by_user = false
        console.log('success!')
      }
    },
    watch: {
      $route: {
        async handler () {
          await this.fetchUser()
        },
        immediate: true
      }
    },
  }
</script>
<style scoped>
  .profile-nm{
    position: relative;
    top: -100px;
  }
</style>
