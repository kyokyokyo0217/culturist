<template>
  <v-form>
    <v-container>
      <v-row>
        <v-col cols="8">
          <validation-errors-alert v-if="errors" :errors="errors.title"></validation-errors-alert>
          <v-text-field v-model="title" label="Title" required color="black"></v-text-field>
          <validation-errors-alert v-if="errors" :errors="errors.picture"></validation-errors-alert>
          <v-file-input label="File Input" @change="onFileChange" id="picture" color="black"></v-file-input>
          <v-col class="text-right">
            <v-btn color="black" outlined @click="uploadFile" :loading="loading">submit</v-btn>
          </v-col>
        </v-col>
        <v-col cols="4">
          <v-card color="grey" width="300px" height="300px">
            <v-img :src="preview" v-if="preview" width="300px" height="300px"></v-img>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </v-form>
</template>
<script>
import status from "@/constants.js";
import ValidationErrorsAlert from "@components/shared/ValidationErrorsAlert.vue";
export default {
  components: {
    ValidationErrorsAlert,
  },
  data() {
    return {
      title: "",
      preview: null,
      file: null,
      errors: null,
      loading: false,
    };
  },
  methods: {
    // ファイルが１つの前提
    onFileChange(event) {
      if (!event) {
        this.reset();
        return false;
      }

      const reader = new FileReader();

      reader.onload = (e) => {
        this.preview = e.target.result;
      };

      reader.readAsDataURL(event);

      this.file = event;
    },
    reset() {
      this.preview = "";
      this.file = null;
      this.$el.querySelector("#picture").value = null;
    },
    async uploadFile() {
      this.loading = true;
      const formData = new FormData();
      formData.append("picture", this.file);
      formData.append("title", this.title);
      const response = await axios.post("/api/pictures", formData);

      if (response.status === status.UNPROCESSABLE_ENTITY) {
        this.errors = response.data.errors;
        this.loading = false;
        return false;
      }

      this.reset();

      if (response.status !== status.CREATED) {
        this.$store.commit("error/setCode", response.status);
        return false;
      }

      this.loading = false;

      this.$router.push("/explore");
    },
  },
};
</script>
