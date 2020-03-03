<!-- =========================================================================================
  File Name: FormWizardValidation.vue
  Description: Form wizard with validation
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->


<template>
  <vx-card title="Register New Admin">

    <div class="mt-5">
      <form-wizard ref="fw" v-if="!creating" color="rgba(var(--vs-primary), 1)" errorColor="rgba(var(--vs-danger), 1)"
                   :title="null"
                   :subtitle="null" finishButtonText="Submit" @on-complete="createAdmin">
        <tab-content title="Account Details" class="mb-5" icon="feather icon-log-in" :before-change="validateStep1">
          <base-user-create role="Admin" :user="userData" ref="cup"></base-user-create>
        </tab-content>

        <!-- tab 2 content -->
        <tab-content title="Profile Details" class="mb-5" icon="feather icon-user" :before-change="validateStep2">
          <form data-vv-scope="step-2">
            <div class="vx-row">
              <div class="vx-col md:w-1/2 w-full mt-5">
                <vs-select v-model="adminData.prefix" label="Prefix">
                  <vs-select-item :key="index" :value="item" :text="item" v-for="(item,index) in prefixes"
                                  class="w-full"/>
                </vs-select>
                <span class="text-danger">{{ errors.first('step-2.prefixes') }}</span>
              </div>

            </div>


            <div class="vx-row">
              <div class="vx-col md:w-1/2 w-full mt-5">

                <vs-input class="w-full mt-4" label="First Name" v-model="adminData.first_name"
                          v-validate="'required|max:50|min:3|alpha'"
                          name="first_name"/>
                <span class="text-danger">{{ errors.first('step-2.first_name') }}</span>


              </div>

              <div class="vx-col md:w-1/2 w-full mt-5">
                <vs-input class="w-full mt-4" label="Last Name" v-model="adminData.last_name"
                          v-validate="'required|max:50|min:3|alpha'"
                          name="last_name"/>
                <span class="text-danger">{{ errors.first('step-2.last_name') }}</span>
              </div>
            </div>

          </form>
        </tab-content>

        <!-- tab 3 content -->
        <tab-content title="Roles and Permissions" class="mb-5" icon="feather icon-shield"
                     :before-change="validateStep3">
          <role-assign ref="rsa"></role-assign>
        </tab-content>
      </form-wizard>
    </div>

    <div class="vx-col w-full" id="create_progress" v-if="creating">

      <vx-card title="Creating Admin" class="mb-base">
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
  import RoleAssign from "../role_permission/RoleAssign";
  import constants from "../../../constants";
  import {Validator} from 'vee-validate';
  import jwt from '@/http/requests/auth/jwt/index.js';
  import commons from "../../../commons";


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


        creating: false,
        progress: 0,
        progressMessage: "",
        progressTextClass: "text-success",
        progressColor: "success",

        userData: commons.getBaseUserModel("Admin"),
        adminData: this.getBaseAdminData(),

      }
    },
    watch: {
      progress: function (val) {
        console.log("Progress is " + val)
        if (val >= 100) {

          this.$vs.notify({
            title: 'Admin Created',
            text: this.adminData.first_name + " is added to the system",
            iconPack: 'feather',
            icon: 'icon-alert-circle',
            color: 'success',
            position: 'top-right'
          });

          this.creating = false;

          this.adminData = this.getBaseAdminData();
          this.userData = commons.getBaseUserModel("Admin");

          this.resetProgress();
        }
      }
    },
    methods: {

      getBaseAdminData() {
        return {
          first_name: "",
          last_name: "",
          prefix: constants.PREFIXES[0],
        }
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
              color: 'danger',
              position: 'top-right',

            })
          });
        } else {
          this.$vs.notify({
            title: 'Error',
            text: error.message,
            iconPack: 'feather',
            icon: 'icon-alert-circle',
            color: 'danger',
            position: 'top-right',

          })
        }

        this.creating = false;

        this.resetProgress()
      },

      progressUpdate(message, step) {
        this.progressMessage = message;
        this.progress += step;
      },

      createAdmin() {

        this.creating = true;

        let roleData = this.$refs.rsa.assignedRoles;

        let authPassword = this.$refs.rsa.password;

        let numOfRequests = 2 + roleData.length;
        let progressIncrementStep = 100 / numOfRequests;

        this.progressUpdate("Creating Admin Base Profile...", 0);

        jwt.createUser(this.userData)
          .then((userResponse) => {

            this.progressUpdate("Creating Admin Profile...", progressIncrementStep);

            jwt.createAdminProfile(userResponse.data.user.id, this.adminData)
              .then((adminResponse) => {

                adminResponse.data['admin']['user'] = userResponse.data.user;

                this.$store.dispatch("userManagement/upsertToState",
                  {type: "Admin", data: adminResponse.data.admin});

                this.progressUpdate("Assigning roles to Admin...", progressIncrementStep);

                //assigning roles
                roleData.forEach(async (role) => {
                  try {
                    let roleAssignmentResponse = await jwt.assignRoleToUser(userResponse.data.user.id, role.id, authPassword);
                    // const data = await roleAssignmentResponse;
                    console.log(roleAssignmentResponse);
                    this.progressUpdate("Assigned \"" + role.name + "\" role to " + this.adminData.first_name, progressIncrementStep);
                  } catch (e) {
                    this.progressError("Failed to assign " + role.name + " role to " + this.adminData.first_name, e);
                    console.log(e)
                  }
                })

              })
              .catch((error) => {
                this.progressError("Failed to create Admin profile", error);
                console.log(error)
              })

          })
          .catch((error) => {
            this.progressError("Failed to create User profile", error);
            console.log(error)
          })
      }
    },
  }
</script>
