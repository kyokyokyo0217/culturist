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
        <!-- v-model? -->
        <v-chip-group
          mandatory
          v-model="selectedChip"
          active-class="black accent-4 white--text disable-events"
          class="d-flex justify-end"
        >
          <v-chip
           small
           value="music"
           @click="selectMusic"
          >
            Music
          </v-chip>
          <v-chip
            small
            value="picture"
            @click="selectPicture"
          >
            Picture
          </v-chip>
        </v-chip-group>
      </v-col>
    </v-row>
<!-- 論理的にはurlから真偽値を得たい -->
    <template v-if="showTabsControl" v-slot:extension>
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
        selectedChip: 'music',
        activeTab: 0,
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
        this.selectedChip = 'music'
        if(this.$route.path === '/trending'){
          this.showTabsControl = true;
        }else{
          this.showTabsControl = false;
        }

      }
    },
    methods: {
      selectMusic(){
        this.$eventHub.$emit('selectMusic')
      },
      selectPicture(){
        this.$eventHub.$emit('selectPicture')
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
</style>
