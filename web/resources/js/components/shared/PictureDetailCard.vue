<template>
  <!-- overlayはdefaultでdark-themeなので上書き -->
  <v-overlay
    :dark="false"
  >
    <v-card
      width="1200px"
      height="650px"
      class="mx-auto"
    >
      <v-list-item>
        <v-list-item-avatar color="grey"></v-list-item-avatar>
        <v-list-item-content>
          <v-list-item-title class="headline">Picture Title</v-list-item-title>
          <v-list-item-subtitle>
            by
            <router-link
              to="/user"
              class="user-link"
            >
              username
            </router-link>
          </v-list-item-subtitle>
        </v-list-item-content>
        <v-btn icon color="pink" @click="unlike" v-if="liked">
          <v-icon>mdi-heart</v-icon>
        </v-btn>
        <v-btn icon color="pink" @click="like" v-if="!liked">
          <v-icon>mdi-heart-outline</v-icon>
        </v-btn>
        <v-btn
          icon
          @click="closeDetail"
          color="black"
        >
          <v-icon>mdi-close</v-icon>
        </v-btn>
      </v-list-item>

      <v-row justify="center">
        <v-img
          :src="item.src"
          max-width="1000px"
          max-height="500px"
          contain
        >
        </v-img>
      </v-row>
    </v-card>
  </v-overlay>
</template>
<script>
export default{
  props: {
    item: {
      type:Object,
      required: true,
    }
  },
  data(){
    return{
      overlay: false,
      liked: false
    }
  },
  methods:{
    closeDetail(){
      this.$emit('closeDetail')
    },
    like(){
      this.liked = true
    },
    unlike(){
      this.liked = false
    }
  }
}
</script>
<style scoped>
  .user-link{
    text-decoration: none;
    color: grey;
  }
  .user-link:hover{
    color:black;
  }
</style>
