<template>
  <v-card
    tile
    outlined
  >
    <v-hover v-slot:default="{ hover }">
    <v-img
      :src="item.artwork.url"
      aspect-ratio="1"
      contain
      :class="{'image-clickable': hover}"
      :gradient="hover ? 'to top, rgba(0, 0, 0, 0.4) 0%, transparent 180px' : undefined"
    >
      <v-row
        class="fill-height ma-0"
        align="center"
        justify="center"
      >
        <v-icon
          size="100"
          style="opacity: 0"
          color="white"
          :class="{'show-btn': hover }"
        >
          mdi-arrow-right-drop-circle
        </v-icon>
      </v-row>
    </v-img>
  </v-hover>
    <v-card-text class="py-0">
      <p class="ma-0 subtitle-1 black--text">{{ item.title }}</p>
      <router-link
        :to="{ name: 'user', params:{username: item.artist.user_name}}"
        class="user-link"
      >
        {{ item.artist.user_name }}
      </router-link>
    </v-card-text>
  </v-card>
</template>
<script>
export default{
  props: {
    item: {
       type:Object,
       required: true
     }
   }
}
</script>
<style scoped>
  .show-btn{
    opacity: 1 !important;
  }
  .image-clickable{
    cursor: pointer;
  }
  .user-link{
    text-decoration: none;
    color: grey;
  }
  .user-link:hover{
    color:black;
  }
</style>
