<template>
  <v-container>
    <v-card flat class="mx-auto" width="400px">
      <v-card-title class="text-center justify-center py-6">
        <h1 class="font-italic font-weight-bold display-3 basil--text">CULTURIST</h1>
      </v-card-title>
      <v-form>
        <validation-errors-alert v-if="registerErrorMessages" :errors=registerErrorMessages.name></validation-errors-alert>
        <v-text-field
          v-model="registerFormData.name"
          label="Name"
          color="black"
        >
        </v-text-field>
        <validation-errors-alert v-if="registerErrorMessages" :errors=registerErrorMessages.user_name></validation-errors-alert>
        <v-text-field
          v-model="registerFormData.user_name"
          label="User Id"
          prefix="@"
          color="black"
        >
        </v-text-field>
        <validation-errors-alert v-if="registerErrorMessages" :errors=registerErrorMessages.email></validation-errors-alert>
        <v-text-field
          v-model="registerFormData.email"
          label="Email"
          color="black"
        >
        </v-text-field>
        <validation-errors-alert v-if="registerErrorMessages" :errors=registerErrorMessages.password></validation-errors-alert>
        <v-text-field
          v-model="registerFormData.password"
          label="Password"
          type="password"
          color="black"
        >
        </v-text-field>
        <v-text-field
          v-model="registerFormData.password_confirmation"
          label="Password  (confirm)"
          type="password"
          color="black"
        >
        </v-text-field>
        <div class="my-4">
          <v-btn @click="register" outlined block :loading="loading">
            Submit
          </v-btn>
        </div>
      </v-form>
    </v-card>
  </v-container>
</template>
<script>
import ValidationErrorsAlert from '../shared/ValidationErrorsAlert.vue'
export default{
  components: {
    ValidationErrorsAlert
  },
  data(){
    return{
      registerFormData: {
        name: '',
        user_name:'',
        email: '',
        password: '',
        password_confirmation: '',
      },
      loading: false
    }
  },
  computed:{
    apiStatus(){
      return this.$store.state.auth.apiStatus
    },
    registerErrorMessages(){
      return this.$store.state.auth.registerErrorMessages
    }
  },
  methods:{
    async register(){
      this.loading = true
      await this.$store.dispatch('auth/register', this.registerFormData)

      this.loading = false
      if(this.apiStatus){
          this.$router.push('/explore')
      }
    }
  }
}
</script>
