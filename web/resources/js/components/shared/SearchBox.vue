<template>
  <v-text-field
    label="Search"
    prepend-inner-icon="mdi-magnify"
    solo
    dense
    hide-details
    height="4"
    class="compact-form ml-4 mt-2"
  ></v-text-field>
</template>
<style scoped>
  .v-input{
    flex: 0 0 auto;
  }
  .compact-form {
    -webkit-transform: scale(0.75);
    -webkit-transform-origin: left;
  }
</style>
