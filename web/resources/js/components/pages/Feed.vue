<template>
  <content-layout>
    <template v-slot:content>
      <works :cols="4"></works>
    </template>
  </content-layout>
</template>
<script>
  import ContentLayout from '../core/ContentLayout.vue'
  import Works from '../shared/Works.vue'
  export default {
    components: {
      ContentLayout,
      Works
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
