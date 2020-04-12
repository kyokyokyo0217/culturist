<template>
  <v-card tile flat width="100%" height="100%">
    <v-card-title class="font-weight-black display-2">
      <p class="blue--text text--darken-3">Your Feed</p>
      <v-spacer></v-spacer>
      <v-chip-group
        active-class="deep-purple accent-4 white--text"
        column
      >
        <v-chip>All</v-chip>
        <v-chip>Music</v-chip>
        <v-chip>Picture</v-chip>
      </v-chip-group>
    </v-card-title>
    <v-divider></v-divider>

    <v-card color="grey lighten-5" height="100%">
      <v-container fluid>
        <v-row>
          <v-col
            v-for="n in 9"
            :key="n"
            class="d-flex child-flex"
            cols="4"
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
