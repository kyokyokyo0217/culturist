<template>
  <!-- できればぼかしたい -->
  <v-app-bar
    app
    prominent
    fixed
    flat
    color="white"
  >
    <search-box></search-box>
      <p class="blue--text text--darken-3 font-weight-black display-2">
        Feed
      </p>
      <v-spacer></v-spacer>
      <v-chip-group
        active-class="deep-purple accent-4 white--text"
        column
      >
        <v-chip>All</v-chip>
        <v-chip>Music</v-chip>
        <v-chip>Picture</v-chip>
      </v-chip-group>
  </v-app-bar>
</template>
<script>
  import SearchBox from '../shared/SearchBox.vue'
  export default{
    components: {
      SearchBox
    }
  }
</script>
