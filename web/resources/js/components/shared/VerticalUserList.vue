<template>
  <v-list two-line>
    <v-list-item v-for="(item, i) in items" :key="i">
      <v-list-item-avatar>
        <v-img :src="item.profile_picture.url"></v-img>
      </v-list-item-avatar>

      <v-list-item-content>
        <v-list-item-title>{{ item.name }}</v-list-item-title>
        <v-list-item-subtitle>{{ item.user_name}}</v-list-item-subtitle>
      </v-list-item-content>

      <v-list-item-action>
        <v-btn outlined>Follow</v-btn>
      </v-list-item-action>
    </v-list-item>
  </v-list>
</template>
<script>
export default {
  props: {
    items: {
      type: Array,
      required: true,
    },
  },
  data() {
    return {
      avatar_src: "/img/avator.png",
    };
  },
};
</script>
