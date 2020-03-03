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


        <!--        <div class="mt-4">-->
        <!--          <label class="vs-input&#45;&#45;label">Status</label>-->
        <!--          <v-select v-model="status_local" :clearable="false" :options="statusOptions" v-validate="'required'" name="status" :dir="$vs.rtl ? 'rtl' : 'ltr'" />-->
        <!--          <span class="text-danger text-sm"  v-show="errors.has('status')">{{ errors.first('status') }}</span>-->
        <!--        </div>-->

        <!--        <div class="mt-4">-->
        <!--          <label class="vs-input&#45;&#45;label">Role</label>-->
        <!--          <v-select v-model="role_local" :clearable="false" :options="roleOptions" v-validate="'required'" name="role" :dir="$vs.rtl ? 'rtl' : 'ltr'" />-->
        <!--          <span class="text-danger text-sm"  v-show="errors.has('role')">{{ errors.first('role') }}</span>-->
        <!--        </div>-->
        <!--        <vs-input class="w-full mt-4" label="Company" v-model="data_local.company" v-validate="'alpha_spaces'" name="company" />-->
        <!--        <span class="text-danger text-sm"  v-show="errors.has('company')">{{ errors.first('company') }}</span>-->

      </div>
    </div>

    <!--    &lt;!&ndash; Permissions &ndash;&gt;-->
    <!--    <vx-card class="mt-base" no-shadow card-border>-->

    <!--      <div class="vx-row">-->
    <!--        <div class="vx-col w-full">-->
    <!--          <div class="flex items-end px-3">-->
    <!--            <feather-icon svgClasses="w-6 h-6" icon="LockIcon" class="mr-2" />-->
    <!--            <span class="font-medium text-lg leading-none">Permissions</span>-->
    <!--          </div>-->
    <!--          <vs-divider />-->
    <!--        </div>-->
    <!--      </div>-->

    <!--      <div class="block overflow-x-auto">-->
    <!--        <table class="w-full">-->
    <!--          <tr>-->
    <!--            &lt;!&ndash;-->
    <!--              You can also use `Object.keys(Object.values(data_local.permissions)[0])` this logic if you consider,-->
    <!--              our data structure. You just have to loop over above variable to get table headers.-->
    <!--              Below we made it simple. So, everyone can understand.-->
    <!--             &ndash;&gt;-->
    <!--            <th class="font-semibold text-base text-left px-3 py-2" v-for="heading in ['Module', 'Read', 'Write', 'Create', 'Delete']" :key="heading">{{ heading }}</th>-->
    <!--          </tr>-->

    <!--          <tr v-for="(val, name) in data_local.permissions" :key="name">-->
    <!--            <td class="px-3 py-2">{{ name }}</td>-->
    <!--            <td v-for="(permission, name) in val" class="px-3 py-2" :key="name+permission">-->
    <!--              <vs-checkbox v-model="val[name]" />-->
    <!--            </td>-->
    <!--          </tr>-->
    <!--        </table>-->
    <!--      </div>-->

    <!--    </vx-card>-->

    <!-- Save & Reset Button -->
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
