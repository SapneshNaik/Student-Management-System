<template>
  <form data-vv-scope="step-3" id="create-parent-form">

    <div class="vx-row">
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-input :disabled="read_only" class="w-full" label="Staff ID (required only if parent is a staff)"
                  v-model="parent.staff_id" type="staff_id"
                  v-validate="'max:50|min:3|numeric'"
                  name="staff_id"/>
        <span class="text-danger">{{ errors.first('step-3.staff_id') }}</span>
      </div>

    </div>

    <div class="vx-row">
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-input :disabled="read_only" class="w-full" label="Father Full Name" v-model="parent.father_full_name"
                  type="first_name"
                  v-validate="'required|max:150|min:3|alpha_spaces'"
                  name="father_full_name"/>
        <span class="text-danger">{{ errors.first('step-3.father_full_name') }}</span>
      </div>
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-input :disabled="read_only" class="w-full" label="Mother Full Name" v-model="parent.mother_full_name"
                  v-validate="'required|max:150|min:3|alpha_spaces'"
                  name="mother_full_name"/>
        <span class="text-danger">{{ errors.first('step-3.mother_full_name') }}</span>
      </div>
    </div>

    <div class="vx-row">
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-input :disabled="read_only" class="w-full" label="Father Qualification"
                  v-model="parent.father_qualification"
                  v-validate="'required|max:50|min:3'"
                  name="father_qualification"/>
        <span class="text-danger">{{ errors.first('step-3.father_qualification') }}</span>
      </div>
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-input :disabled="read_only" class="w-full" label="Mother Qualification"
                  v-model="parent.mother_qualification"
                  v-validate="'required|max:50|min:3'"
                  name="mother_qualification"/>
        <span class="text-danger">{{ errors.first('step-3.mother_qualification') }}</span>
      </div>
    </div>

    <div class="vx-row">
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-input :disabled="read_only" class="w-full" label="Father Phone No." v-model="parent.father_contact_number"
                  type="first_name"
                  v-validate="'required|max:13|min:10|numeric'"
                  name="father_contact_number"/>
        <span class="text-danger">{{ errors.first('step-3.father_contact_number') }}</span>
      </div>
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-input :disabled="read_only" class="w-full" label="Mother Phone No." v-model="parent.mother_contact_number"
                  v-validate="'required|max:13|min:10|numeric'"
                  name="mother_contact_number"/>
        <span class="text-danger">{{ errors.first('step-3.mother_contact_number') }}</span>
      </div>
    </div>

    <div class="vx-row">
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-input :disabled="read_only" class="w-full" label="Father Profession" v-model="parent.father_profession"
                  type="first_name"
                  v-validate="'required|max:50|min:1|alpha_spaces'"
                  name="father_profession"/>
        <span class="text-danger">{{ errors.first('step-3.father_profession') }}</span>
      </div>
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-input :disabled="read_only" class="w-full" label="Mother Profession" v-model="parent.mother_profession"
                  v-validate="'max:50|min:1|alpha_spaces'"
                  name="mother_profession"/>
        <span class="text-danger">{{ errors.first('step-3.mother_profession') }}</span>
      </div>
    </div>

    <div class="vx-row">
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-input :disabled="read_only" class="w-full" label="Father Designation" v-model="parent.father_designation"
                  type="first_name"
                  v-validate="'required|max:50|min:1|alpha_spaces'"
                  name="father_designation"/>
        <span class="text-danger">{{ errors.first('step-3.father_designation') }}</span>
      </div>
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-input :disabled="read_only" class="w-full" label="Mother Designation" v-model="parent.mother_designation"
                  v-validate="'max:50|min:1|alpha_spaces'"
                  name="mother_designation"/>
        <span class="text-danger">{{ errors.first('step-3.mother_designation') }}</span>
      </div>
    </div>


    <div class="vx-row">
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-input :disabled="read_only" class="w-full" label="Father Net Annual Income"
                  v-model="parent.father_net_annual_income"
                  v-validate="'required|numeric'"
                  name="father_net_annual_income"/>
        <span class="text-danger">{{ errors.first('step-3.father_net_annual_income') }}</span>
      </div>
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-input :disabled="read_only" class="w-full" label="Mother Net Annual Income"
                  v-model="parent.mother_net_annual_income"
                  v-validate="'numeric'"
                  name="mother_net_annual_income"/>
        <span class="text-danger">{{ errors.first('step-3.mother_net_annual_income') }}</span>
      </div>
    </div>

    <div class="vx-row">
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-input :disabled="read_only" class="w-full" label="Father PAN" v-model="parent.father_pan" type="first_name"
                  v-validate="{ required:true, regex: /^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}$/ }"
                  name="father_pan"/>
        <span class="text-danger">{{ errors.first('step-3.father_pan') }}</span>
      </div>
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-input :disabled="read_only" class="w-full" label="Mother PAN" v-model="parent.mother_pan"
                  v-validate="{ regex: /^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}$/ }"
                  name="mother_pan"/>
        <span class="text-danger">{{ errors.first('step-3.mother_pan') }}</span>
      </div>
    </div>

    <div class="vx-row">
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-checkbox :disabled="read_only" ref="is_father_alumni" name="is_father_alumni" v-validate="'required'" class="inline-flex"
                     v-model="parent.is_father_alumni">Is father an alumni?
        </vs-checkbox>
      </div>
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-checkbox :disabled="read_only" ref="is_mother_alumni" name="is_mother_alumni" v-validate="'required'" class="inline-flex"
                     v-model="parent.is_mother_alumni">Is mother an alumni?
        </vs-checkbox>
      </div>
    </div>

    <div class="vx-row">
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-input class="w-full" label="Father Joining Year" v-model="parent.father_joining_year" type="first_name"
                  v-validate.immediate="'required_if:is_father_alumni,true|numeric|digits:4'"
                  name="father_joining_year" :disabled="!parent.is_father_alumni || read_only"/>
        <span class="text-danger">{{ errors.first('step-3.father_joining_year') }}</span>
      </div>
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-input class="w-full" label="Father Leaving Year" v-model="parent.father_leaving_year"
                  v-validate.immediate="'required_if:is_father_alumni,true|numeric|digits:4'"
                  name="father_leaving_year" :disabled="!parent.is_father_alumni || read_only"/>
        <span class="text-danger">{{ errors.first('step-3.father_leaving_year') }}</span>
      </div>
    </div>

    <div class="vx-row">
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-input class="w-full" label="Mother Joining Year" v-model="parent.mother_joining_year" type="first_name"
                  v-validate.immediate="'required_if:is_mother_alumni,true|numeric|digits:4'"
                  name="mother_joining_year" :disabled="!parent.is_mother_alumni || read_only"/>
        <span class="text-danger">{{ errors.first('step-3.mother_joining_year') }}</span>
      </div>
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-input class="w-full" label="Mother Leaving Year" v-model="parent.mother_leaving_year"
                  v-validate.immediate="'required_if:is_mother_alumni,true|numeric|digits:4'"
                  name="mother_leaving_year" :disabled="!parent.is_mother_alumni || read_only"/>
        <span class="text-danger">{{ errors.first('step-3.mother_leaving_year') }}</span>
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
      },
      read_only: {
        type: Boolean,
        required: false,
        default: false
      }
    },
    methods: {
      validateInput() {
        return new Promise((resolve, reject) => {
          this.$validator.validateAll('step-3').then(result => {
            if (result) {
              console.log("parent form validation " + result)
              resolve(true)
            } else {
              console.log(this.errors);
              reject("correct all values");
            }

          })
        })
      }

    }

  }
</script>
