<template>
  <vx-card title="Register New Staff">

    <div class="mt-5">
      <form-wizard ref="fw" v-if="!creating" color="rgba(var(--vs-primary), 1)" errorColor="rgba(var(--vs-danger), 1)"
                   :title="null"
                   :subtitle="null" finishButtonText="Submit" @on-complete="createStaff">
        <tab-content title="Account Details" class="mb-5" icon="feather icon-log-in" :before-change="validateStep1">
          <base-user-create role="Student" ref="cup" :user="staffUserModel"></base-user-create>
        </tab-content>

        <!-- tab 2 content -->
        <tab-content title="Profile Details" class="mb-5" icon="feather icon-user" :before-change="validateStep2">
          <form data-vv-scope="step-2">

            <div class="vx-row">
              <div class="vx-col sm:w-1/2 w-full mb-2">
                <vs-select class="w-full" v-model="staffProfileData.prefix" label="Prefix">
                  <vs-select-item :key="index" :value="item" :text="item" v-for="(item,index) in prefixes"
                                  class="w-full"/>
                </vs-select>
                <span class="text-danger">{{ errors.first('step-2.prefixes') }}</span>
              </div>

              <div class="vx-col sm:w-1/2 w-full mb-2">
                <vs-select class="w-full" v-model="staffProfileData.gender" label="Gender">
                  <vs-select-item :key="index" :value="item" :text="item" v-for="(item,index) in genders"
                                  class="w-full"/>
                </vs-select>
                <span class="text-danger">{{ errors.first('step-2.genders') }}</span>
              </div>

            </div>

            <div class="vx-row">
              <div class="vx-col sm:w-1/3 w-full mb-2">
                <vs-input class="w-full" label="First Name" v-model="staffProfileData.first_name" type="first_name"
                          v-validate="'required|max:50|min:3|alpha'"
                          name="first_name"/>
                <span class="text-danger">{{ errors.first('step-2.first_name') }}</span>
              </div>
              <div class="vx-col sm:w-1/3 w-full mb-2">
                <vs-input class="w-full" label="Middle Name" v-model="staffProfileData.middle_name"
                          v-validate="'max:50|min:3|alpha'"
                          name="middle_name"/>
                <span class="text-danger">{{ errors.first('step-2.middle_name') }}</span>

              </div>

              <div class="vx-col sm:w-1/3 w-full mb-2">
                <vs-input class="w-full" label="Last Name" v-model="staffProfileData.last_name"
                          v-validate="'required|max:50|min:3|alpha'"
                          name="last_name"/>
                <span class="text-danger">{{ errors.first('step-2.last_name') }}</span>
              </div>

            </div>

            <div class="vx-row">
              <div class="vx-col sm:w-1/2 w-full mb-2">
                <vs-input class="w-full" label="Aadhaar No." v-model="staffProfileData.aadhaar_no"
                          v-validate="'required|digits:12|numeric'"
                          name="aadhaar_no"/>
                <span class="text-danger">{{ errors.first('step-2.aadhaar_no') }}</span>
              </div>

              <div class="vx-col sm:w-1/2 w-full mb-2">
                <vs-input class="w-full" label="Passport No." v-model="staffProfileData.passport_no"
                          v-validate="'max:50|min:3'"
                          name="passport_no"/>
                <span class="text-danger">{{ errors.first('step-2.passport_no') }}</span>
              </div>

            </div>
          </form>
        </tab-content>

        <tab-content title="Roles and Permissions" class="mb-5" icon="feather icon-shield"
                     :before-change="validateStep3">
          <role-assign ref="rsa"></role-assign>
        </tab-content>

      </form-wizard>
    </div>

    <div class="vx-col w-full" id="create_progress" v-if="creating">

      <vx-card title="Creating Staff" class="mb-base">
        <span :class="progressTextClass">{{ progressMessage }}</span>
        <vs-progress :height="10" :percent="progress" :color="progressColor"></vs-progress>
      </vx-card>
    </div>

  </vx-card>
</template>

