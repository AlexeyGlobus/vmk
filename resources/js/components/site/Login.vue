<template>
    <v-row
        align="center"
        justify="center"
    >
        <v-col
            cols="12"
            sm="8"
            md="6"
        >
            <v-card elevation="2" 
                class="pa-4" autocomplete="off" 
                id="login-form" 
                @submit.prevent="login"
            >
            <v-alert
              prominent
              type="error"
              v-if="has_error"
            >
              <v-row align="center">
                <v-col class="grow">
                  Auth error
                </v-col>
              </v-row>
            </v-alert>
              <v-form ref="form">
                <v-text-field
                  v-model="username"
                  :counter="10"
                  label="Login"
                  required
                ></v-text-field>
                <v-text-field
                  v-model="password"
                  label="Password"
                  type="password"
                  required
                ></v-text-field>
                <v-checkbox
                  v-model="remember_me"
                  label="Remember me"
                  required
                ></v-checkbox>

                <v-btn
                  class="mr-4"
                  type="submit"
                  form="login-form"
                  @click.prevent="login"
                >
                  submit
                </v-btn>
                <v-btn @click="clear">
                  clear
                </v-btn>
              </v-form>
            </v-card>
    </v-col>
</v-row>
</template>


<script>
  export default {
    data() {
      return {
        name: 'Login page',  
        username: null,
        password: null,
        remember_me: false,
        has_error: false
      }
    },
    mounted() {
      //
      console.log(this.$auth.redirect())
    },
    methods: {
      login() {
        // get the redirect object
        var redirect = this.$auth.redirect()
        var app = this
        this.$auth.login({
          params: {
            username: app.username,
            password: app.password
          },
          success: function() {
            // handle redirection
            const redirectTo = redirect ? redirect.from.name : this.$auth.user().role === 2 ? 'admin.dashboard' : 'dashboard'
            this.$router.push({name: redirectTo})
          },
          error: function() {
            app.has_error = true
          },
          rememberMe: app.remember_me,
          fetchUser: true
        })
      },
      clear() {
        this.$refs.form.reset();
      }
    }
  }
</script>