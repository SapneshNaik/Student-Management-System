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
          <vs-tab label="Account" icon-pack="feather" icon="icon-user" v-if="accountTab">
            <div class="tab-text">
              <user-edit-tab-account class="mt-4" :data="baseUserInfo" />
            </div>
          </vs-tab>
          <vs-tab label="Profile" icon-pack="feather" icon="icon-info" v-if="roleTab">
            <div class="tab-text" v-if="role_name === 'Admin' ">
              <user-edit-admin-profile class="mt-4" :data="role_data" />
            </div>
          </vs-tab>
          <vs-tab label="Address" icon-pack="feather" icon="icon-share-2" v-if="addressTab">
            <div class="tab-text">
              <user-edit-tab-social class="mt-4" :data="user_data" />
            </div>
          </vs-tab>
        </vs-tabs>

      </div>

    </vx-card>
  </div>
</template>

<script>
import UserEditTabAccount     from "./UserEditTabAccount.vue"
import UserEditAdminProfile from "../admin/UserEditAdminProfile";
import UserEditTabSocial      from "./UserEditTabSocial.vue"

// Store Module
import moduleUserManagement from '@/store/user-management/moduleUserManagement.js'

export default {
  components: {
    UserEditTabAccount,
    UserEditAdminProfile,
    UserEditTabSocial,
  },
  props: {
    baseUserInfo: {
      type: Object,
    },
    role_data: {
      type: Object,
    },
    address_data: {
      type: Object,
    },
    role_name: {
      type: String,
    },
  },
  data() {
    return {
      // accountTab: false,
      // roleTab: false,
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
    accountTab: function () {
      return (this.baseUserInfo !== undefined);
    },

    roleTab: function () {
      return (this.role_data !== undefined);
    },

    addressTab: function () {
      return (this.address_data !== undefined);
    },
  },
  methods: {
    test () {
      console.log("baseUserInfo");
      console.log(this.baseUserInfo);

      console.log("role_data");
      console.log(this.role_data);

      console.log("address_data");
      console.log(this.address_data);
    },

    fetch_user_data(userId) {
      this.$store.dispatch("userManagement/fetchUser", userId)
        .then(res => { this.user_data = res.data })
        .catch(err => {
          if(err.response.status === 404) {
            this.user_not_found = true
            return
          }
          console.error(err) })
    }
  },
  created() {
    // Register Module UserManagement Module
    this.test();


    if(!moduleUserManagement.isRegistered) {
      this.$store.registerModule('userManagement', moduleUserManagement)
      moduleUserManagement.isRegistered = true
    }
    this.fetch_user_data(this.$route.params.userId)
  }
}

</script>
