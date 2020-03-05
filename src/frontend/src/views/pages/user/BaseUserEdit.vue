<!-- =========================================================================================
  File Name: UserEditTabInformation.vue
  Description: User Edit Information Tab content
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->

<template>
  <div id="user-edit-tab-info">

    <!-- Profile Picture Row -->
    <div class="vx-row">
      <div class="vx-col w-full">
        <div class="flex items-start flex-col sm:flex-row">
          <img :src="data.photoURL" class="mr-8 rounded h-24 w-24"/>
          <!-- <vs-avatar :src="data.avatar" size="80px" class="mr-4" /> -->
          <div>
            <p class="text-lg font-medium mb-2 mt-4 sm:mt-0">{{ data.login_id }}</p>
            <input type="file" class="hidden" ref="update_avatar_input" @change="update_avatar" accept="image/*">

            <!-- Toggle comment of below buttons as one for actual flow & currently shown is only for demo -->
            <vs-button class="mr-4 mb-4">Change Profile Picture</vs-button>
            <!-- <vs-button type="border" class="mr-4" @click="$refs.update_avatar_input.click()">Change Profile Picture</vs-button> -->

            <vs-button type="border" color="danger">Remove Profile Picture</vs-button>
          </div>
        </div>
      </div>
    </div>

    <!-- Content Row -->
    <div class="vx-row">
      <div class="vx-col md:w-1/2 w-full">
        <vs-input class="w-full mt-4" label="login_id" v-model="data_local.login_id"
                  v-validate="'alpha_dash|max:50|min:3'" name="login_id" disabled="true"/>
        <span class="text-danger text-sm" v-show="errors.has('login_id')">{{ errors.first('login_id') }}</span>

        <vs-input class="w-full mt-4" label="Email" v-model="data_local.email" type="email" v-validate="'email|max:50'"
                  name="email"/>
        <span class="text-danger text-sm" v-show="errors.has('email')">{{ errors.first('email') }}</span>

        <vs-input class="w-full mt-4" label="Password" v-model="password" ref="password" v-validate="'min:6|alpha'"
                  type="password"
                  name="password"/>
        <span class="text-danger text-sm" v-show="errors.has('password')">{{ errors.first('password') }}</span>

      </div>

      <div class="vx-col md:w-1/2 w-full">

        <div class="vx-col md:w-1/2 w-full">
          <vs-input class="w-full mt-4" label="Phone" v-model="data_local.phone_number" v-validate="'max:13|min:10'"
                    name="phone_number"/>
          <span class="text-danger text-sm"
                v-show="errors.has('phone_number')">{{ errors.first('phone_number') }}</span>

          <vs-input class="w-full mt-4" label="Alternate Phone" v-model="data_local.alternate_phone_number"
                    v-validate="'max:13|min:10'" name="alternate_phone_number"/>
          <span class="text-danger text-sm" v-show="errors.has('alternate_phone_number')">{{ errors.first('alternate_phone_number') }}</span>

          <vs-input class="w-full mt-4" label="Confirm Password" v-model="confirm_password"
                    v-validate="'min:6|confirmed:password'"
                    type="password" name="password_confirmation"/>
          <span class="text-danger text-sm" v-show="errors.has('password_confirmation')">{{ errors.first('password_confirmation') }}</span>

        </div>

      </div>
    </div>

    <div class="vx-row">
      <div class="vx-col w-full">
        <div class="mt-8 flex flex-wrap items-center justify-end">
          <vs-button class="ml-auto mt-2" @click="save_changes" id="save" :disabled="!validateForm">Save Changes
          </vs-button>
          <vs-button class="ml-4 mt-2" type="border" color="warning" @click="reset_data">Reset</vs-button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import vSelect from 'vue-select'

  export default {
    components: {
      vSelect
    },
    props: {
      data: {
        type: Object,
        required: true,
      },
    },
    data() {
      return {
        password: null,
        confirm_password: null,

        data_local: JSON.parse(JSON.stringify(this.data)),
      }
    },
    computed: {
      status_local: {
        get() {
          return {label: this.capitalize(this.data_local.status), value: this.data_local.status}
        },
        set(obj) {
          this.data_local.status = obj.value
        }
      },
      role_local: {
        get() {
          return {label: this.capitalize(this.data_local.base_role), value: this.data_local.base_role}
        },
        set(obj) {
          this.data_local.base_role = obj.value
        }
      },
      validateForm() {
        return !this.errors.any()
      }
    },
    methods: {
      capitalize(str) {
        return str.slice(0, 1).toUpperCase() + str.slice(1, str.length)
      },

      save_changes() {
        if (!this.validateForm) return;

        if (this.password) this.data_local.password = this.password;

        this.$vs.loading({
          'container': "#save",
          'scale': 0.45
        })

        this.$store.dispatch("userManagement/updateUser", this.data_local)
          .then(() => {

            let profileData = {
              user_id: this.data_local.id,
              user: this.data_local
            }

            this.$store.dispatch('userManagement/upsertToState', {
              data: profileData,
              type: this.data_local.base_role
            })


            this.$vs.loading.close("#save > .con-vs-loading");

            this.$vs.notify({
              title: 'Account Update',
              text: 'Account details updated!',
              iconPack: 'feather',
              icon: 'icon-alert-circle',
              color: 'success'
            })

          })
          .catch(error => {

            console.log(error);

            this.$vs.loading.close("#save > .con-vs-loading");

              this.$vs.notify({
                title: 'Error',
                text: "Error updting",
                iconPack: 'feather',
                icon: 'icon-alert-circle',
                color: 'danger'
              })
          })

      },

      reset_data() {
        this.data_local = JSON.parse(JSON.stringify(this.data))
        this.password = null
        this.confirm_password = null
      },

      update_avatar(){

      },

    },
  }
</script>
