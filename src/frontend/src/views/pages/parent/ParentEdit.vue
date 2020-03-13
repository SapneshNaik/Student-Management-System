<template>
  <form data-vv-scope="step-3" id="create-parent-form">

    <div class="vx-row">
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <input v-model="parent_local.staff_linked_id" type="hidden" name="staff_linked_id"/>

        <vue-simple-suggest
          pattern="\w+"
          :list="searchStaffs"
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
          mode="select"
          @select="onStaffSelect">

          <div class="g">
            <input v-model="parent_search_string" placeholder="Linked Staff" type="text">
          </div>

          <template slot="misc-item-above" slot-scope="{ suggestions, query }">
            <div class="misc-item">
              <span>You're searching for '{{ query }}'.</span>
            </div>

            <template v-if="suggestions.length > 0">
              <div class="misc-item">
                <span>{{ suggestions.length }} staffs profiles found...</span>
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

        <span class="text-danger">{{ errors.first('step-3.staff_linked_id') }}</span>

        <vs-popup class="holamundo" title="Please Confirm if the Staff is Correct"
                  :active.sync="staffDetailPopupActive">
          <vs-avatar class="mx-auto mb-6 block" size="80px" :src="'https://i.pravatar.cc/200?u='+staff_user.login_id"/>
          <div class="text-center">
            <h4>{{ staff_user.name }}</h4>
            <p class="text-grey">{{ staff_user.phone_number }}</p>
            <p class="text-grey">{{ staff_user.email }}</p>
          </div>
          <template slot="footer">
            <vs-divider/>
            <div class="flex justify-between">
                            <span class="flex items-center">
                                <feather-icon icon="icon-delete" svgClasses="h-5 w-5 text-warning stroke-current"/>
                                <span class="ml-2">{{ staff_user.base_role }}</span>
                            </span>
              <span class="flex items-center">
                                <feather-icon icon="icon-delete" svgClasses="h-5 w-5 text-primary stroke-current"/>
                                <span class="ml-2">{{ staff_user.last_updated_by }}</span>
                            </span>
            </div>
          </template>
        </vs-popup>

      </div>

      <div class="vx-col sm:w-1/2 w-full mb-2">

        <vs-button v-if="parent_local.staff_linked_id"
                   @click="parent_search_string = ''; parent_local.staff_linked_id = null "
                   color="danger" type="filled"
                   icon-pack="feather" icon="icon-delete">Clear Selected Staff
        </vs-button>
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
        <!--        <vs-input class="w-full" label="Father Qualification"-->
        <!--                  v-model="parent_local.father_qualification"-->
        <!--                  v-validate="'required|max:50|min:3'"-->
        <!--                  name="father_qualification"/>-->
        <!--        <span class="text-danger">{{ errors.first('step-3.father_qualification') }}</span>-->

        <vs-select class="w-full" v-model="parent_local.father_qualification"
                   label="Father Qualification"
                   name="father_qualification"
                   v-validate="'required'">
          <vs-select-item :key="index" :value="item" :text="item" v-for="(item,index) in qualifications"
                          class="w-full"/>
        </vs-select>
        <span class="text-danger">{{ errors.first('step-3.father_qualification') }}</span>


      </div>
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <!--        <vs-input class="w-full" label="Mother Qualification"-->
        <!--                  v-model="parent_local.mother_qualification"-->
        <!--                  v-validate="'required|max:50|min:3'"-->
        <!--                  name="mother_qualification"/>-->
        <!--        <span class="text-danger">{{ errors.first('step-3.mother_qualification') }}</span>-->

        <vs-select class="w-full"
                   v-model="parent_local.mother_qualification"
                   label="Mother Qualification"
                   name="mother_qualification"
                   v-validate="'required'">
          <vs-select-item :key="index" :value="item" :text="item" v-for="(item,index) in qualifications"
                          class="w-full"/>
        </vs-select>
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
        <!--        <vs-input class="w-full" label="Father Profession" v-model="parent_local.father_profession"-->
        <!--                  type="first_name"-->
        <!--                  v-validate="'required|max:50|min:1|alpha_spaces'"-->
        <!--                  name="father_profession"/>-->
        <!--        <span class="text-danger">{{ errors.first('step-3.father_profession') }}</span>-->

        <vs-select class="w-full" v-model="parent_local.father_profession"
                   label="Father Profession"
                   name="father_profession"
                   v-validate="'required'">
          <vs-select-item :key="index" :value="item" :text="item" v-for="(item,index) in professions"
                          class="w-full"/>
        </vs-select>
        <span class="text-danger">{{ errors.first('step-3.father_profession') }}</span>


      </div>
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <!--        <vs-input class="w-full" label="Mother Profession" v-model="parent_local.mother_profession"-->
        <!--                  v-validate="'max:50|min:1|alpha_spaces'"-->
        <!--                  name="mother_profession"/>-->
        <!--        <span class="text-danger">{{ errors.first('step-3.mother_profession') }}</span>-->

        <vs-select class="w-full" v-model="parent_local.mother_profession"
                   label="Mother Profession"
                   name="mother_profession"
                   v-validate="'required'">
          <vs-select-item :key="index" :value="item" :text="item" v-for="(item,index) in professions"
                          class="w-full"/>
        </vs-select>
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
        <vs-input class="w-full" label="Mother Joining Year" v-model="parent_local.mother_joining_year"
                  type="first_name"
                  v-validate.immediate="'required_if:is_mother_alumni,true|numeric|digits:4'"
                  name="mother_joining_year" :disabled="!parent_local.is_mother_alumni"/>
        <span class="text-danger">{{ errors.first('step-3.mother_joining_year') }}</span>
      </div>
    </div>
    <div class="vx-row">
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-input class="w-full" label="Father Leaving Year" v-model="parent_local.father_leaving_year"
                  v-validate.immediate="'required_if:is_father_alumni,true|numeric|digits:4'"
                  name="father_leaving_year" :disabled="!parent_local.is_father_alumni"/>
        <span class="text-danger">{{ errors.first('step-3.father_leaving_year') }}</span>
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
  import constants from "../../../constants";
  import jwt from "../../../http/requests/auth/jwt";
  import VueSimpleSuggest from "vue-simple-suggest";
  import commons from "../../../commons";


  export default {
    components: {
      FormWizard,
      TabContent,
      VueSimpleSuggest
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

          userRoles.forEach(function (role) {
            if (role.name === "Super Admin") {
              //TODO: verify with super admin and other user
              console.log("Super Admin can update staff")
              return true
            }
          });
          return false;
        }
      },
      validateForm() {
        return !this.errors.any();
      }
    },

    data() {
      return {
        parent_local: JSON.parse(JSON.stringify(this.parent)),
        qualifications: constants.QUALIFICATION,
        professions: constants.PROFESSION,
        suggest: {},
        staff_user: commons.getBaseUserModel("Staff"),
        parent_search_string: '',
        loading: true,
        staffDetailPopupActive: false,
      }
    },
    mounted() {
      if (this.parent_local.linked_staff) {
        this.parent_local.staff_linked_id = this.parent_local.linked_staff.user.login_id;
        this.parent_search_string = this.parent_local.linked_staff.user.name;
      }
    },
    methods: {
      save_changes() {
        if (!this.validateForm) return;

        this.$vs.loading({
          'container': "#save",
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
              {type: "Parent", data: this.parent_local});

            if (this.parent_local.user_id == this.$store.state.AppActiveUser.id) {
              const name = {
                user: {
                  name: this.$_.startCase(this.parent_local.father_full_name)
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

              if (errors.length < 30) {
                errors.forEach((error) => {
                  this.$vs.notify({
                    title: 'Error',
                    text: error,
                    iconPack: 'feather',
                    icon: 'icon-alert-circle',
                    color: 'danger'
                  })
                });
              }
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
        this.parent_search_string = '';
        this.staff_user = commons.getBaseUserModel("Staff");
      },

      searchStaffs(inputValue) {
        this.loading = true;

        return new Promise((resolve, reject) => {
          jwt.getStaffSearch(inputValue).then(response => {
            resolve(response.data)
          }).catch(error => {
            this.loading = false;

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

      onStaffSelect(suggest) {
        if (suggest) {
          if (suggest.staff.linked_parent_id != null) {

            this.$vs.dialog({
              color: 'danger',
              title: 'Staff Linking Unavailable',
              text: 'The selected staff profile is already linked to a parent',
            });

            this.parent_search_string = ''

          } else {
            this.parent_local.staff_linked_id = suggest.login_id;
            this.staffDetailPopupActive = true;
            this.parent_search_string = suggest.name;
            this.staff_user = suggest;
          }
        }
      },

      boldenSuggestion(scope) {
        if (!scope) return scope;
        const {suggestion, query} = scope;
        let result = this.$refs.suggestComponent.displayProperty(suggestion);
        if (!query) return result;
        const texts = query.split(/[\s-_/\\|.]/gm).filter(t => !!t) || [''];
        return result.replace(new RegExp('(.*?)(' + texts.join('|') + ')(.*?)', 'gi'), '$1<b>$2</b>$3');
      },

    }

  }


</script>
