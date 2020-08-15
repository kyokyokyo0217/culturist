<template>
  <v-app>
    <navigation-drawer v-if="isLogin"></navigation-drawer>
    <app-bar></app-bar>
    <main-view></main-view>
    <audio-player v-if="visible" :file="nowPlaying"></audio-player>
  </v-app>
</template>

<script>
import { INTERNAL_SERVER_ERROR, UNAUTHORIZED, NOT_FOUND } from "@/util";
import NavigationDrawer from "@components/core/NavigationDrawer.vue";
import AudioPlayer from "@components/core/AudioPlayer.vue";
import MainView from "@components/core/MainView.vue";
import AppBar from "@components/core/AppBar.vue";

export default {
  components: {
    NavigationDrawer,
    AppBar,
    MainView,
    AudioPlayer,
  },
  data() {
    return {
      visible: false,
    };
  },
  computed: {
    isLogin() {
      return this.$store.getters["auth/check"];
    },
    errorCode() {
      return this.$store.state.error.code;
    },
    apiStatus() {
      return this.$store.state.auth.apiStatus;
    },
    nowPlaying() {
      return this.$store.getters["track/track"];
    },
  },
  watch: {
    nowPlaying(val, old) {
      this.visible = true;
    },
    errorCode: {
      async handler(val) {
        if (val === INTERNAL_SERVER_ERROR) {
          this.$router.push("/500");
        } else if (val === UNAUTHORIZED) {
          await axios.get("/api/refresh-token");
          this.$store.commit("auth/setUser", null);
          this.$router.push("/login");
        } else if (val === NOT_FOUND) {
          this.$router.push("/404");
        }
      },
      immediate: true,
    },
    // $route () {
    //   this.$store.commit('error/setCode', null)
    // }
  },
};
</script>
