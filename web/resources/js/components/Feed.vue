<template>
  <v-card tile flat width="100%" height="100%">
    <v-card-title class="font-weight-black display-2">
      <p class="blue--text text--darken-3">Your Feed</p>
      <v-spacer></v-spacer>
      <v-btn small rounded color="primary" dark class="mx-2" @click="getMusic">music</v-btn>
      <v-btn small rounded color="primary" dark class="mx-2">picture</v-btn>
      <v-btn small rounded color="primary" dark class="mx-2">video</v-btn>
    </v-card-title>

    <v-divider></v-divider>

    <v-card color="cyan lighten-5" height="100%">
      <v-container fluid>
        <v-row>
          <v-col
            v-for="n in 9"
            :key="n"
            class="d-flex child-flex"
            cols="4"
          >
            <v-card flat tile class="d-flex">
              <v-img
                :src="muscle_src"
              ></v-img>
            </v-card>
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
        muscle_src: '/img/muscle.png',
      }
    },
    methods:{
      getMusic(){
        console.log('get tracks using axios');
      }
    }
  }
</script>
