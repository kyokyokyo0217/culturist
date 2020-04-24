<template>
  <v-container>
    <v-form>
      <v-text-field
        v-model="registerFormData.name"
        label="Name"
      >
      </v-text-field>
      <v-text-field
        v-model="registerFormData.user_name"
        label="User Id"
        prefix="@"
      >
      </v-text-field>
      <v-text-field
        v-model="registerFormData.email"
        label="Email"
      >
      </v-text-field>
      <v-text-field
        v-model="registerFormData.password"
        label="Password"
        type="password"
      >
      </v-text-field>
      <v-text-field
        v-model="registerFormData.password_confirmation"
        label="Password  (confirm)"
        type="password"
      >
      </v-text-field>
      <v-col class="text-right">
        <v-btn @click="register">
          Submit
        </v-btn>
      </v-col>
    </v-form>
  </v-container>
</template>
<script>
  export default{
    data(){
      return{
        registerFormData: {
          name: '',
          user_name:'',
          email: '',
          password: '',
          password_confirmation: '',
        }
      }
    },
    methods:{
      async register(){
        await this.$store.dispatch('auth/register', this.registerFormData)
        this.$router.push('/feed')
        console.log('registered!')
      }
    }
  }
</script>
