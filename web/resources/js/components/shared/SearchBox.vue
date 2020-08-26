<template>
  <v-text-field
    label="Search"
    prepend-inner-icon="mdi-magnify"
    solo
    dense
    hide-details
    height="4"
    color="black"
    class="compact-form"
    v-on:keyup.enter="search"
    v-model="text"
    :rules="[rules.required]"
  ></v-text-field>
</template>
<script>
export default {
  data() {
    return {
      text: "",
      rules: {
        required: (value) => !!value || "Required.",
      },
    };
  },
  methods: {
    search() {
      if (this.text) {
        this.$router
          .push({ path: "/search", query: { result: this.text } })
          .catch((err) => {});
      }
    },
  },
};
</script>
<style scoped>
.v-input {
  flex: 0 0 auto;
}
.compact-form {
  transform: scale(0.75);
}
</style>
