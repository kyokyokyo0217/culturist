<template>
  <content-layout>
    <template v-slot:title>
      Feed
    </template>
    <template v-slot:content>
      <works-index :cols="3"></works-index>
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
