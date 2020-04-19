<template>
  <v-card>
    <v-card-title>
      <span>Add Image</span>
      <v-spacer></v-spacer>
      <v-btn icon x-small @click="closeMenu">
        <v-icon>mdi-close-thick</v-icon>
      </v-btn>
    </v-card-title>

    <v-file-input></v-file-input>
  </v-card>
</template>
<script>
  export default{
    props:{
      menu: Boolean
    },
    methods:{
      closeMenu(){
        this.$emit("closeMenu")
      }
    }
  }
</script>
