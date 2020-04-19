<template>
  <v-card class="pt-8 pb-4 mx-4">
    <!-- v-card直下にv-avatar置くとradiusが消える -->
    <div class="text-center">
      <v-avatar size="124" >
        <v-img :src="item.src"></v-img>
      </v-avatar>
    </div>
    <!-- v-card-titleはなぜかflexらしい -->
   <v-card-title class="justify-center">
     <router-link
       to="/user"
       class="user-link"
     >
       {{ item.name }}
     </router-link>
   </v-card-title>
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
  .user-link{
    text-decoration: none;
    color: grey;
  }
  .user-link:hover{
    color:black;
  }
</style>
