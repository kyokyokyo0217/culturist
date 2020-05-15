<template>
 <v-footer app padless>
  <v-card flat tile width="100%">
    <v-card-text class="text-center">
      <v-btn outlined icon small class="mb-2" @click.native="playing ? pause() : play()" :disabled="!loaded">
        <v-icon v-if="!playing || paused">mdi-play</v-icon>
        <v-icon v-else>mdi-pause</v-icon>
      </v-btn>
      <v-progress-linear v-model="percentage" height="5" @click.native="setPosition()" :disabled="!loaded"></v-progress-linear>
      <span>{{ currentTime }} / {{ duration }}</span>
    </v-card-text>
    <audio id="player" ref="player" v-on:ended="ended" v-on:canplay="canPlay" :src="file.url"></audio>
    </v-card>
  </v-footer>
</template>
<script>
const formatTime = second => new Date(second * 1000).toISOString().substr(11, 8);
export default {
  props: {
    file: {
      type: Object,
      default: null
    },
    autoPlay: {
        type: Boolean,
        default: false
    },
    ended: {
        type: Function,
        default: () => {},
    },
    canPlay: {
        type: Function,
        default: () => {},
    },
  },
  computed: {
    duration: function () {
      return this.audio ? formatTime(this.totalDuration) : ''
    },
  },
  data () {
    return {
      firstPlay: true,
      isMuted: false,
      loaded: false,
      playing: false,
      paused: false,
      percentage: 0,
      currentTime: '00:00:00',
      audio: undefined,
      totalDuration: 0,
    }
  },
  methods: {
    setPosition () {
      this.audio.currentTime = parseInt(this.audio.duration / 100 * this.percentage);
    },
    stop () {
      this.audio.pause()
      this.paused = true
      this.playing = false
      this.audio.currentTime = 0
    },
    play () {
      if (this.playing) return
      this.audio.play().then(_ => this.playing = true)
      this.paused = false
    },
    pause () {
      this.paused = !this.paused;
      (this.paused) ? this.audio.pause() : this.audio.play()
    },
    reload () {
      this.audio.load();
    },
    _handleLoaded: function () {
      if (this.audio.readyState >= 2) {
          this.totalDuration = parseInt(this.audio.duration)
          this.loaded = true
        if (this.autoPlay) this.audio.play()
      } else {
        throw new Error('Failed to load sound file')
      }
    },
    _handlePlayingUI: function (e) {
      this.percentage = this.audio.currentTime / this.audio.duration * 100
      this.currentTime = formatTime(this.audio.currentTime)
      this.playing = true
    },
    _handlePlayPause: function (e) {
      if (e.type === 'play' && this.firstPlay) {
        // in some situations, audio.currentTime is the end one on chrome
        this.audio.currentTime = 0;
        if (this.firstPlay) {
          this.firstPlay = false;
        }
      }
      if (e.type === 'pause' && this.paused === false && this.playing === false) {
        this.currentTime = '00:00:00'
      }
    },
    _handleEnded () {
      this.paused = this.playing = false;
    },
    init: function () {
      this.audio.addEventListener('timeupdate', this._handlePlayingUI);
      this.audio.addEventListener('loadeddata', this._handleLoaded);
      this.audio.addEventListener('pause', this._handlePlayPause);
      this.audio.addEventListener('play', this._handlePlayPause);
      this.audio.addEventListener('ended', this._handleEnded);
    },
    reset(){
      this.audio.removeEventListener('timeupdate', this._handlePlayingUI)
      this.audio.removeEventListener('loadeddata', this._handleLoaded)
      this.audio.removeEventListener('pause', this._handlePlayPause)
      this.audio.removeEventListener('play', this._handlePlayPause)
      this.audio.removeEventListener('ended', this._handleEnded)
      this.firstPlay = true
    }
  },
  mounted () {
    this.audio = this.$refs.player
    this.init()
    this.play()
  },
  // beforeDestroy () {
  //   this.reset()
  // },
  watch: {
    file: {
      handler(val){
        // this.audio = this.$refs.player
        this.stop()
        console.log(this.percentage)
        this.percentage = this.audio.currentTime / this.audio.duration * 100
        console.log(this.percentage)

        this.reset()
        this.init()
        this.play()

      },
      // immediate: true
    }
  }
}
</script>
