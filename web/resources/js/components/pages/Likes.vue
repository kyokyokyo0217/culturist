<template>
  <content-layout>
    <template v-slot:title>
      Likes
    </template>
    <template v-slot:content>
      <works-index :cols="4"></works-index>
    </template>
  </content-layout>
</template>
<script>
  import ContentLayout from '../core/ContentLayout.vue'
  import WorksIndex from '../shared/WorksIndex.vue'
  export default {
    components: {
      ContentLayout,
      WorksIndex
    },
    methods:{
    }
  }
</script>
