<template>
  <v-card tile flat width="100%" height="100%">
    <v-text-field
      label="Search"
      prepend-inner-icon="mdi-magnify"
      solo
      dense
      hide-details
      height="20px"
      class="mt-4 ml-12 mb-4"
    ></v-text-field>
    <v-card-title class="font-weight-black display-2">
      <p class="blue--text text--darken-3">
        <slot name="title"></slot>
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
    </v-card-title>
    <v-divider></v-divider>

    <v-card color="grey lighten-5" height="100%">
      <slot name="content"></slot>
    </v-card>
  </v-card>
</template>
<script>
</script>
<style scoped>
  .v-text-field{
    width: 200px;
  }
</style>
