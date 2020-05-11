<template>
  <v-card class="pt-8 pb-4 mx-4">
    <!-- v-card直下にv-avatar置くとradiusが消える -->
    <div class="text-center">
      <v-avatar size="124" >
        <v-img :src="getProfilePictureUrl()"></v-img>
      </v-avatar>
    </div>
    <!-- v-card-titleはなぜかflexらしい -->
   <v-card-title class="justify-center">
     <router-link
       :to="{ name: 'user', params:{username: item.user_name}}"
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
   },
   data(){
     return{
       avatar_src: '/img/avator.png',
     }
   },
   methods:{
     getProfilePictureUrl(){
       if(this.item.profile_picture != null){
        return this.item.profile_picture.url
       }else{
        return this.avatar_src
       }
      },
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
