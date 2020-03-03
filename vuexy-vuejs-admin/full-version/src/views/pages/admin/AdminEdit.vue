<!-- =========================================================================================
  File Name: UserEditTabInformation.vue
  Description: User Edit Information Tab content
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->

<template>

  <div class="vx-col w-full" id="user-edit-admin-profile">


    <!-- Content Row -->


    <div class="vx-row mb-6">
      <div class="vx-col w-full">
        <vs-select v-model="data_local.prefix" class="w-full select-large" label="Prefix">
          <vs-select-item :key="index" :value="item" :text="item" v-for="(item,index) in prefixes" class="w-full"/>
        </vs-select>
        <span class="text-danger text-sm" v-show="errors.has('prefix')">{{ errors.first('prefix') }}</span>
      </div>
    </div>

    <div class="vx-row mb-6">
      <div class="vx-col w-full">
        <vs-input class="w-full mt-4" label="First Name" v-model="data_local.first_name" type="first_name"
                  v-validate="'max:50|min:3|alpha'"
                  name="first_name"/>
        <span class="text-danger text-sm" v-show="errors.has('first_name')">{{ errors.first('first_name') }}</span>
      </div>
    </div>
    <div class="vx-row mb-6">
      <div class="vx-col w-full">
        <vs-input class="w-full mt-4" label="Last Name" v-model="data_local.last_name" v-validate="'max:50|min:3|alpha'"
                  name="last_name"/>
        <span class="text-danger text-sm"
              v-show="errors.has('last_name')">{{ errors.first('last_name') }}</span></div>
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
  import constants from "../../../constants";

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
        data_local: JSON.parse(JSON.stringify(this.data)),

        prefixes: constants.PREFIXES

      }
    },
    computed: {
      validateForm() {
        return !this.errors.any()
      }
    },
    methods: {
      save_changes() {
        if (!this.validateForm) return;

        if (this.password) this.data_local.password = this.password;

        this.$vs.loading({
          'container': "#save",
          'scale': 0.45
        })

        this.$store.dispatch("userManagement/updateAdmin", this.data_local)
          .then(() => {
            this.$vs.loading.close("#save > .con-vs-loading");

            this.$vs.notify({
              title: 'User Update',
              text: 'Admin Profile details updated!',
              iconPack: 'feather',
              icon: 'icon-alert-circle',
              color: 'success'
            });

            this.$store.dispatch("userManagement/upsertToState",
              {type: "Admin", data: this.data_local});

          })
          .catch(error => {
            this.$vs.loading.close("#save > .con-vs-loading");

            if (error.response) {
              let errors = Object.values(error.response.data);
              errors = errors.flat();

              console.log(errors)


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

      reset_data() {
        this.data_local = JSON.parse(JSON.stringify(this.data))
      },

    },
  }
</script>
