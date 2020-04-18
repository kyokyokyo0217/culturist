<template>
  <v-text-field
    label="Search"
    prepend-inner-icon="mdi-magnify"
    solo
    dense
    hide-details
    height="4"
    class="compact-form"
    v-on:keyup.enter="search"
    v-model="text"
  ></v-text-field>
</template>
<script>
  export default{
    data(){
      return{
        text: '',
      }
    },
    methods: {
      search() {
        console.log('search words');
        this.$router.push({ path: '/search', query: {result: this.text} })
      }
    }
  }
</script>
<style scoped>
  .v-input{
    flex: 0 0 auto;
  }
  .compact-form {
    -webkit-transform: scale(0.75);
    -webkit-transform-origin: left;
  }
</style>
