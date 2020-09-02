<template>
  <v-list two-line>
    <v-list-item v-for="(item, i) in items" :key="i">
      <v-list-item-avatar>
        <v-img :src="profilePictureSrc(item)"></v-img>
      </v-list-item-avatar>

      <v-list-item-content>
        <v-list-item-title>{{ item.name }}</v-list-item-title>
        <v-list-item-subtitle>
          <router-link
            :to="{ name: 'user', params:{username: item.user_name}}"
            class="user-link"
          >@{{ item.user_name }}</router-link>
        </v-list-item-subtitle>
      </v-list-item-content>

      <v-list-item-action>
        <v-btn v-if="!item.followed_by_user" color="black" outlined @click="followUser(item)">Follow</v-btn>
        <v-btn v-else color="black" class="white--text" @click="unfollowUser(item)">Following</v-btn>
      </v-list-item-action>
    </v-list-item>
  </v-list>
</template>
<script>
import status from "@/constants.js";
export default {
  props: {
    items: {
      type: Array,
      required: true,
    },
  },
  methods: {
    profilePictureSrc(item) {
      if (item.profile_picture != null) {
        return item.profile_picture.url;
      } else {
        return "/img/avator.png";
      }
    },
    async followUser(item) {
      const response = await axios.post(`/api/${item.user_name}/follow`);

      if (response.status !== status.CREATED) {
        this.$store.commit("error/setCode", response.status);
        return false;
      }

      item.followed_by_user = true;
    },

    async unfollowUser(item) {
      const response = await axios.delete(`/api/${item.user_name}/follow`);

      if (response.status !== status.NO_CONTENT) {
        this.$store.commit("error/setCode", response.status);
        return false;
      }

      item.followed_by_user = false;
    },
  },
};
</script>
