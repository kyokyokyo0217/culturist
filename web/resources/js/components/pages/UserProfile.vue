<template>
  <v-card tile flat width="100%" height="100%">
    <v-img
      :src="background_src"
      max-height="400px"
      :gradient="edit ? 'to bottom, rgba(0,0,0,0), rgba(100,100,100,25)' : undefined"
    >
      <v-container fluid class="fill-height">
        <v-row>
          <!-- align-selfが効いてない -->
          <v-col cols="12" class="text-center" align-self="end">
            <v-btn v-if="edit" @click="showPhotoUploader">
              <v-icon class="mr-2">mdi-camera</v-icon>
              Change Cover Photo
            </v-btn>
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

                <!-- <v-dialog v-model="dialog" persistent max-width="200px">
                  <template v-slot:activator="{ on }">
                    <v-btn v-if="edit" class="ma-auto" v-on="on">
                      <v-icon class="mr-2">mdi-camera</v-icon>
                      Change
                    </v-btn>
                  </template>
                  <v-card>
                    <v-card-title class="headline">Use Google's location service?</v-card-title>
                    <v-card-text>Let Google help apps determine location. This means sending anonymous location data to Google, even when no apps are running.</v-card-text>
                    <v-card-actions>
                      <v-spacer></v-spacer>
                      <v-btn color="green darken-1" text @click="dialog = false">Disagree</v-btn>
                      <v-btn color="green darken-1" text @click="dialog = false">Agree</v-btn>
                    </v-card-actions>
                  </v-card>
                </v-dialog> -->

                <v-btn v-if="edit" class="ma-auto">
                  <v-icon class="mr-2">mdi-camera</v-icon>
                  Change
                </v-btn>
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
            <v-btn v-if="auth && edit" color="primary" outlined @click="saveChange">
              Save Changes
            </v-btn>
            <v-btn  v-else-if="auth" color="primary" outlined @click="edit =! edit">
              Edit Page
            </v-btn>
            <v-btn v-else color="primary" outlined>
              Follow
            </v-btn>
          </v-col>
        </v-row>
      </v-container>

      <v-container fluid class="profile-nm px-12">
        <v-row>
          <v-col cols="4" class="pa-8">
            <v-card v-if="edit" class="pa-8" color="cyan lighten-4" flat>
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
            <works :cols="6"></works>
          </v-col>
        </v-row>
      </v-container>
    </v-card>
  </v-card>
</template>
<script>
  import Works from '../shared/Works.vue'
  export default {
    components:{
      Works
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
        dialog: false
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
