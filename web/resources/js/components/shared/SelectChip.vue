<template>
  <v-chip-group
    mandatory
    active-class="black accent-4 white--text disable-events"
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
</template>
<script>
  export default {
    methods: {
      selectMusic(){
        this.$store.commit('selectChip/selectChip', 'music')
      },
      selectPicture(){
        this.$store.commit('selectChip/selectChip', 'picture')
      },
    }
  }
</script>
