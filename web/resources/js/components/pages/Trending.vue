<template>
  <content-layout>
    <template v-slot:title>Trending</template>
    <template v-slot:content>
      <works-index :cols="4"></works-index>
    </template>
  </content-layout>
</template>
<script>
import ContentLayout from "@components/core/ContentLayout.vue";
import WorksIndex from "@components/shared/WorksIndex.vue";
export default {
  components: {
    ContentLayout,
    WorksIndex,
  },
};
</script>
