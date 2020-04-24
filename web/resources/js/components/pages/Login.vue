<template>
  <v-container>
    <v-form>
      <v-text-field
        v-model="loginFormData.email"
        label="Email"
      >
      </v-text-field>
      <v-text-field
        v-model="loginFormData.password"
        label="Password"
        type="password"
      >
      </v-text-field>
      <v-col class="text-right">
        <v-btn @click="login">
          Submit
        </v-btn>
      </v-col>
    </v-form>
  </v-container>
</template>
<script>
export default {
  data(){
    return{
      loginFormData: {
        email: '',
        password: ''
      }
    }
  },
  methods:{
    async login(){
      await this.$store.dispatch('auth/login', this.loginFormData)
      this.$router.push('/feed')
    }
  }
}
</script>
