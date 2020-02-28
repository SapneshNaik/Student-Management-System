<!-- =========================================================================================
  File Name: UserView.vue
  Description: User View page
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->

<template>
  <div id="page-user-profile">

    <!--    <vs-alert color="danger" title="User Not Found" :active.sync="user_not_found">-->
    <!--      <span>User record with id: {{ $route.params.role }} not found. </span>-->
    <!--      <span>-->
    <!--        <span>Check </span><router-link :to="{name:'page-user-list'}"-->
    <!--                                        class="text-inherit underline">All Users</router-link>-->
    <!--      </span>-->
    <!--    </vs-alert>-->

    <div id="user-data">

      <vx-card title="Account" class="mb-base" v-if="baseUserInfo">

        <!-- Avatar -->
        <div class="vx-row">

          <!-- Avatar Col -->
          <div class="vx-col" id="avatar-col">
            <div class="img-container mb-4">
              <img :src="baseUserInfo.photoURL" class="rounded w-full"/>
            </div>
          </div>

          <!-- Information - Col 1 -->
          <div class="vx-col flex-1" id="account-info-col-1">
            <table>
              <tr>
                <td class="font-semibold">Login ID</td>
                <td> {{ baseUserInfo.login_id }}</td>
              </tr>
              <tr>
                <td class="font-semibold">Phone</td>
                <td> {{ baseUserInfo.phone_number }}</td>
              </tr>
              <tr>
                <td class="font-semibold">Email</td>
                <td> {{ baseUserInfo.email }}</td>
              </tr>
            </table>
          </div>
          <!-- /Information - Col 1 -->

          <!-- Information - Col 2 -->
          <div class="vx-col flex-1" id="account-info-col-2">
            <table>
              <tr>
                <td class="font-semibold">Role</td>
                <td> {{ baseUserInfo.base_role }}</td>
              </tr>
              <tr>
                <td class="font-semibold">Alternate Phone</td>
                <td> {{ baseUserInfo.alternate_phone_number ? baseUserInfo.alternate_phone_number : 'N/A' }}</td>
              </tr>
              <tr>
                <td class="font-semibold">Status</td>
                <td> {{ baseUserInfo.status }}</td>
              </tr>

            </table>
          </div>
          <!-- /Information - Col 2 -->
          <div class="vx-col w-full flex" id="account-manage-buttons">
            <vs-button icon-pack="feather" icon="icon-edit" class="mr-4"
                       :to="{name: 'sms-user-profile-edit', params: { userId: baseUserInfo.id, baseUserInfo:baseUserInfo }}">
              Edit
            </vs-button>
            <!--            <vs-button type="border" color="danger" icon-pack="feather" icon="icon-trash" @click="confirmDeleteRecord">Delete</vs-button>-->
          </div>

        </div>

      </vx-card>

      <div class="vx-row" v-if="role_data">
        <div class="vx-col lg:w-1/2 w-full">
          <vx-card title="Profile" class="mb-base">
            <table>
              <tr v-for="(item, index) in role_data" :key="index">
                <td class="font-semibold">{{ titleCase(index) }}</td>
                <td>{{ item }}</td>
              </tr>
            </table>
            <div class="vx-col w-full flex" id="account-manage-buttons">
              <vs-button icon-pack="feather" icon="icon-edit" class="mr-4"
                         :to="{name: 'sms-user-profile-edit', params: { userId: role_data.user_id, role_data:role_data, role_name: role_data.role_name }}">
                Edit
              </vs-button>
              <!--            <vs-button type="border" color="danger" icon-pack="feather" icon="icon-trash" @click="confirmDeleteRecord">Delete</vs-button>-->
            </div>
          </vx-card>


        </div>

        <div class="vx-col lg:w-1/2 w-full" v-if="address_data">
          <vx-card title="Address" class="mb-base">
            <table>
              <table>
                <tr v-for="(item, index) in address_data" :key="index">
                  <td class="font-semibold">{{ titleCase(index) }}</td>
                  <td>{{ item }}</td>
                </tr>
              </table>
            </table>
            <div class="vx-col w-full flex" id="account-manage-buttons">
              <vs-button icon-pack="feather" icon="icon-edit" class="mr-4"
                         :to="{name: 'sms-user-profile-edit', params: { userId: $route.params.userId, address_data:address_data }}">
                Edit
              </vs-button>
              <!--            <vs-button type="border" color="danger" icon-pack="feather" icon="icon-trash" @click="confirmDeleteRecord">Delete</vs-button>-->
            </div>
          </vx-card>
        </div>
      </div>

      <!-- Permissions -->
      <vx-card v-if="perm_data.length > 0">

        <div class="vx-row">
          <div class="vx-col w-full">
            <div class="flex items-end px-3">
              <feather-icon svgClasses="w-6 h-6" icon="LockIcon" class="mr-2"/>
              <span class="font-medium text-lg leading-none">Permissions</span>
            </div>
            <vs-divider/>
          </div>
        </div>

        <div class="block overflow-x-auto">
          <table class="w-full permissions-table">
            <tr>
              <!--
                You can also use `Object.keys(Object.values(data_local.permissions)[0])` this logic if you consider,
                our data structure. You just have to loop over above variable to get table headers.
                Below we made it simple. So, everyone can understand.
               -->
              <th class="font-semibold text-base text-left px-3 py-2"
                  v-for="heading in ['Module', 'Read', 'Write', 'Create', 'Delete']" :key="heading">{{ heading }}
              </th>
            </tr>

            <tr v-for="(val, name) in perm_data.permissions" :key="name">
              <td class="px-3 py-2">{{ name }}</td>
              <td v-for="(permission, name) in val" class="px-3 py-2" :key="name+permission">
                <vs-checkbox v-model="val[name]" class="pointer-events-none"/>
              </td>
            </tr>
          </table>
        </div>

      </vx-card>
    </div>
  </div>
