<template>
  <content-layout>
    <template v-slot:title>Following / Followers</template>
    <template v-slot:content>
      <v-tabs v-model="tab" background-color="transparent" color="black">
        <v-tab>Following</v-tab>
        <v-tab>Followers</v-tab>
      </v-tabs>
      <v-tabs-items v-model="tab">
        <v-tab-item>
          <vertical-user-list :items="followingUsers"></vertical-user-list>
        </v-tab-item>
        <v-tab-item>
          <vertical-user-list :items="followers"></vertical-user-list>
        </v-tab-item>
      </v-tabs-items>
    </template>
  </content-layout>
</template>
<script>
import ContentLayout from "@components/core/ContentLayout.vue";
import VerticalUserList from "@components/shared/VerticalUserList.vue";
export default {
  components: {
    ContentLayout,
    VerticalUserList,
  },
  data() {
    return {
      tab: 0,
      followingUsers: [],
      followers: [],
    };
  },
  methods: {
    async fetchFollowingUsers() {
      const response = await axios.get("/api/users/following");

      this.followingUsers = response.data.data;
    },
    async fetchFollowers() {
      const response = await axios.get("/api/users/followers");

      this.followers = response.data.data;
    },
  },
  async created() {
    await this.fetchFollowingUsers();
    await this.fetchFollowers();
  },
};
</script>
