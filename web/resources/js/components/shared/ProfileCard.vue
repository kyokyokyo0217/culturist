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
     {{item.name}}
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
