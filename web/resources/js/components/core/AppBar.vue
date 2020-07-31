<template>
  <!-- できればぼかしたい -->
  <v-app-bar
    app
    fixed
    elevation="1"
    color="white"
  >
    <search-box></search-box>
    <v-spacer></v-spacer>
    <v-btn v-if="isLogin" @click="logout" :loading="loading" small outlined class="ml-2 text-lowercase">
      logout
    </v-btn>
    <v-btn v-if="!isLogin && !isLoginPage" small outlined to="/login" class="ml-2 text-lowercase">
      login
    </v-btn>
  </v-app-bar>
</template>
<script>
  import SearchBox from '../shared/SearchBox.vue'
  export default{
    components: {
      SearchBox
    },
    data: function() {
      return {
        loading: false
      }
    },
    computed: {
      isLogin () {
        return this.$store.getters['auth/check']
      },
      isLoginPage (){
        return this.$route.path === "/login"
      }
    },
    methods: {
      async logout () {
        this.loading = true
        await this.$store.dispatch('auth/logout')
        this.loading = false
        // catchで "navigating to current location ( ) is not allowed" を無視する
        this.$router.push('/explore').catch(err => {})
      }
    }
  }
</script>
<style scoped>
  .v-toolbar__content{
    padding: 0px;
  }
  .v-slide-group__wrapper{
    flex-grow: 0 !important;
    flex-shrink: 0 !important;
  }
  /* .disable-events {
    pointer-events: none
  } */
</style>
