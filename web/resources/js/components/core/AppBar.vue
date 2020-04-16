<template>
  <!-- できればぼかしたい -->
  <v-app-bar
    app
    fixed
    elevation="1"
    color="white"
  >
    <v-row>
      <v-col cols="2">
        <search-box></search-box>
      </v-col>
      <v-spacer></v-spacer>
      <v-col cols="2">
        <v-chip-group
          active-class="deep-purple accent-4 white--text"
          class="d-flex justify-end"
        >
          <v-chip small>All</v-chip>
          <v-chip small>Music</v-chip>
          <v-chip small>Picture</v-chip>
        </v-chip-group>
      </v-col>
    </v-row>
<!-- 論理的にはurlから真偽値を得たい -->
    <template v-if="showTabsControl" v-slot:extension>
      <v-tabs
        color="black"
      >
        <v-tab
          v-for="(tab, index) in tabsTitles.trending"
          :key="index"
        >
          {{ tab }}
        </v-tab>
      </v-tabs>
    </template>
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
        showTabsControl: false,
        tabsTitles: {
          trending: [
            'THIS WEEK', 'THIS MONTH', 'ALL TIME'
          ]
        }
      }
    },
    watch: {
      // tab使うページが増えたら困る
      '$route'(to, from) {
        if(this.$route.path === '/trending'){
          this.showTabsControl = true;
        }else{
          this.showTabsControl = false;
        }
      }
    }
  }
</script>
<style scoped>
  .v-toolbar__content{
    padding: 0px;
  }
</style>
