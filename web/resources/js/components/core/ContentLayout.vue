<template>
  <v-sheet tile color="grey lighten-5" height="100%">
    <v-container width="80%">
      <v-container class="pt-12">
        <p class="display-2 font-weight-black">
          <slot name="title"></slot>
        </p>
      </v-container>
      <slot name="content"></slot>
    </v-container>
  </v-sheet>
</template>
<script>
</script>
