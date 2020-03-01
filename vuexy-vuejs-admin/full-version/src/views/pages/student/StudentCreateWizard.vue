<!-- =========================================================================================
  File Name: FormWizardValidation.vue
  Description: Form wizard with validation
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->


<template>
  <vx-card title="Register New Student">

    <div class="mt-5">
      <form-wizard ref="fw" v-if="!creating" color="rgba(var(--vs-primary), 1)" errorColor="rgba(var(--vs-danger), 1)"
                   :title="null"
                   :subtitle="null" finishButtonText="Submit" @on-complete="createStudent">
        <tab-content title="Account Details" class="mb-5" icon="feather icon-log-in" :before-change="validateStep1">
          <base-user-create role="Student"
                            ref="cup" :user="studentUserModel"></base-user-create>
        </tab-content>

        <!-- tab 2 content -->
        <tab-content title="Profile Details" class="mb-5" icon="feather icon-user" :before-change="validateStep2">
          <form data-vv-scope="step-2">

            <div class="vx-row">
              <div class="vx-col sm:w-1/2 w-full mb-2">
                <vs-select class="w-full" v-model="studentProfileData.prefix" label="Prefix">
                  <vs-select-item :key="index" :value="item" :text="item" v-for="(item,index) in prefixes"
                                  class="w-full"/>
                </vs-select>
                <span class="text-danger">{{ errors.first('step-2.prefixes') }}</span>
              </div>

              <div class="vx-col sm:w-1/2 w-full mb-2">
                <vs-select class="w-full" v-model="studentProfileData.gender" label="Gender">
                  <vs-select-item :key="index" :value="item" :text="item" v-for="(item,index) in genders"
                                  class="w-full"/>
                </vs-select>
                <span class="text-danger">{{ errors.first('step-2.genders') }}</span>
              </div>

            </div>

            <div class="vx-row">
              <div class="vx-col sm:w-1/3 w-full mb-2">
                <vs-input class="w-full" label="First Name" v-model="studentProfileData.first_name" type="first_name"
                          v-validate="'required|max:50|min:3|alpha'"
                          name="first_name"/>
                <span class="text-danger">{{ errors.first('step-2.first_name') }}</span>
              </div>
              <div class="vx-col sm:w-1/3 w-full mb-2">
                <vs-input class="w-full" label="Middle Name" v-model="studentProfileData.middle_name"
                          v-validate="'max:50|min:3|alpha'"
                          name="middle_name"/>
                <span class="text-danger">{{ errors.first('step-2.middle_name') }}</span>

              </div>

              <div class="vx-col sm:w-1/3 w-full mb-2">
                <vs-input class="w-full" label="Last Name" v-model="studentProfileData.last_name"
                          v-validate="'required|max:50|min:3|alpha'"
                          name="last_name"/>
                <span class="text-danger">{{ errors.first('step-2.last_name') }}</span>
              </div>

            </div>

            <div class="vx-row">
              <div class="vx-col sm:w-1/3 w-full mb-2">
                <vs-select class="w-full" v-model="studentProfileData.religion" label="Religion">
                  <vs-select-item :key="index" :value="item" :text="item" v-for="(item,index) in religions"
                                  class="w-full"/>
                </vs-select>
                <span class="text-danger">{{ errors.first('step-2.religions') }}</span>
              </div>

              <div class="vx-col sm:w-1/3 w-full mb-2">
                <vs-input class="w-full" label="Caste" v-model="studentProfileData.caste"
                          v-validate="'required|max:30|min:3|alpha'"
                          name="caste"/>
                <span class="text-danger">{{ errors.first('step-2.caste') }}</span>
              </div>

              <div class="vx-col sm:w-1/3 w-full mb-2">
                <vs-input class="w-full" label="Caste Category" v-model="studentProfileData.caste_category"
                          v-validate="'required|max:30|min:3|alpha'"
                          name="caste_category"/>
                <span class="text-danger">{{ errors.first('step-2.caste_category') }}</span>
              </div>

            </div>

            <div class="vx-row">
              <div class="vx-col sm:w-1/3 w-full mb-2">
                <vs-select class="w-full" v-model="studentProfileData.blood_group" label="Blood Group">
                  <vs-select-item :key="index" :value="item" :text="item" v-for="(item,index) in blood_groups"
                                  class="w-full"/>
                </vs-select>
                <span class="text-danger">{{ errors.first('step-2.blood_groups') }}</span>
              </div>

              <div class="vx-col sm:w-1/3 w-full mb-2">
                <vs-input class="w-full" label="Aadhaar No." v-model="studentProfileData.aadhaar_no"
                          v-validate="'required|digits:12|numeric'"
                          name="aadhaar_no"/>
                <span class="text-danger">{{ errors.first('step-2.aadhaar_no') }}</span>
              </div>

              <div class="vx-col sm:w-1/3 w-full mb-2">
                <vs-input class="w-full" label="Passport No." v-model="studentProfileData.passport_no"
                          v-validate="'max:50|min:3'"
                          name="passport_no"/>
                <span class="text-danger">{{ errors.first('step-2.passport_no') }}</span>
              </div>

            </div>
          </form>
        </tab-content>

        <!-- tab 3 content -->
        <tab-content title="Parent Details" class="mb-5" icon="feather icon-shield"
                     :before-change="validateStep3">

          <vx-card title="Parent Profile Exists for the Student?" class="mb-base">
            <ul class="centerx">
              <li class="mb2">
                <vs-radio color="success" v-model="parentExists" vs-value="true">Yes</vs-radio>
              </li>
              <li class="mb2">
                <vs-radio color="danger" v-model="parentExists" vs-value="false">No</vs-radio>
              </li>
            </ul>

          </vx-card>

          <vx-card v-if='parentExists === "true"' title="Parent Account Details" class="mb-base">
            <vue-simple-suggest
              pattern="\w+"
              v-model="parent_string"
              :list="searchParents"
              :max-suggestions="10"
              :min-length="2"
              :debounce="200"
              :filter-by-query="false"
              :prevent-submit="true"
              :controls="{
                  selectionUp: [38, 33],
                  selectionDown: [40, 34],
                  select: [13, 36],
                  hideList: [27, 35]
                }"
              :nullable-select="true"
              ref="suggestComponent"
              placeholder="Search information..."
              value-attribute="id"
              display-attribute="email"
              @select="onParentSelect">

              <div class="g">
                <input type="text">
              </div>

              <template slot="misc-item-above" slot-scope="{ suggestions, query }">
                <div class="misc-item">
                  <span>You're searching for '{{ query }}'.</span>
                </div>

                <template v-if="suggestions.length > 0">
                  <div class="misc-item">
                    <span>{{ suggestions.length }} suggestions are shown...</span>
                  </div>
                  <hr>
                </template>

                <div class="misc-item" v-else-if="!loading">
                  <span>No results</span>
                </div>
              </template>

              <div slot="suggestion-item" slot-scope="scope" :title="scope.suggestion.description">
                <div class="text">
                  <span v-html="boldenSuggestion(scope)"></span>
                </div>
              </div>

              <div class="misc-item" slot="misc-item-below" slot-scope="{ suggestions }" v-if="loading">
                <span>Loading...</span>
              </div>
            </vue-simple-suggest>

            <span class="text-danger">{{ noParentSelectedError }}</span>

          </vx-card>

          <vx-card v-if='parentExists === "false" || parentUserModel.id' title="Parent Account Details" class="mb-base">
            <base-user-create role="Parent" :user="parentUserModel"
                                 :read_only="!!(parentUserModel.id)"
                                 ref="parent_cup"></base-user-create>
          </vx-card>

          <vx-card v-if='parentExists === "false" || parentProfile.user_id' title="Parent Profile Details"
                   class="mb-base">
            <parent-create-form :parent="parentProfile"
                                :read_only="!!(parentProfile.user_id)"
                                ref="pcf"></parent-create-form>
          </vx-card>

        </tab-content>
      </form-wizard>
    </div>

    <div class="vx-col w-full" id="create_progress" v-if="creating">

      <vx-card title="Creating Student" class="mb-base">
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
  import ParentCreateForm from "../parent/ParentCreateForm";
  import VueSimpleSuggest from 'vue-simple-suggest';
  import 'vue-simple-suggest/dist/styles.css'
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
      ParentCreateForm,
      FormWizard,
      TabContent,
      BaseUserCreate,
      VueSimpleSuggest
    },
    data() {
      return {
        parentExists: "true",
        noParentSelectedError: '',

        prefixes: constants.PREFIXES,
        genders: constants.GENDER,
        religions: constants.RELIGIONS,
        blood_groups: constants.BLOOD_GROUP,

        parent_string: null,

        studentProfileData: this.getBaseStudentProfile(),

        parentUserModel: commons.getBaseUserModel("Parent"),

        studentUserModel: commons.getBaseUserModel("Student"),

        parentProfile: commons.getBaseParentProfile(),

        creating: false,
        progress: 0,
        progressMessage: "",
        progressTextClass: "text-success",
        progressColor: "success",

        loading: false
      }
    },
    watch: {

      parentExists: {
        handler: function (val) {
          if (val === "false") {
            this.resetParentData()
          }
        }
      },

      progress: function (val) {
        console.log("Progress is " + val)
        if (val >= 100) {

          this.$vs.notify({
            title: 'Student Created',
            text: this.studentProfileData.first_name + " is added to the system",
            iconPack: 'feather',
            icon: 'icon-alert-circle',
            position: 'top-right',
            color: 'success'
          });

          console.log(this.$refs);
          this.creating = false;

          this.resetProgress();
          this.resetData();
        }
      }
    },
    methods: {

      getBaseStudentProfile() {
        return {
          prefix: constants.PREFIXES[0],
          parent_id: '',
          first_name: "",
          middle_name: "",
          last_name: "",
          gender: constants.GENDER[0],
          religion: constants.RELIGIONS[0],
          caste: '',
          caste_category: '',
          blood_group: constants.BLOOD_GROUP[0],
          aadhaar_no: '',
          passport_no: '',
        }
      },


      resetData() {
        this.studentProfileData = this.getBaseStudentProfile()
        this.parentUserModel = commons.getBaseUserModel("Parent");
        this.studentUserModel = commons.getBaseUserModel("Student");
        this.parentProfile = commons.getBaseParentProfile()
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
        if (this.parentExists === "true" && !this.parentUserModel.id) {
          this.noParentSelectedError = "Please search and select a Parent";
          return false;
        } else if (this.parentExists === "false") {

          return this.$refs.parent_cup.validateInput() && this.$refs.pcf.validateInput()
          // return Promise.all([this.$refs.parent_ucf.validateInput(), this.$refs.pcf.validateInput()])
          //   .then((result) => {
          //       result.forEach((result) => {
          //         if(!result) return false;
          //       });
          //       return true;
          //   });

        } else if (this.parentExists === "true" && this.parentUserModel.id) {
          return true;
        }

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

      createStudent() {

        this.creating = true;

        // create student user
        // create parent if not exists
        // create student profile

        let numOfRequests = 2 + (this.parentProfile.user_id ? 0 : 2);

        let progressIncrementStep = 100 / numOfRequests;

        this.progressUpdate("Creating Student Base Profile...", 0);

        jwt.createUser(this.studentUserModel)
          .then((userResponse) => {

            if (!this.parentProfile.user_id) {
              console.log("Creating new parent")
              this.progressUpdate("Creating Parent User Profile...", progressIncrementStep);

              jwt.createUser(this.parentUserModel)
                .then((userParentResponse) => {
                  this.progressUpdate("Creating Parent Profile...", progressIncrementStep);

                  jwt.createParentProfile(userParentResponse.data.user.id, this.parentProfile)
                    .then((userParentProfileResponse) => {

                      userParentProfileResponse.data['parent']['user'] = userParentResponse.data.user;

                      this.$store.dispatch("userManagement/upsertToState",
                        {type: "Parent", data: userParentProfileResponse.data.parent});


                      this.progressUpdate("Creating Student Profile...", progressIncrementStep);

                      console.log(userParentProfileResponse);

                      this.studentProfileData.parent_id = userParentResponse.data.user.id;

                      this.createStudentProfile(userResponse, this.studentProfileData, progressIncrementStep)

                    })
                    .catch((error) => {
                      this.progressError("Failed to create  Parent User profile", error);
                      console.log(error)
                    });

                })
                .catch((error) => {
                  this.progressError("Failed to create  Parent User profile", error);
                  console.log(error)
                })
            } else {

              this.progressUpdate("Creating Student Profile...", progressIncrementStep);

              this.studentProfileData.parent_id = this.parentProfile.user_id;

              this.createStudentProfile(userResponse, this.studentProfileData, progressIncrementStep)
            }

          })
          .catch((error) => {
            this.progressError("Failed to create User profile", error);
            console.log(error)
          })


      },

      createStudentProfile(userResponse, data, progressIncrementStep) {
        return new Promise((resolve, reject) => {

          jwt.createStudentProfile(userResponse.data.user.id, data).then((studResponse) => {
            this.progressUpdate("Student Created!", progressIncrementStep);
            studResponse.data['student']['user'] = userResponse.data.user;

            this.$store.dispatch("userManagement/upsertToState",
              {type: "Student", data: studResponse.data.student});

            resolve(studResponse)
          }).catch((error) => {
            this.progressError("Failed to create Student profile", error);
            console.log(error)
            reject(error)
          })
        });
      },

      searchParents(inputValue) {
        this.loading = true

        return new Promise((resolve, reject) => {
          jwt.getParentSearch(inputValue).then(response => {
            resolve(response.data)
          }).catch(error => {
            this.loading = false

            this.$vs.notify({
              title: 'Error',
              text: error.message,
              iconPack: 'feather',
              icon: 'icon-alert-circle',
              color: 'danger'
            });

            reject(error)
          })
        });
      },

      onParentSelect(suggest) {

        this.noParentSelectedError = "";

        this.parentUserModel = suggest;
        console.log(suggest);

        this.$vs.loading();

        jwt.getParent(suggest.id).then(response => {
          this.parentProfile = response.data;
          this.$vs.loading.close()

        }).catch(error => {
          this.$vs.notify({
            title: 'Error',
            text: error.message,
            iconPack: 'feather',
            icon: 'icon-alert-circle',
            color: 'danger'
          });
        });
      },

      boldenSuggestion(scope) {
        if (!scope) return scope;
        const {suggestion, query} = scope;
        let result = this.$refs.suggestComponent.displayProperty(suggestion);
        if (!query) return result;
        const texts = query.split(/[\s-_/\\|.]/gm).filter(t => !!t) || [''];
        return result.replace(new RegExp('(.*?)(' + texts.join('|') + ')(.*?)', 'gi'), '$1<b>$2</b>$3');
      },

      resetParentData() {
        Object.keys(this.parentUserModel).forEach((index) => {
          if (index !== "base_role") {
            this.parentUserModel[index] = ''
          }
        });

        Object.keys(this.parentProfile).forEach((index) => {
          if (index !== "is_father_alumni" && index !== "is_mother_alumni") {
            this.parentProfile[index] = ''
          }
        });
      },

    },
  }
</script>

<style lang="scss">
  @import "@/assets/scss/vuexy/extraComponents/autocomplete.scss";
</style>
