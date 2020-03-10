<template>
  <form id="create-user-profile" data-vv-scope="step-1" @submit.prevent>
    <div class="vx-row">
      <div class="vx-col md:w-1/2 w-full mt-5">
        <vs-input :disabled="read_only" @blur="generateLoginID" icon-pack="feather" icon="icon-mail" icon-no-border type="email" label="Email"
                  v-model="user.email" class="w-full" name="email"
                  v-validate="'required|email'"/>
        <span class="text-danger">{{ errors.first('step-1.email') }}</span>
      </div>

      <div class="vx-col md:w-1/2 w-full mt-5">
        <vs-input :disabled="read_only" icon-pack="feather" icon="icon-credit-card" icon-no-border label="Login ID"
                  v-model="user.login_id"
                  class="w-full" name="login_id" v-validate="'required'"/>
        <span class="text-danger">{{ errors.first('step-1.login_id') }}</span>
      </div>

      <div class="vx-col md:w-1/2 w-full mt-5">
        <vs-input :disabled="read_only" icon-pack="feather" icon="icon-smartphone" icon-no-border label="Phone Number"
                  v-model="user.phone_number"
                  class="w-full" name="phone_number"
                  v-validate="'required|numeric|max:13|min:10'"/>
        <span class="text-danger">{{ errors.first('step-1.phone_number') }}</span>
      </div>

      <div class="vx-col md:w-1/2 w-full mt-5">
        <vs-input :disabled="read_only" icon-pack="feather" icon="icon-phone" icon-no-border
                  label="Alternate Phone Number"
                  v-model="user.alternate_phone_number" class="w-full"
                  name="alternate_phone_number" v-validate="'numeric|max:13|min:10'"/>
        <span class="text-danger">{{ errors.first('step-1.alternate_phone_number') }}</span>
      </div>

      <div class="vx-col md:w-1/2 w-full mt-5">
        <vs-input :disabled="read_only" icon-pack="feather" icon="icon-lock" icon-no-border label="Password"
                  v-model="user.password" class="w-full"
                  name="password" type="password" ref="password"
                  v-validate="'required|min:6'"/>
        <span class="text-danger">{{ errors.first('step-1.password') }}</span>
      </div>

      <div class="vx-col md:w-1/2 w-full mt-5">
        <vs-input :disabled="read_only" icon-pack="feather" icon="icon-lock" icon-no-border label="Confirm Password"
                  v-model="user.password_confirmation" class="w-full" name="password_confirmation"
                  type="password" v-validate="'required|min:6|confirmed:password'"/>
        <span class="text-danger">{{ errors.first('step-1.password_confirmation') }}</span>
      </div>

      <vs-input :disabled="read_only" name="base_role" :value="user.base_role" type="hidden"/>

    </div>
  </form>
</template>

<script>

  import {Validator} from 'vee-validate';
  import constants from "../../../constants";

  Validator.localize('en', constants.VALIDATION_MESSAGES);

  export default {
    props: {
      role: {
        type: String,
        required: true,
      },
      user: {
        type: Object,
        required: true
      },
      read_only: {
        type: Boolean,
        required: false,
        default: false
      }
    },
    methods: {
      generateLoginID: function () {
        if (!this.errors.first('step-1.email') && this.user.email) {
          this.user.login_id = (this.user.email.split('@')[0] + Math.floor(1000 + Math.random() * 9000)).replace(/\W/g, '')
        }
      },

      validateInput() {
        return new Promise((resolve) => {
          this.$validator.validateAll('step-1').then(result => {
            if (result) {
              resolve(true)
            } else {
              resolve(false);
            }

          })
        })
      }

    }
  }
</script>
