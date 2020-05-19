<template>
  <v-container>
    <v-card flat class="mx-auto" width="400px">
      <v-card-title class="text-center justify-center py-6">
        <h1 class="font-italic font-weight-bold display-3 basil--text">CULTURIST</h1>
      </v-card-title>
      <v-form>
        <validation-errors-alert v-if="loginErrorMessages" :errors=loginErrorMessages.email></validation-errors-alert>
        <v-text-field
          v-model="loginFormData.email"
          label="Email"
        >
        </v-text-field>
        <validation-errors-alert v-if="loginErrorMessages" :errors=loginErrorMessages.password></validation-errors-alert>
        <v-text-field
          v-model="loginFormData.password"
          label="Password"
          type="password"
        >
        </v-text-field>
        <div class="my-4">
          <v-btn @click="login" :loading="loading1" outlined block>
            Submit
          </v-btn>
        </div>
      </v-form>
      <p class="medium">
        Don't Have An Account ??
        <router-link
          to="/signup"
        >
           Sign Up Now !!
        </router-link>
      </p>
      <v-divider class="mt-8 mb-12"></v-divider>
      <div class="my-4">
        <v-btn @click="loginAsTestUser" :loading="loading2" outlined block color="primary">
          <v-icon>mdi-account-edit</v-icon>
          Login As Test User
        </v-btn>
      </div>
    </v-card>
  </v-container>
</template>
<script>
import ValidationErrorsAlert from '../shared/ValidationErrorsAlert.vue'
export default {
  components: {
    ValidationErrorsAlert
  },
  data(){
    return{
      loginFormData: {
        email: '',
        password: ''
      },
      loading1: false,
      loading2: false
    }
  },
  computed: {
    apiStatus () {
      return this.$store.state.auth.apiStatus
    },
    loginErrorMessages(){
      return this.$store.state.auth.loginErrorMessages
    },
  },
  methods:{
    async login(){
      this.loading1 = true
      await this.$store.dispatch('auth/login', this.loginFormData)

      this.loading1 = false
      if(this.apiStatus){
        this.$router.push('/explore')
      }
    },
    async loginAsTestUser(){
      this.loading2 = true
      await this.$store.dispatch('auth/login', {email: "dummy@gmail.com", password: "dummydummy"})

      this.loading2 = false
      if(this.apiStatus){
        this.$router.push('/explore')
      }
    }
  }
}
</script>
