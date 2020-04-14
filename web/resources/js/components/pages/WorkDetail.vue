<template>
  <v-card tile class="mx-auto" width="70%" height="70%">
    <v-container fluid>
      <v-row>
        <v-col cols="6">
          <v-img
            :src="muscle_src"
            contain
          ></v-img>
        </v-col>
        <v-col cols="6">
          <v-card-title>Title</v-card-title>
          <v-card-subtitle>By Artist Name</v-card-subtitle>
          <v-card-teext>Description </v-card-teext>
        </v-col>
      </v-row>
    </v-container>
  </v-card>
</template>
<script>
  export default {
    data(){
      return{
        muscle_src: '/img/muscle.png',
      }
    },
  }
</script>
