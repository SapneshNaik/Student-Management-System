<!-- =========================================================================================
  File Name: UserEdit.vue
  Description: User Edit Page
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->

<template>
  <div id="page-user-profile-edit">

    <vx-card>

      <div slot="no-body" class="tabs-container px-6 pt-6">

        <vs-tabs v-model="activeTab" class="tab-action-btn-fill-conatiner">
          <vs-tab label="Account" icon-pack="feather" icon="icon-lock" v-if="accountTab">
            <div class="tab-text" v-if="user_data">
              <base-user-edit class="mt-4" :data="user_data"/>
            </div>
          </vs-tab>
          <vs-tab label="Profile" icon-pack="feather" icon="icon-user" v-if="profileTab">
            <div class="tab-text" v-if="user_data.base_role === 'Admin' && profile_data">
              <admin-edit class="mt-4" :data="profile_data"/>
            </div>

            <div class="tab-text" v-if="user_data.base_role === 'Parent' && profile_data">
              <parent-edit class="mt-4" :parent="profile_data" ref="pcf"></parent-edit>
            </div>

            <div class="tab-text" v-if="user_data.base_role === 'Student' && profile_data">
              <student-edit class="mt-4" :student="profile_data" ref="pcf"/>
            </div>

            <div class="tab-text" v-if="user_data.base_role === 'Staff' && profile_data">
              <staff-edit class="mt-4" :staff="profile_data" ref="pcf"/>
            </div>


          </vs-tab>
          <vs-tab label="Address" icon-pack="feather" icon="icon-map-pin" v-if="addressTab">
            <div class="tab-text" v-if="address_data">
              <user-edit-tab-social class="mt-4" :data="address_data"/>
            </div>
          </vs-tab>

          <vs-tab label="Roles" icon-pack="feather" icon="icon-shield" v-if="roleTab">
            <div class="tab-text">
              <user-role-edit class="mt-4" :data="role_data" ref="ure"/>

            </div>
          </vs-tab>

        </vs-tabs>

      </div>

    </vx-card>
  </div>
</template>

<script>
  import UserEditTabSocial from "./UserEditTabSocial.vue"
  import commons from "../../../commons";
  import AdminEdit from "../admin/AdminEdit";
  import ParentEdit from "../parent/ParentEdit";
  import BaseUserEdit from "./BaseUserEdit";
  import StudentEdit from "../student/StudentEdit";
  import StaffEdit from "../staff/StaffEdit";
  import UserRoleEdit from "../role_permission/UserRoleEdit";

  // Store Module

  export default {
    components: {
      UserEditTabSocial,
      AdminEdit,
      ParentEdit,
      BaseUserEdit,
      StudentEdit,
      StaffEdit,
      UserRoleEdit
    },
    props: {
      role: {
        type: String,
        required: false,
        default: null
      },
    },
    data() {
      return {

        address_data: {
          "Address": "#168, Mahadevapura",
          "Pin Code": "580025",
          "City": "Hubli",
          "District": "Dharwad",
          'State': 'Karnataka',
          'Nationality': 'Indian'
        },

        all_user_data: null,


        // accountTab: false,
        // profileTab: false,
        // addressTab: false,
        user_not_found: false,

        /*
          This property is created for fetching latest data from API when tab is changed

          Please check it's watcher
        */
        activeTab: 0,

      }
    },
    computed: {
      profile_data() {
        if (this.all_user_data) {
          return this.$_.omit(this.all_user_data, ['user']);
        } else {
          return {};
        }
      },

      user_data() {
        if (this.all_user_data) {

          return this.all_user_data.user;
        } else {
          return {};
        }
      },

      role_data() {

        if (this.all_user_data) {
          return this.all_user_data.user.roles;
        } else {
          return {};
        }

      },

      accountTab: function () {
        return true;
      },

      profileTab: function () {
        return true;
      },

      addressTab: function () {
        // return (this.address_data !== undefined);
        return true;
      },

      roleTab: function () {
        return ["Admin", "Staff"].includes(this.user_data.base_role);
      },

    },
    methods: {

      fetchData() {

        console.log(this.$route.params.id)
        console.log(this.$store.state.AppActiveUser.id)


        if (this.$route.params.id == this.$store.state.AppActiveUser.id) {
          console.log("current user");
          const role = this.$store.state.AppActiveUser.base_role.toLowerCase();
          this.all_user_data = this.$store.state.AppActiveUser[role];
          this.all_user_data['user'] = this.$_.omit(this.$store.state.AppActiveUser, [role]);

          return this.all_user_data;

        } else {

          this.all_user_data = commons.getUserDataFromRole(this.role, this.$route.params.id, this.$store.state);

          if (this.all_user_data) {
            console.log(this.all_user_data)
            this.all_user_data.user.photoURL = require("@/assets/images/portrait/small/avatar-s-11.jpg");
            return this.all_user_data;
          } else {

            this.$vs.loading();

            this.$store.dispatch("userManagement/fetchUser", this.$route.params.id)
              .then(result => {
                this.$vs.loading.close();

                const role = result.data.base_role.toLowerCase()
                this.all_user_data = result.data[role];
                this.all_user_data['user'] = this.$_.omit(result.data, [role]);
                this.all_user_data.user.photoURL = require("@/assets/images/portrait/small/avatar-s-11.jpg");

                return this.all_user_data;


              })
              .catch(err => {
                this.$vs.loading.close();

                console.log("Other profile fetch error")
                console.log(err);

                if (err.response.status === 401) {
                  this.$router.push({name: 'login'});
                } else if (err.response.status === 404) {
                  this.$router.push({name: 'page-error-404'});
                } else if (err.response.status === 403) {
                  alert(err.response.message)
                  this.$router.push({name: 'dashboard-sms'});
                }

              })
          }

        }
      },

    },
    created() {
      this.fetchData(this.$route.params.id);
    },
    beforeRouteUpdate(to, from, next) {
      this.fetchData(to.params.id);
      next();
    }
  }

</script>
