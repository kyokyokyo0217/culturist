<template>
  <!-- errorなくてもレンダリングしてるので無駄が多い -->
  <v-alert type="error" v-show="errors">
    <ul>
      <li v-for="(error, i) in errors" :key="i">{{ error }}</li>
    </ul>
  </v-alert>
</template>
<script>
export default {
  props: {
    errors: Array,
    required: true
  }
};
</script>
