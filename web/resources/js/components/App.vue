<template>
  <v-app>
   <Navigation></Navigation>
    <v-content>
      <v-container
        class="fill-height pa-0"
        fluid
      >
        <RouterView />
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
  import Navigation from './Navigation.vue'
  export default {
    components: {
      Navigation
    }
  }
</script>
