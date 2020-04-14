<template>
  <content-layout>
    <template v-slot:title>
      History
    </template>
    <template v-slot:content>
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
    </template>
  </content-layout>
</template>
<script>
  import ContentLayout from '../core/ContentLayout.vue'
  export default {
    components: {
      ContentLayout
    },
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
