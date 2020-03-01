<template>
  <div id="user-profile-view">

    <div id="user-data">

      <vx-card title="Account" class="mb-base" v-if="user_data">

        <!-- Avatar -->
        <div class="vx-row">

          <!-- Avatar Col -->
          <div class="vx-col" id="avatar-col">
            <div class="img-container mb-4">
              <img :src="user_data.photoURL" class="rounded w-full"/>
            </div>
          </div>

          <!-- Information - Col 1 -->
          <div class="vx-col flex-1" id="account-info-col-1">
            <table>
              <tr>
                <td class="font-semibold">Login ID</td>
                <td> {{ user_data.login_id }}</td>
              </tr>
              <tr>
                <td class="font-semibold">Phone</td>
                <td> {{ user_data.phone_number }}</td>
              </tr>
              <tr>
                <td class="font-semibold">Email</td>
                <td> {{ user_data.email }}</td>
              </tr>
            </table>
          </div>
          <!-- /Information - Col 1 -->

          <!-- Information - Col 2 -->
          <div class="vx-col flex-1" id="account-info-col-2">
            <table>
              <tr>
                <td class="font-semibold">Role</td>
                <td> {{ user_data.base_role }}</td>
              </tr>
              <tr>
                <td class="font-semibold">Alternate Phone</td>
                <td> {{ user_data.alternate_phone_number ? user_data.alternate_phone_number : 'N/A' }}
                </td>
              </tr>
              <tr>
                <td class="font-semibold">Status</td>
                <td> {{ user_data.status }}</td>
              </tr>

            </table>
          </div>
          <div class="vx-col w-full flex" id="account-manage-buttons">
            <vs-button icon-pack="feather" icon="icon-edit" class="mr-4"
                       :to="{name: 'sms-user-profile-edit', params: { id: user_data.id, role:user_data.base_role }}">
              Edit
            </vs-button>
            <!--            <vs-button type="border" color="danger" icon-pack="feather" icon="icon-trash" @click="confirmDeleteRecord">Delete</vs-button>-->
          </div>

        </div>

      </vx-card>

      <div class="vx-row">
        <div class="vx-col lg:w-1/2 w-full" v-if="profile_data">
          <vx-card title="Profile" class="mb-base">
            <table>
              <tr v-for="(item, index) in profile_data" :key="index" v-if="canShowIndex(index)">
                <td class="font-semibold">{{ titleCase(index) }}</td>
                <td>{{ getItemText(index, item) }}</td>
              </tr>
            </table>
          </vx-card>
        </div>

        <div class="vx-col lg:w-1/2 w-full" v-if="address_data">
          <vx-card title="Address" class="mb-base">
            <table>
              <tr v-for="(item, index) in address_data" :key="index">
                <td class="font-semibold">{{ titleCase(index) }}</td>
                <td>{{ item }}</td>
              </tr>
            </table>
          </vx-card>
        </div>
      </div>

      <div class="vx-row">

        <div class="vx-col lg:w-1/2 w-full" v-if="role_data.length > 0">
          <vx-card title="Roles">
            <div class="vx-row">
              <div class="vx-col w-full">
                <vs-chip color="warning"
                         icon-pack="feather"
                         v-for="(listItem) in role_data" :key="listItem.id">{{ listItem.name }}
                </vs-chip>
              </div>
            </div>
          </vx-card>
        </div>

        <div class="vx-col lg:w-1/2 w-full" v-if="all_permissions_data.length > 0">
          <vx-card title="Permissions">
            <div class="vx-row">
              <div class="vx-col w-full">
                <vs-chip color="success"
                         icon-pack="feather"
                         v-for="(listItem) in all_permissions_data" :key="listItem.id">{{ listItem.name
                  }}
                </vs-chip>
              </div>
            </div>
          </vx-card>
        </div>

      </div>

    </div>
  </div>
</template>

<script>

  import commons from "../../../commons";

  export default {
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
      }
    },
    computed: {


      profile_data() {
        if (this.all_user_data) {
          return this.$_.omit(this.all_user_data, ['user']);
        } else {
          return [];
        }
      },

      user_data() {
        if (this.all_user_data) {

          return this.all_user_data.user;
        } else {
          return [];
        }
      },

      role_data() {
        if (this.all_user_data) {
          return this.all_user_data.user.roles;
        } else {
          return [];
        }
      },

      all_permissions_data() {
        if (this.all_user_data) {
          return this.all_user_data.user.all_permissions;
        } else {
          return [];
        }
      },
    }
    ,

    methods: {

      titleCase(value) {
        return this.$_.startCase(value)
      }
      ,

      confirmDeleteRecord() {
        this.$vs.dialog({
          type: 'confirm',
          color: 'danger',
          title: `Confirm Delete`,
          text: `You are about to delete "${this.profile_data.username}"`,
          accept: this.deleteRecord,
          acceptText: "Delete"
        })
      }
      ,
      deleteRecord() {
        /* Below two lines are just for demo purpose */
        this.$router.push({name: 'app-user-list'});
        this.showDeleteSuccess()

        /* UnComment below lines for enabling true flow if deleting user */
        // this.$store.dispatch("userManagement/removeRecord", this.profile_data.id)
        //   .then(()   => { this.$router.push({name:'app-user-list'}); this.showDeleteSuccess() })
        //   .catch(err => { console.error(err)       })
      }
      ,
      showDeleteSuccess() {
        this.$vs.notify({
          color: 'success',
          title: 'User Deleted',
          text: 'The selected user was successfully deleted'
        })
      },

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

      canShowIndex(index) {
        switch (index) {
          case 'user_id':
          case 'parent_id':
            return false;
          default:
            return true;
        }
      },

      getItemText(index, item) {

        if (item === null) {
          return "---"
        } else {
          switch (index) {
            case "is_father_alumni":
            case "is_mother_alumni":
              return (item) ? "Yes" : "No";
            default:
              return item
          }
        }
      },

    }
    ,
    created() {
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

  @media screen and (min-width: 1201px) and (max-width: 1211px),
  only screen and (min-width: 636px) and (max-width: 991px) {
    #account-info-col-1 {
      width: calc(100% - 12rem) !important;
    }


  }

</style>