</template>

<script>

  import moduleUserManagement from '@/store/user-management/moduleUserManagement.js'

  export default {
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

        baseUserInfo: {},
        role_data: {},
        perm_data: {}
      }
    },
    computed: {
      userAddress() {
        let str = ""
        for (var field in this.role_data.location) {
          str += field + " "
        }
        return str
      },
    },

    methods: {

      titleCase(value) {
        return this.$_.startCase(value)
      },

      confirmDeleteRecord() {
        this.$vs.dialog({
          type: 'confirm',
          color: 'danger',
          title: `Confirm Delete`,
          text: `You are about to delete "${this.role_data.username}"`,
          accept: this.deleteRecord,
          acceptText: "Delete"
        })
      },
      deleteRecord() {
        /* Below two lines are just for demo purpose */
        this.$router.push({name: 'app-user-list'});
        this.showDeleteSuccess()

        /* UnComment below lines for enabling true flow if deleting user */
        // this.$store.dispatch("userManagement/removeRecord", this.role_data.id)
        //   .then(()   => { this.$router.push({name:'app-user-list'}); this.showDeleteSuccess() })
        //   .catch(err => { console.error(err)       })
      },
      showDeleteSuccess() {
        this.$vs.notify({
          color: 'success',
          title: 'User Deleted',
          text: 'The selected user was successfully deleted'
        })
      },


      fetchData(user_id) {

        this.$vs.loading();

        this.$store.dispatch("userManagement/fetchUser", user_id)
          .then(res => {
            this.$vs.loading.close()

            console.log(res)
            if (res.data) {
              this.baseUserInfo = res.data;
              this.baseUserInfo.photoURL = require("@/assets/images/portrait/small/avatar-s-11.jpg");
            }

            if (res.data && res.data[res.data.base_role.toLowerCase()]) {
              this.role_data = res.data[res.data.base_role.toLowerCase()];
              this.role_data['role_name'] = res.data.base_role;
            }

            if (res.data && res.data.all_permissions) {
              this.perm_data = res.data.all_permissions;
            }

          })
          .catch(err => {
            this.$vs.loading.close()

            console.log("Other profile fetch error")
            console.log(err);

            if (err.response.status === 401) {
              this.$router.push({name: 'login'});
              return
            } else if (err.response.status === 404) {
              this.$router.push({name: 'page-error-404'});
              return
            } else if (err.response.status === 403) {
              alert(err.response.message)
              this.$router.push({name: 'dashboard-sms'});
              return
            }

            console.error(err)
          })

      }
    },
    created() {
      if (!moduleUserManagement.isRegistered) {
        this.$store.registerModule('userManagement', moduleUserManagement)
        moduleUserManagement.isRegistered = true
      }


      this.fetchData(this.$route.params.id);
    },
    beforeRouteUpdate(to, from, next) {
      this.fetchData(to.params.id);
      next();
    }
  }

</script>

<style lang="scss">
  #avatar-col {
    width: 10rem;
  }

  #page-user-profile {
    table {
      td {
        vertical-align: top;
        min-width: 140px;
        padding-bottom: .8rem;
        word-break: break-all;
      }

      &:not(.permissions-table) {
        td {
          @media screen and (max-width: 370px) {
            display: block;
          }
        }
      }
    }
  }

  // #account-info-col-1 {
  //   // flex-grow: 1;
  //   width: 30rem !important;
  //   @media screen and (min-width:1200px) {
  //     & {
  //       flex-grow: unset !important;
  //     }
  //   }
  // }


  @media screen and (min-width: 1201px) and (max-width: 1211px),
  only screen and (min-width: 636px) and (max-width: 991px) {
    #account-info-col-1 {
      width: calc(100% - 12rem) !important;
    }

    // #account-manage-buttons {
    //   width: 12rem !important;
    //   flex-direction: column;

    //   > button {
    //     margin-right: 0 !important;
    //     margin-bottom: 1rem;
    //   }
    // }

  }

</style>
