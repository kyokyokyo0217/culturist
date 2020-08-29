<template>
  <v-navigation-drawer app :width="200" style="z-index: 0">
    <v-card to="/feed" flat>
      <v-img :src="logo_src" width="200" height="60" alt="logo"></v-img>
    </v-card>

    <v-divider></v-divider>

    <v-list-item :to="{ name: 'user', params:{username: username}}" class="py-2" color="black">
      <v-list-item-avatar color="white" size="48">
        <v-img :src="profilePicture"></v-img>
      </v-list-item-avatar>
      <v-list-item-content class="text-center">
        <v-list-item-title class="title">{{ accountname }}</v-list-item-title>
        <v-list-item-subtitle>@{{ username }}</v-list-item-subtitle>
      </v-list-item-content>
    </v-list-item>

    <v-divider></v-divider>

    <v-list dense flat class="px-0">
      <v-list-item-group active-class="navigation-item-border">
        <v-list-item v-for="(item, i) in items" :key="i" :to="item.path" color="black">
          <v-list-item-content>
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list-item-group>
    </v-list>

    <v-divider></v-divider>

    <div class="text-center mt-4">
      <v-btn to="/upload" outlined color="grey">
        <v-icon class="mr-2">mdi-cloud-upload</v-icon>Upload
      </v-btn>
    </div>
  </v-navigation-drawer>
</template>
<script>
export default {
  data() {
    return {
      items: [
        { title: "Explore", path: "/explore" },
        { title: "Feed", path: "/feed" },
        { title: "Likes", path: "/likes" },
        { title: "Following / Followers", path: "/following" },
        { title: "Setting", path: "/setting" },
      ],
      logo_src: "/img/logo.png",
    };
  },
  computed: {
    accountname() {
      return this.$store.getters["auth/accountname"];
    },
    username() {
      return this.$store.getters["auth/username"];
    },
    profilePicture() {
      return this.$store.getters["auth/profilePicture"];
    },
  },
};
</script>

<style scoped>
.navigation-item-border {
  border-left: 8px solid #000000;
}
.v-btn:hover {
  background-color: white !important;
  color: black !important;
}
.theme--light.v-btn--active:before {
  background-color: white;
  color: black !important;
  opacity: 0 !important;
}
</style>
