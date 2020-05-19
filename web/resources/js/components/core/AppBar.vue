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
    <v-btn v-if="isLogin && !loading" small outlined @click="logout" class="ml-2">
      <!-- なぜか大文字になる -->
      L<span class="text-lowercase">ogout</span>
    </v-btn>
    <v-progress-circular
      v-if="loading"
      indeterminate
      color="grey"
      width="2"
      size="28"
    ></v-progress-circular>
    <v-btn v-if="!isLogin && !isLoginPage" small outlined to="/login" class="ml-2">
      Login
    </v-btn>

<!-- 論理的にはurlから真偽値を得たい -->
    <!-- <template v-if="showTabsControl" v-slot:extension>
      <v-tabs
        color="black"
        v-model="activeTab"
      >
        <v-tab
          v-for="(tab, index) in tabsTitles.trending"
          :key="index"
        >
          {{ tab }}
        </v-tab>
      </v-tabs>
    </template> -->
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
        // showTabsControl: false,
        // activeTab: 0,
        // tabsTitles: {
        //   trending: [
        //     'THIS WEEK', 'THIS MONTH', 'ALL TIME'
        //   ]
        // },
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
    // watch: {
    //   // tab使うページが増えたら困る
    //   '$route'(to, from) {
    //     if(this.$route.path === '/trending'){
    //       this.showTabsControl = true;
    //     }else{
    //       this.showTabsControl = false;
    //     }
    //   }
    // },
    methods: {
      async logout () {
        this.loading = true
        await this.$store.dispatch('auth/logout')
        this.loading = false
        // error: navigating to current location ( ) is not allowed
        this.$router.push('/explore').catch(err => {})
      }
    }
  }
</script>
<style scoped>
  .v-toolbar__content{
    padding: 0px;
  }
  .disable-events {
    pointer-events: none
  }
  .v-slide-group__wrapper{
    flex-grow: 0 !important;
    flex-shrink: 0 !important;
  }
</style>