<script>
  import {FormWizard, TabContent} from 'vue-form-wizard'
  import 'vue-form-wizard/dist/vue-form-wizard.min.css'
  import BaseUserCreate from "../user/BaseUserCreate";
  import constants from "../../../constants";
  import {Validator} from 'vee-validate';
  import jwt from '@/http/requests/auth/jwt/index.js';
  import 'vue-simple-suggest/dist/styles.css'
  import commons from "../../../commons";
  import RoleAssign from "../role_permission/RoleAssign";

  const dict = {
    custom: {
      first_name: {
        required: 'First name is required',
        alpha: "First name may only contain alphabetic characters"
      },
      last_name: {
        required: 'Last name is required',
        alpha: "Last name may only contain alphabetic characters"
      },
    }
  };

  // register custom messages
  Validator.localize('en', dict);

  export default {
    components: {
      FormWizard,
      TabContent,
      BaseUserCreate,
      RoleAssign
    },
    data() {
      return {

        prefixes: constants.PREFIXES,
        genders: constants.GENDER,

        staffProfileData: this.getBaseStaffProfile(),

        staffUserModel: commons.getBaseUserModel("Staff"),

        creating: false,
        progress: 0,
        progressMessage: "",
        progressTextClass: "text-success",
        progressColor: "success",

      }
    },
    watch: {
      progress: function (val) {
        console.log("Progress is " + val);
        if (val >= 100) {

          this.$vs.notify({
            title: 'Staff Created',
            text: this.staffProfileData.first_name + " is added to the system",
            iconPack: 'feather',
            icon: 'icon-alert-circle',
            position:'top-right',
            color: 'success'
          });

          this.creating = false;

          this.resetProgress();
          this.resetData();
        }
      }
    },
    methods: {

      getBaseStaffProfile() {
        return {
          prefix: constants.PREFIXES[0],
          first_name: "",
          middle_name: "",
          last_name: "",
          gender: constants.GENDER[0],
          aadhaar_no: '',
          passport_no: '',
        }
      },

      resetData() {
        this.staffProfileData = this.getBaseStaffProfile();
        this.staffUserModel = commons.getBaseUserModel("Student");
      },

      resetProgress() {
        this.progress = 0;
        this.progressMessage = "";
        this.progressTextClass = "text-success";
        this.progressColor = "success"
      },

      validateStep1() {
        return this.$refs.cup.validateInput();
      },

      validateStep2() {
        return new Promise((resolve, reject) => {
          this.$validator.validateAll("step-2").then(result => {
            if (result) {
              resolve(true)
            } else {
              reject("correct all values");
            }
          })
        })
      },

      validateStep3() {
        this.$refs.rsa.validatePassword();
        return (!(this.$refs.rsa.assignedRoles.length > 0 && !this.$refs.rsa.password));
      },

      progressError(message, error) {
        this.progressMessage = message;
        this.progressColor = "danger";
        this.progressTextClass = "text-danger";
        // this.creating= false;

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

        this.creating = false;

        this.resetProgress()
      },

      progressUpdate(message, step) {
        this.progressMessage = message;
        this.progress += step;
      },

      createStaff() {

        this.creating = true;

        let roleData = this.$refs.rsa.assignedRoles;
        let authPassword = this.$refs.rsa.password;

        let numOfRequests = 2 + roleData.length;
        let progressIncrementStep = 100 / numOfRequests;

        this.progressUpdate("Creating Staff Base Profile...", 0);

        jwt.createUser(this.staffUserModel)
          .then((userResponse) => {

            this.progressUpdate("Creating Staff Profile...", progressIncrementStep);

            jwt.createStaffProfile(userResponse.data.user.id, this.staffProfileData)
              .then((staffResponse) => {

                staffResponse.data['staff']['user'] = userResponse.data.user;

                this.$store.dispatch("userManagement/upsertToState",
                  {type: "Staff", data :staffResponse.data.staff});

                this.progressUpdate("Assigning roles to Staff...", progressIncrementStep);

                //assigning roles
                roleData.forEach(async (role) => {``
                  try {
                    let roleAssignmentResponse = await jwt.assignRoleToUser(userResponse.data.user.id, role.id, authPassword);
                    // const data = await roleAssignmentResponse;
                    console.log(roleAssignmentResponse);
                    this.progressUpdate("Assigned \"" + role.name + "\" role to " + this.staffProfileData.first_name, progressIncrementStep);
                  } catch (e) {
                    this.progressError("Failed to assign " + role.name + " role to " + this.staffProfileData.first_name, e);
                    console.log(e)
                  }
                })

              })
              .catch((error) => {
                this.progressError("Failed to create Staff profile", error);
                console.log(error)
              })

          })
          .catch((error) => {
            this.progressError("Failed to create User profile", error);
            console.log(error)
          })
      },
    },
  }
</script>
