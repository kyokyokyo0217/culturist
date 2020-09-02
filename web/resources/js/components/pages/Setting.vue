<template>
  <content-layout>
    <template v-slot:title>Setting</template>
    <template v-slot:content>
      <v-row>
        <v-btn @click="dialog = true" class="mx-auto" outlined color="red">
          <v-icon left>mdi-account-alert</v-icon>
          <span class="ml-2">Sign Out</span>
        </v-btn>
        <v-dialog v-model="dialog" width="450">
          <v-card class="pa-2">
            <v-card-title>Are You Sure To Delete This Account?</v-card-title>
            <v-divider></v-divider>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn text @click="dialog = false">Cancel</v-btn>
              <v-btn color="red" outlined @click="deleteAccount" :loading="loading">Sign Out</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-row>
    </template>
  </content-layout>
</template>
<script>
import status from "@/constants.js";
import ContentLayout from "@components/core/ContentLayout.vue";
export default {
  components: {
    ContentLayout,
  },
  data() {
    return {
      dialog: false,
      loading: false,
    };
  },
  computed: {
    username() {
      return this.$store.getters["auth/username"];
    },
  },
  methods: {
    async deleteAccount() {
      this.loading = true;
      const response = await axios.delete(`/api/users/${this.username}`);

      if (response.status !== status.NO_CONTENT) {
        this.$store.commit("error/setCode", response.status);
        return false;
      }

      await this.$store.dispatch("auth/logout");

      this.dialog = false;
      this.loading = false;

      this.$router.push("/explore").catch((err) => {});
    },
  },
};
</script>
