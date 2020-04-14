<template>
    <v-navigation-drawer app permanent :width="200">
      <v-card to="/feed" flat>
        <v-img :src="logo_src"></v-img>
      </v-card>

      <v-divider></v-divider>

      <v-list-item to="/user">
        <v-list-item-avatar color="orange" size="48">
          <v-img :src="avator_src"></v-img>
        </v-list-item-avatar>
        <v-list-item-content class="text-center">
          <v-list-item-title class="title">
            Name
          </v-list-item-title>
          <v-list-item-subtitle>
            @handlename
          </v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>

      <v-divider></v-divider>

      <v-list dense flat class="px-0">
        <v-list-item-group active-class="border" color="primary">
          <v-list-item
            v-for="(item, i) in items"
            :key="i"
            :to="item.path"
          >
            <v-list-item-content>
              <v-list-item-title >{{ item.title }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-item-group>
      </v-list>

      <v-divider></v-divider>

      <v-col class="text-center">
        <v-btn
          to="/upload"
          color="primary"
        >
          <v-icon class="mr-2">mdi-cloud-upload</v-icon>
          Upload
        </v-btn>
      </v-col>
    </v-navigation-drawer>
</template>

<script>
  export default {
    data () {
      return {
        items: [
          { title: 'Feed', path: '/feed'},
          { title: 'Trending', path: '/trending'},
          { title: 'likes', path: '/likes'},
          { title: 'History', path: '/history'}
        ],
        logo_src: '/img/logo.png',
        avator_src: '/img/avator.png',
        right: null,
      }
    },
  }
</script>

<style scoped>
  .border{
    border-left: 8px solid #1565C0;
    /* blue darken-3 */
  }
</style>
