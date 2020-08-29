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
          <vertical-user-list :items="users"></vertical-user-list>
        </v-tab-item>
        <v-tab-item>
          <vertical-user-list :items="users"></vertical-user-list>
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
      users: [
        {
          name: "hoge",
          user_name: "hogehoge",
          profile_picture: {
            url: "/img/background.jpg",
          },
        },
        {
          name: "fuga",
          user_name: "fugafuga",
          profile_picture: {
            url: "/img/background.jpg",
          },
        },
        {
          name: "hey",
          user_name: "heyhey",
          profile_picture: {
            url: "/img/background.jpg",
          },
        },
      ],
    };
  },
};
</script>
