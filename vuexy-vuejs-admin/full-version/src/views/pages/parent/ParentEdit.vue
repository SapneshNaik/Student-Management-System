<template>
  <form data-vv-scope="step-3" id="create-parent-form">

    <div class="vx-row">
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-input :disabled="canUpdateStaff" class="w-full" label="Staff ID (required only if parent is a staff)"
                  v-model="parent_local.staff_id" type="staff_id"
                  v-validate="'max:50|min:3|numeric'"
                  name="staff_id"/>
        <span class="text-danger">{{ errors.first('step-3.staff_id') }}</span>
      </div>

    </div>

    <div class="vx-row">
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-input class="w-full" label="Father Full Name" v-model="parent_local.father_full_name"
                  type="first_name"
                  v-validate="'required|max:150|min:3|alpha_spaces'"
                  name="father_full_name"/>
        <span class="text-danger">{{ errors.first('step-3.father_full_name') }}</span>
      </div>
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-input class="w-full" label="Mother Full Name" v-model="parent_local.mother_full_name"
                  v-validate="'required|max:150|min:3|alpha_spaces'"
                  name="mother_full_name"/>
        <span class="text-danger">{{ errors.first('step-3.mother_full_name') }}</span>
      </div>
    </div>

    <div class="vx-row">
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-input class="w-full" label="Father Qualification"
                  v-model="parent_local.father_qualification"
                  v-validate="'required|max:50|min:3'"
                  name="father_qualification"/>
        <span class="text-danger">{{ errors.first('step-3.father_qualification') }}</span>
      </div>
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-input class="w-full" label="Mother Qualification"
                  v-model="parent_local.mother_qualification"
                  v-validate="'required|max:50|min:3'"
                  name="mother_qualification"/>
        <span class="text-danger">{{ errors.first('step-3.mother_qualification') }}</span>
      </div>
    </div>

    <div class="vx-row">
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-input class="w-full" label="Father Phone No." v-model="parent_local.father_contact_number"
                  type="first_name"
                  v-validate="'required|max:13|min:10|numeric'"
                  name="father_contact_number"/>
        <span class="text-danger">{{ errors.first('step-3.father_contact_number') }}</span>
      </div>
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-input class="w-full" label="Mother Phone No." v-model="parent_local.mother_contact_number"
                  v-validate="'required|max:13|min:10|numeric'"
                  name="mother_contact_number"/>
        <span class="text-danger">{{ errors.first('step-3.mother_contact_number') }}</span>
      </div>
    </div>

    <div class="vx-row">
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-input class="w-full" label="Father Profession" v-model="parent_local.father_profession"
                  type="first_name"
                  v-validate="'required|max:50|min:1|alpha_spaces'"
                  name="father_profession"/>
        <span class="text-danger">{{ errors.first('step-3.father_profession') }}</span>
      </div>
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-input class="w-full" label="Mother Profession" v-model="parent_local.mother_profession"
                  v-validate="'max:50|min:1|alpha_spaces'"
                  name="mother_profession"/>
        <span class="text-danger">{{ errors.first('step-3.mother_profession') }}</span>
      </div>
    </div>

    <div class="vx-row">
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-input class="w-full" label="Father Designation" v-model="parent_local.father_designation"
                  type="first_name"
                  v-validate="'required|max:50|min:1|alpha_spaces'"
                  name="father_designation"/>
        <span class="text-danger">{{ errors.first('step-3.father_designation') }}</span>
      </div>
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-input class="w-full" label="Mother Designation" v-model="parent_local.mother_designation"
                  v-validate="'max:50|min:1|alpha_spaces'"
                  name="mother_designation"/>
        <span class="text-danger">{{ errors.first('step-3.mother_designation') }}</span>
      </div>
    </div>


    <div class="vx-row">
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-input class="w-full" label="Father Net Annual Income"
                  v-model="parent_local.father_net_annual_income"
                  v-validate="'required|numeric'"
                  name="father_net_annual_income"/>
        <span class="text-danger">{{ errors.first('step-3.father_net_annual_income') }}</span>
      </div>
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-input class="w-full" label="Mother Net Annual Income"
                  v-model="parent_local.mother_net_annual_income"
                  v-validate="'numeric'"
                  name="mother_net_annual_income"/>
        <span class="text-danger">{{ errors.first('step-3.mother_net_annual_income') }}</span>
      </div>
    </div>

    <div class="vx-row">
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-input class="w-full" label="Father PAN" v-model="parent_local.father_pan" type="first_name"
                  v-validate="{ required:true, regex: /^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}$/ }"
                  name="father_pan"/>
        <span class="text-danger">{{ errors.first('step-3.father_pan') }}</span>
      </div>
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-input class="w-full" label="Mother PAN" v-model="parent_local.mother_pan"
                  v-validate="{ regex: /^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}$/ }"
                  name="mother_pan"/>
        <span class="text-danger">{{ errors.first('step-3.mother_pan') }}</span>
      </div>
    </div>

    <div class="vx-row">
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-checkbox ref="is_father_alumni" name="is_father_alumni" v-validate="'required'" class="inline-flex"
                     v-model="parent_local.is_father_alumni">Is father an alumni?
        </vs-checkbox>
      </div>
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-checkbox ref="is_mother_alumni" name="is_mother_alumni" v-validate="'required'" class="inline-flex"
                     v-model="parent_local.is_mother_alumni">Is mother an alumni?
        </vs-checkbox>
      </div>
    </div>

    <div class="vx-row">
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-input class="w-full" label="Father Joining Year" v-model="parent_local.father_joining_year"
                  type="first_name"
                  v-validate.immediate="'required_if:is_father_alumni,true|numeric|digits:4'"
                  name="father_joining_year" :disabled="!parent_local.is_father_alumni"/>
        <span class="text-danger">{{ errors.first('step-3.father_joining_year') }}</span>
      </div>
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-input class="w-full" label="Father Leaving Year" v-model="parent_local.father_leaving_year"
                  v-validate.immediate="'required_if:is_father_alumni,true|numeric|digits:4'"
                  name="father_leaving_year" :disabled="!parent_local.is_father_alumni"/>
        <span class="text-danger">{{ errors.first('step-3.father_leaving_year') }}</span>
      </div>
    </div>

    <div class="vx-row">
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-input class="w-full" label="Mother Joining Year" v-model="parent_local.mother_joining_year"
                  type="first_name"
                  v-validate.immediate="'required_if:is_mother_alumni,true|numeric|digits:4'"
                  name="mother_joining_year" :disabled="!parent_local.is_mother_alumni"/>
        <span class="text-danger">{{ errors.first('step-3.mother_joining_year') }}</span>
      </div>
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-input class="w-full" label="Mother Leaving Year" v-model="parent_local.mother_leaving_year"
                  v-validate.immediate="'required_if:is_mother_alumni,true|numeric|digits:4'"
                  name="mother_leaving_year" :disabled="!parent_local.is_mother_alumni"/>
        <span class="text-danger">{{ errors.first('step-3.mother_leaving_year') }}</span>
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
  // import {Validator} from 'vee-validate';
  // import jwt from '@/http/requests/auth/jwt/index.js';

  export default {
    components: {
      FormWizard,
      TabContent,
    },
    props: {
      parent: {
        type: Object,
        required: true
      }
    },

    computed: {

      canUpdateStaff() {
        if (this.$route.params.id == this.$store.state.AppActiveUser.id) {
              return true;
        } else {
          let userRoles = this.$store.state.AppActiveUser.roles;

          userRoles.forEach(function(role) {
            if(role.name === "Super Admin") {
              //TODO: verify with super admin and other user
              console.log("Super Admin can update staff")
              return true
            }
          });
          return false;
        }
      },
      validateForm() {
        return !this.errors.any()
      }
    },

    data() {
      return {
        parent_local: JSON.parse(JSON.stringify(this.parent)),
      }
    },
    methods: {
      save_changes() {
        if (!this.validateForm) return;

        console.log(this.parent_local);

        this.$vs.loading({
          'container' : "#save",
          'scale': 0.45
        })

        this.$store.dispatch("userManagement/updateParent", this.parent_local)
          .then(() => {
            this.$vs.loading.close("#save > .con-vs-loading");

            this.$vs.notify({
              title: 'User Update',
              text: 'Parent Profile details updated!',
              iconPack: 'feather',
              icon: 'icon-alert-circle',
              color: 'success'
            })

            this.$store.dispatch("userManagement/upsertToState",
              {type: "Parent", data :this.parent_local});

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
        this.parent_local = JSON.parse(JSON.stringify(this.parent));
      }

    }

  }
</script>
