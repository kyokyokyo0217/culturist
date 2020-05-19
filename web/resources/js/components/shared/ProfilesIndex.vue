<template>
  <v-container>
    <v-row>
      <v-col
        v-for="(user, index) in users"
        :key="index"
        class="d-flex child-flex"
        :cols="cols"
      >
        <profile-card :item=user></profile-card>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
import ProfileCard from './ProfileCard.vue'
export default {
  components: {
    ProfileCard
  },
  props:{
    cols: Number,
    users: Array
  },
}
</script>
<style scoped>
</style>
