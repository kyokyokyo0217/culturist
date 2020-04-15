<template>
  <v-container fluid>
    <v-row>
      <v-col
        v-for="(work, index) in works"
        :key="index"
        class="d-flex child-flex"
        :cols="cols"
      >
        <v-card class="d-flex ma-4" flat>
          <v-img
            :src="work.src"
            aspect-ratio="1"
            contain
          ></v-img>
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
      works: [
        {src: '/img/muscle.png'},
        {src: '/img/avator.png'},
        {src: '/img/background.jpg'}
      ]
    }
  },
}
</script>
