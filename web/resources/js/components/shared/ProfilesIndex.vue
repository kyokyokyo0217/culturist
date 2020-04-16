<template>
  <v-container>
    <v-row>
      <v-col
        v-for="(user, index) in users"
        :key="index"
        class="d-flex child-flex"
        :cols="cols"
      >
        <v-card class="ma-4" flat>
          <!-- v-card直下にv-avatar置くとradiusが消える -->
              <v-avatar color="orange" size="124" >
                <v-img :src="user.src"></v-img>
              </v-avatar>
         <!-- <v-card-title>
           {{user.name}}
         </v-card-title> -->
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
export default {
  props:{
    cols: Number
  },
  data(){
    return{
      // users: [
      //   {src: '/img/muscle.png'},
      //   {src: '/img/avator.png'},
      //   {src: '/img/background.jpg'}
      // ]
      users:[
          {name: 'muscle',src: '/img/muscle.png'},
          {name: 'avatar', src: '/img/avator.png'},
          {name: 'back', src: '/img/background.jpg'}
      ]
    }
  },
}
</script>
<style scoped>
</style>
