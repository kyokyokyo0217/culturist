<template>
  <v-sheet tile color="grey lighten-5" height="100%">
    <v-container class="container-width">
      <v-container class="pt-12">
        <p class="display-2 font-weight-black">
          <slot name="title"></slot>
        </p>
      </v-container>
      <!-- v-slot推奨 -->
      <slot name="content"></slot>
    </v-container>
  </v-sheet>
</template>
<script>
</script>
<style scoped>
  .container-width{
    width: 80%;
  }
</style>
