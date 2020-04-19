<template>
  <v-card tile flat width="100%" height="100%">
    <v-img
      :src="background_src"
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
              <image-upload-card :menu="backgroundMenu" @closeMenu="backgroundMenu= false"></image-upload-card>
            </v-menu>
          </v-col>
        </v-row>
      </v-container>
    </v-img>

    <v-card color="grey lighten-5" height="100%">

      <v-container class="profile-nm px-12">
        <v-row>
          <v-col class="text-right">
            <v-list-item-avatar size="200" color="orange">
              <v-img :src="avator_src">
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
                  <image-upload-card :menu="avatarMenu" @closeMenu="avatarMenu= false"></image-upload-card>
                </v-menu>
              </v-img>
            </v-list-item-avatar>
          </v-col>
          <v-col align-self="end" class="mb-6">
            <v-list-item-content>
              <v-list-item-title class="display-2">
                Name namename
              </v-list-item-title>
              <v-list-item-subtitle class="headline">
                  @username
              </v-list-item-subtitle>
            </v-list-item-content>
          </v-col>
          <v-col align-self="end" class="mb-12 text-center">
            <v-btn v-if="auth && edit" color="black" outlined @click="saveChange">
              Save Changes
            </v-btn>
            <v-btn  v-else-if="auth" color="black" outlined @click="edit =! edit">
              Edit Page
            </v-btn>
            <v-btn v-else color="black" outlined>
              Follow
            </v-btn>
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
                ></v-textarea>
                <!-- enterでイベント走っちゃう -->
                <v-text-field
                  outlined
                  background-color="white"
                  placeholder="Location"
                ></v-text-field>
              </v-form>
            </v-card>

            <v-card-text v-else>
              <p>
                It can contain an avatar, content, actions, subheaders and much more. Lists present content in a way that makes it easy to identify a specific item in a collection. They provide a consistent styling for organizing groups of text and images.
              </p>
              <p>location</p>
              <p>joined Feburary 2020</p>
            </v-card-text>

          </v-col>
          <v-col cols="8">
            <works-index :cols="6"></works-index>
          </v-col>
        </v-row>
      </v-container>

    </v-card>

  </v-card>
</template>
<script>
  import ImageUploadCard from '../shared/ImageUploadCard.vue'
  import WorksIndex from '../shared/WorksIndex.vue'
  export default {
    components:{
      ImageUploadCard,
      WorksIndex
    },
    props:{
      cols: Number
    },
    data(){
      return{
        background_src: '/img/background.jpg',
        avator_src: '/img/avator.png',
        muscle_src: '/img/muscle.png',
        auth: true,
        edit: false,
        avatarMenu: false,
        backgroundMenu: false
      }
    },
    methods: {
      saveChange(){
        console.log('save change');
        this.edit =! this.edit;
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
