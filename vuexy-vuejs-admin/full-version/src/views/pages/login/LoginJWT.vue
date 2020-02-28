<template>
  <div>
    <vs-input
      v-validate="'required|min:3|max:50'"
      data-vv-validate-on="blur"
      name="login_id"
      icon-no-border
      icon="icon icon-user"
      icon-pack="feather"
      label-placeholder="Login ID"
      v-model="login_id"
      class="w-full"/>
    <span class="text-danger text-sm">{{ errors.first('login_id') }}</span>

    <vs-input
      data-vv-validate-on="blur"
      v-validate="'required|min:6'"
      type="password"
      name="password"
      icon-no-border
      icon="icon icon-lock"
      icon-pack="feather"
      label-placeholder="Password"
      v-model="password"
      class="w-full mt-6"/>
    <span class="text-danger text-sm">{{ errors.first('password') }}</span>

    <div class="flex flex-wrap justify-between my-5">
      <!--        <vs-checkbox v-model="checkbox_remember_me" class="mb-3">Remember Me</vs-checkbox>-->
      <div>
      </div>
      <router-link to="/pages/forgot-password">Forgot Password?</router-link>
    </div>

    <div class="flex flex-wrap justify-between mb-3">
      <div>
      </div>
      <vs-button :disabled="!validateForm" @click="loginJWT">Login</vs-button>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        login_id: '',
        password: '',
        checkbox_remember_me: false
      }
    },
    computed: {
      validateForm() {
        return !this.errors.any() && this.login_id != '' && this.password != '';
      },
    },
    methods: {
      checkLogin() {
        // If user is already logged in notify
        if (this.$store.state.auth.isUserLoggedIn()) {

          // Close animation if passed as payload
          // this.$vs.loading.close()

          this.$vs.notify({
            title: 'Login Attempt',
            text: 'You were already logged in!',
            iconPack: 'feather',
            icon: 'icon-alert-circle',
            color: 'warning'
          })

          return false
        }
        return true
      },
      loginJWT() {

        if (!this.checkLogin()) {
          this.$router.push('/dashboard/sms');
          return
        }

        // Loading
        this.$vs.loading()

        const payload = {
          checkbox_remember_me: this.checkbox_remember_me,
          userDetails: {
            login_id: this.login_id,
            password: this.password
          }
        }

        this.$store.dispatch('auth/loginJWT', payload)
          .then(() => {
            this.$vs.loading.close();

            this.$router.push('/dashboard/sms');

            this.$vs.notify({
              title: 'Login Successful',
              text: 'Welcome User!',
              iconPack: 'feather',
              icon: 'icon-alert-circle',
              color: 'success'
            })

          })
          .catch(error => {

            console.log("There was an error logging in")
            if (error.response) {
              let errors = Object.values(error.response.data);
              errors = errors.flat();

              this.$vs.loading.close()
              errors.forEach((error) => {
                this.$vs.notify({
                  title: 'Error',
                  text: error,
                  iconPack: 'feather',
                  icon: 'icon-alert-circle',
                  color: 'danger'
                })
              });
            } else {
              this.$vs.notify({
                title: 'Error',
                text: error.message,
                iconPack: 'feather',
                icon: 'icon-alert-circle',
                color: 'danger'
              })
            }


          })
      },
      registerUser() {
        if (!this.checkLogin()) return
        this.$router.push('/pages/register').catch(() => {
        })
      }
    }
  }

</script>

