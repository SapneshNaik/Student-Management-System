<template>
  <form data-vv-scope="step-2" id="create-student-form">

    <div class="vx-row">
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-select class="w-full" v-model="student_local.prefix" label="Prefix">
          <vs-select-item :key="index" :value="item" :text="item" v-for="(item,index) in prefixes"
                          class="w-full"/>
        </vs-select>
        <span class="text-danger">{{ errors.first('step-2.prefixes') }}</span>
      </div>

      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-select class="w-full" v-model="student_local.gender" label="Gender">
          <vs-select-item :key="index" :value="item" :text="item" v-for="(item,index) in genders"
                          class="w-full"/>
        </vs-select>
        <span class="text-danger">{{ errors.first('step-2.genders') }}</span>
      </div>

    </div>

    <div class="vx-row">
      <div class="vx-col sm:w-1/3 w-full mb-2">
        <vs-input class="w-full" label="First Name" v-model="student_local.first_name" type="first_name"
                  v-validate="'required|max:50|min:3|alpha'"
                  name="first_name"/>
        <span class="text-danger">{{ errors.first('step-2.first_name') }}</span>
      </div>
      <div class="vx-col sm:w-1/3 w-full mb-2">
        <vs-input class="w-full" label="Middle Name" v-model="student_local.middle_name"
                  v-validate="'max:50|min:3|alpha'"
                  name="middle_name"/>
        <span class="text-danger">{{ errors.first('step-2.middle_name') }}</span>

      </div>

      <div class="vx-col sm:w-1/3 w-full mb-2">
        <vs-input class="w-full" label="Last Name" v-model="student_local.last_name"
                  v-validate="'required|max:50|min:3|alpha'"
                  name="last_name"/>
        <span class="text-danger">{{ errors.first('step-2.last_name') }}</span>
      </div>

    </div>

    <div class="vx-row">
      <div class="vx-col sm:w-1/3 w-full mb-2">
        <vs-select class="w-full" v-model="student_local.religion" label="Religion">
          <vs-select-item :key="index" :value="item" :text="item" v-for="(item,index) in religions"
                          class="w-full"/>
        </vs-select>
        <span class="text-danger">{{ errors.first('step-2.religions') }}</span>
      </div>

      <div class="vx-col sm:w-1/3 w-full mb-2">
        <vs-input class="w-full" label="Caste" v-model="student_local.caste"
                  v-validate="'required|max:30|min:3|alpha'"
                  name="caste"/>
        <span class="text-danger">{{ errors.first('step-2.caste') }}</span>
      </div>

      <div class="vx-col sm:w-1/3 w-full mb-2">
        <vs-input class="w-full" label="Caste Category" v-model="student_local.caste_category"
                  v-validate="'required|max:30|min:3|alpha'"
                  name="caste_category"/>
        <span class="text-danger">{{ errors.first('step-2.caste_category') }}</span>
      </div>

    </div>

    <div class="vx-row">
      <div class="vx-col sm:w-1/3 w-full mb-2">
        <vs-select class="w-full" v-model="student_local.blood_group" label="Blood Group">
          <vs-select-item :key="index" :value="item" :text="item" v-for="(item,index) in blood_groups"
                          class="w-full"/>
        </vs-select>
        <span class="text-danger">{{ errors.first('step-2.blood_groups') }}</span>
      </div>

      <div class="vx-col sm:w-1/3 w-full mb-2">
        <vs-input class="w-full" label="Aadhaar No." v-model="student_local.aadhaar_no"
                  v-validate="'required|digits:12|numeric'"
                  name="aadhaar_no"/>
        <span class="text-danger">{{ errors.first('step-2.aadhaar_no') }}</span>
      </div>

      <div class="vx-col sm:w-1/3 w-full mb-2">
        <vs-input class="w-full" label="Passport No." v-model="student_local.passport_no"
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


  export default {
    components: {
      FormWizard,
      TabContent,
    },
    props: {
      student: {
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
        student_local: JSON.parse(JSON.stringify(this.student)),
        prefixes: constants.PREFIXES,
        genders: constants.GENDER,
        religions: constants.RELIGIONS,
        blood_groups: constants.BLOOD_GROUP,
      }
    },
    methods: {
      save_changes() {
        if (!this.validateForm) return;

        console.log(this.student_local);

        this.$vs.loading({
          'container': "#save",
          'scale': 0.45
        })

        this.$store.dispatch("userManagement/updateStudent", this.student_local)
          .then(() => {
            this.$vs.loading.close("#save > .con-vs-loading");

            this.$vs.notify({
              title: 'User Update',
              text: 'Student Profile details updated!',
              iconPack: 'feather',
              icon: 'icon-alert-circle',
              color: 'success'
            })

            this.$store.dispatch("userManagement/upsertToState",
              {type: "Student", data :this.student_local});

            if (this.student_local.user_id == this.$store.state.AppActiveUser.id) {
              const name = {
                user: {
                  name: this.student_local.first_name + " " + this.student_local.last_name
                }
              };
              this.$store.commit('UPDATE_USER_INFO', name);
            }

          })
          .catch(error => {
            this.$vs.loading.close("#save > .con-vs-loading");

            console.log(error);
            this.$vs.notify({
              title: 'Error',
              text: "Error updating Student",
              iconPack: 'feather',
              icon: 'icon-alert-circle',
              color: 'danger'
            })
          });

      },


      reset_data() {
        this.student_local = JSON.parse(JSON.stringify(this.student));
      }

    }

  }
</script>
