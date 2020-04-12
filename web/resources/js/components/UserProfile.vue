<template>
  <v-card tile flat width="100%" height="100%">
    <v-img :src="background_src" max-height="400px"></v-img>
    
    <v-card color="indigo lighten-5" height="100%">
      <v-container class="profile-nm px-12">
        <v-row>
          <v-col class="text-right">
            <v-list-item-avatar size="200" color="orange">
              <v-img :src="avator_src"></v-img>
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
            <v-btn color="primary">
              Follow
            </v-btn>
          </v-col>
        </v-row>
      </v-container>

      <v-container fluid class="profile-nm px-12">
        <v-row>
          <v-col cols="4">
            <v-card-text>
              <p>
                It can contain an avatar, content, actions, subheaders and much more. Lists present content in a way that makes it easy to identify a specific item in a collection. They provide a consistent styling for organizing groups of text and images.
              </p>
              <p>location</p>
              <p>joined Feburary 2020</p>
            </v-card-text>
          </v-col>
          <v-col cols="8">
            <v-container fluid>
              <v-row>
                <v-col
                  v-for="n in 12"
                  :key="n"
                  class="d-flex child-flex"
                  cols="6"
                >
                  <v-card class="d-flex ma-4">
                    <v-img
                      :src="muscle_src"
                      aspect-ratio="1"
                      contain
                    ></v-img>
                  </v-card>
                </v-col>
              </v-row>
            </v-container>
          </v-col>
        </v-row>
      </v-container>
    </v-card>
  </v-card>
</template>
<script>
export default {
  data(){
    return{
      background_src: '/img/background.jpg',
      avator_src: '/img/avator.png',
      muscle_src: '/img/muscle.png'
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
