<template>
  <form data-vv-scope="step-2" id="create-staff-form">

    <div class="vx-row">
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-select class="w-full" v-model="staff_local.prefix" label="Prefix">
          <vs-select-item :key="index" :value="item" :text="item" v-for="(item,index) in prefixes"
                          class="w-full"/>
        </vs-select>
        <span class="text-danger">{{ errors.first('step-2.prefixes') }}</span>
      </div>

      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-select class="w-full" v-model="staff_local.gender" label="Gender">
          <vs-select-item :key="index" :value="item" :text="item" v-for="(item,index) in genders"
                          class="w-full"/>
        </vs-select>
        <span class="text-danger">{{ errors.first('step-2.genders') }}</span>
      </div>

    </div>

    <div class="vx-row">
      <div class="vx-col sm:w-1/3 w-full mb-2">
        <vs-input class="w-full" label="First Name" v-model="staff_local.first_name" type="first_name"
                  v-validate="'required|max:50|min:3|alpha'"
                  name="first_name"/>
        <span class="text-danger">{{ errors.first('step-2.first_name') }}</span>
      </div>
      <div class="vx-col sm:w-1/3 w-full mb-2">
        <vs-input class="w-full" label="Middle Name" v-model="staff_local.middle_name"
                  v-validate="'max:50|min:3|alpha'"
                  name="middle_name"/>
        <span class="text-danger">{{ errors.first('step-2.middle_name') }}</span>

      </div>

      <div class="vx-col sm:w-1/3 w-full mb-2">
        <vs-input class="w-full" label="Last Name" v-model="staff_local.last_name"
                  v-validate="'required|max:50|min:3|alpha'"
                  name="last_name"/>
        <span class="text-danger">{{ errors.first('step-2.last_name') }}</span>
      </div>

    </div>

    <div class="vx-row">
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-input class="w-full" label="Aadhaar No." v-model="staff_local.aadhaar_no"
                  v-validate="'required|digits:12|numeric'"
                  name="aadhaar_no"/>
        <span class="text-danger">{{ errors.first('step-2.aadhaar_no') }}</span>
      </div>

      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-input class="w-full" label="Passport No." v-model="staff_local.passport_no"
                  v-validate="'max:50|min:3'"
                  name="passport_no"/>
        <span class="text-danger">{{ errors.first('step-2.passport_no') }}</span>
      </div>

    </div>


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

  </form>
</template>

<script>
  import {FormWizard, TabContent} from 'vue-form-wizard'
  import 'vue-form-wizard/dist/vue-form-wizard.min.css'
  import constants from "../../../constants";
  // import {Validator} from 'vee-validate';
  // import jwt from '@/http/requests/auth/jwt/index.js';

  export default {
    components: {
      FormWizard,
      TabContent,
    },
    props: {
      staff: {
        type: Object,
        required: true
      }
    },

    computed: {

      validateForm() {
        return !this.errors.any()
      }
    },

    data() {
      return {
        staff_local: JSON.parse(JSON.stringify(this.staff)),
        prefixes: constants.PREFIXES,
        genders: constants.GENDER,
      }
    },
    methods: {
      save_changes() {
        if (!this.validateForm) return;

        console.log(this.staff_local);

        this.$vs.loading({
          'container': "#save",
          'scale': 0.45
        })

        this.$store.dispatch("userManagement/updateStaff", this.staff_local)
          .then(() => {
            this.$vs.loading.close("#save > .con-vs-loading");

            this.$vs.notify({
              title: 'User Update',
              text: 'Staff Profile details updated!',
              iconPack: 'feather',
              icon: 'icon-alert-circle',
              color: 'success'
            });

            this.$store.dispatch("userManagement/upsertToState",
              {type: "Staff", data :this.staff_local});

            if (this.staff_local.user_id == this.$store.state.AppActiveUser.id) {

              const name = {
                user: {
                  name: this.staff_local.first_name + " " + this.staff_local.last_name
                }
              };

              this.$store.commit('UPDATE_USER_INFO', name);
            }

          })
          .catch(error => {
            this.$vs.loading.close("#save > .con-vs-loading");

            if (error.response) {
              let errors = Object.values(error.response.data);
              errors = errors.flat();

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
        this.staff_local = JSON.parse(JSON.stringify(this.staff));
      }

    }

  }
</script>
