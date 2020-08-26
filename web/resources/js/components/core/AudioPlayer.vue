<template>
  <v-footer app padless color="white">
    <v-row>
      <v-col cols="1" class="pl-4">
        <v-img :src="file.artwork.url" height="80px" width="80px"></v-img>
      </v-col>
      <v-col cols="2">
        <p class="ma-0 subtitle-1 black--text">{{ file.title }}</p>
        <router-link
          :to="{ name: 'user', params:{username: file.artist.user_name}}"
          class="user-link"
        >{{ file.artist.user_name }}</router-link>
      </v-col>
      <v-col cols="6" class="text-center">
        <v-btn
          outlined
          icon
          small
          class="mb-2"
          @click.native="playing ? pause() : play()"
          :disabled="!loaded"
        >
          <v-icon v-if="!playing || paused">mdi-play</v-icon>
          <v-icon v-else>mdi-pause</v-icon>
        </v-btn>
        <v-progress-linear
          v-model="percentage"
          @click.native="setPosition()"
          :disabled="!loaded"
          height="4"
          rounded
          striped
        ></v-progress-linear>
        <span>{{ currentTime }} / {{ duration }}</span>
        <audio id="player" ref="player" :src="file.url"></audio>
      </v-col>
      <v-col cols="3"></v-col>
    </v-row>
  </v-footer>
</template>
<script>
const formatTime = (second) =>
  new Date(second * 1000).toISOString().substr(11, 8);
export default {
  props: {
    file: {
      type: Object,
      default: null,
    },
  },
  computed: {
    duration: function () {
      return this.audio ? formatTime(this.totalDuration) : "";
    },
  },
  data() {
    return {
      firstPlay: true,
      isMuted: false,
      loaded: false,
      playing: false,
      paused: false,
      percentage: 0,
      currentTime: "00:00:00",
      audio: undefined,
      totalDuration: 0,
      autoPlay: true,
    };
  },
  methods: {
    setPosition() {
      this.audio.currentTime = parseInt(
        (this.audio.duration / 100) * this.percentage
      );
    },
    stop() {
      this.audio.pause();
      this.paused = true;
      this.playing = false;
      this.audio.currentTime = 0;
    },
    play() {
      if (this.playing) return;
      this.audio.play().then((_) => (this.playing = true));
      this.paused = false;
    },
    pause() {
      this.paused = !this.paused;
      this.paused ? this.audio.pause() : this.audio.play();
    },
    reload() {
      this.audio.load();
    },
    _handleLoaded: function () {
      if (this.audio.readyState >= 2) {
        this.totalDuration = parseInt(this.audio.duration);
        this.loaded = true;
        if (this.autoPlay) this.audio.play();
      } else {
        throw new Error("Failed to load sound file");
      }
    },
    _handlePlayingUI: function (e) {
      this.percentage = (this.audio.currentTime / this.audio.duration) * 100;
      this.currentTime = formatTime(this.audio.currentTime);
      this.playing = true;
    },
    _handlePlayPause: function (e) {
      if (e.type === "play" && this.firstPlay) {
        // in some situations, audio.currentTime is the end one on chrome
        this.audio.currentTime = 0;
        if (this.firstPlay) {
          this.firstPlay = false;
        }
      }
      if (
        e.type === "pause" &&
        this.paused === false &&
        this.playing === false
      ) {
        this.currentTime = "00:00:00";
      }
    },
    _handleEnded() {
      this.paused = this.playing = false;
    },
    init: function () {
      this.audio.addEventListener("timeupdate", this._handlePlayingUI);
      this.audio.addEventListener("loadeddata", this._handleLoaded);
      this.audio.addEventListener("pause", this._handlePlayPause);
      this.audio.addEventListener("play", this._handlePlayPause);
      this.audio.addEventListener("ended", this._handleEnded);
    },
    reset() {
      this.audio.removeEventListener("timeupdate", this._handlePlayingUI);
      this.audio.removeEventListener("loadeddata", this._handleLoaded);
      this.audio.removeEventListener("pause", this._handlePlayPause);
      this.audio.removeEventListener("play", this._handlePlayPause);
      this.audio.removeEventListener("ended", this._handleEnded);
    },
  },
  mounted() {
    this.audio = this.$refs.player;
    this.init();
  },
  beforeDestroy() {
    this.reset();
  },
};
</script>
