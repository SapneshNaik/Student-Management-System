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
              <parent-edit class="mt-4" :parent="profile_data"></parent-edit>
            </div>

            <div class="tab-text" v-if="user_data.base_role === 'Student' && profile_data">
              <student-edit class="mt-4" :student="profile_data"/>
            </div>

            <div class="tab-text" v-if="user_data.base_role === 'Staff' && profile_data">
              <staff-edit class="mt-4" :staff="profile_data"/>
            </div>


          </vs-tab>
          <vs-tab label="Address" icon-pack="feather" icon="icon-map-pin" v-if="addressTab">
            <div class="tab-text" v-if="communication_address || permanent_address">
              <address-edit :comm-address="communication_address" :perm-address="permanent_address"/>
            </div>
          </vs-tab>

          <vs-tab label="Roles" icon-pack="feather" icon="icon-shield" v-if="roleTab">
            <div class="tab-text">
              <user-role-edit class="mt-4" :data="role_data"/>
            </div>
          </vs-tab>

        </vs-tabs>

      </div>

    </vx-card>
  </div>
</template>

<script>
  import commons from "../../../commons";
  import AdminEdit from "../admin/AdminEdit";
  import ParentEdit from "../parent/ParentEdit";
  import BaseUserEdit from "./BaseUserEdit";
  import StudentEdit from "../student/StudentEdit";
  import StaffEdit from "../staff/StaffEdit";
  import UserRoleEdit from "../role_permission/UserRoleEdit";
  import AddressEdit from "../address/AddressEdit";

  export default {
    components: {
      AdminEdit,
      ParentEdit,
      BaseUserEdit,
      StudentEdit,
      StaffEdit,
      UserRoleEdit,
      AddressEdit
    },
    props: {
      role: {
        type: String,
        required: false,
        default: null
      },
      tab: {
        type: Number,
        required: false,
        default: 0
      },
    },
    data() {
      return {

        activeTab : this.tab,

        all_user_data: null,

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

      communication_address() {
        if (this.all_user_data) {
          if (this.all_user_data.user.communication_address) {
            return this.all_user_data.user.communication_address;
          } else {
            let temp = commons.getAddressModel("Communication");
            temp.user_id = this.all_user_data.user.id;
            return temp;          }
        } else {
          return [];
        }
      },

      permanent_address() {
        if (this.all_user_data) {
          if (this.all_user_data.user.permanent_address) {
            return this.all_user_data.user.permanent_address;
          } else {
            let temp = commons.getAddressModel("Permanent");
            temp.user_id = this.all_user_data.user.id;
            return temp;
          }
        } else {
          return [];
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
        return commons.hasAccess('sms-edit-role');
      },

    },
    methods: {

      fetchData() {


        if (this.$route.params.id == this.$store.state.AppActiveUser.id) {
          console.log("current user");
          const role = this.$store.state.AppActiveUser.base_role.toLowerCase();
          this.all_user_data = this.$store.state.AppActiveUser[role];
          this.all_user_data['user'] = this.$_.omit(this.$store.state.AppActiveUser, [role]);

          return this.all_user_data;

        } else {

          this.all_user_data = commons.getUserDataFromRole(this.role, this.$route.params.id, this.$store.state);

          if (this.all_user_data) {
            this.all_user_data.user.photoURL = "https://i.pravatar.cc/200";
            return this.all_user_data;
          } else {

            this.$vs.loading();

            this.$store.dispatch("userManagement/fetchUser", this.$route.params.id)
              .then(result => {
                this.$vs.loading.close();

                const role = result.data.base_role.toLowerCase()
                this.all_user_data = result.data[role];
                this.all_user_data['user'] = this.$_.omit(result.data, [role]);
                this.all_user_data.user.photoURL = "https://i.pravatar.cc/200";

                return this.all_user_data;


              })
              .catch(err => {
                this.$vs.loading.close();

                console.log("Other profile fetch error")
                console.log(err);



              })
          }

        }
      },

    },
    mounted() {
      this.fetchData(this.$route.params.id);
    },
    beforeRouteUpdate(to, from, next) {
      this.fetchData(to.params.id);
      next();
    }
  }

</script>
