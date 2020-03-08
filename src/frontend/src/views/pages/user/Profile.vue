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
          <br/>

          <div class="vx-col w-full flex" vs-align="center">
            <vs-button icon-pack="feather" icon="icon-edit" class="mr-4"
                       :to="{name: 'sms-user-profile-edit', params: { id: user_data.id, role:user_data.base_role, tab: 0 }}">
              Edit
            </vs-button>
          </div>


        </div>

      </vx-card>

      <div class="vx-row">
        <div class="vx-col w-full" v-if="profile_data">
          <vx-card title="Profile" class="mb-base">
            <div class="vx-row">

              <div class="vx-col w-full lg:w-1/2 ">
                <table>
                  <tr v-for="(item) in profileFirstHalf" :key="item[0]" v-if="canShowIndex(item[0])">
                    <td class="font-semibold">{{ titleCase(item[0]) }}</td>
                    <td>{{ getItemText(item[0], item[1]) }}</td>
                  </tr>
                </table>
              </div>

              <div class="vx-col w-full lg:w-1/2 ">
                <table>
                  <tr v-for="(item) in profileSecondHalf" :key="item[0]" v-if="canShowIndex(item[0])">
                    <td class="font-semibold">{{ titleCase(item[0]) }}</td>
                    <td>{{ getItemText(item[0], item[1]) }}</td>
                  </tr>
                </table>
              </div>
            </div>

            <div class="vx-col w-full flex mt-5">
              <vs-button icon-pack="feather" icon="icon-edit" class="mr-4"
                         :to="{name: 'sms-user-profile-edit', params: { id: user_data.id, role:user_data.base_role, tab: 1 }}">
                Edit
              </vs-button>
            </div>

          </vx-card>
        </div>

        <div class="vx-col w-full">
          <div class="vx-row">

            <div class="vx-col w-full lg:w-1/2 ">

              <vx-card title="Communication Address" class="mb-base" v-if="communication_address">

                <table v-if="communication_address" class="ml-5 mt-5 mb-5">
                  <tr v-if="canShowIndex(index)" v-for="(item, index) in communication_address" :key="index">
                    <td class="font-semibold">{{ titleCase(index) }}</td>
                    <td>{{ item }}</td>
                  </tr>
                </table>

                <div class="vx-col w-full flex mt-5">
                  <vs-button icon-pack="feather" icon="icon-edit" class="mr-4"
                             :to="{name: 'sms-user-profile-edit', params: { id: user_data.id, role:user_data.base_role, tab: 2 }}">
                    Edit
                  </vs-button>
                </div>

              </vx-card>
            </div>
            <div class="vx-col w-full lg:w-1/2 ">

              <vx-card title="Permanent Address" class="mb-base" v-if="permanent_address">

                <table v-if="permanent_address" class="ml-5 mt-5">
                  <tr v-if="canShowIndex(index)" v-for="(item, index) in permanent_address" :key="index">
                    <td class="font-semibold">{{ titleCase(index) }}</td>
                    <td>{{ item }}</td>
                  </tr>
                </table>

                <div class="vx-col w-full flex mt-5">
                  <vs-button icon-pack="feather" icon="icon-edit" class="mr-4"
                             :to="{name: 'sms-user-profile-edit', params: { id: user_data.id, role:user_data.base_role, tab:2 }}">
                    Edit
                  </vs-button>
                </div>

              </vx-card>
            </div>
          </div>
        </div>
      </div>

      <div class="vx-row">

        <div class="vx-col lg:w-1/2 w-full" v-if="role_data.length > 0">
          <vx-card title="Roles">
            <div class="vx-row">
              <div class="vx-col w-full">
                <vs-chip class="mt-1" color="warning"
                         icon-pack="feather"
                         close-icon="icon-log-in"
                         :closable="canViewRole"
                         @click="goToRolePage(listItem.id)"
                         v-for="(listItem) in role_data" :key="listItem.id">
                  <vs-avatar icon-pack="feather" icon="icon-lock"/>

                  {{ listItem.name }}
                </vs-chip>
              </div>


              <div v-if="canEditRole" class="vx-col w-full flex mt-5">
                <vs-button icon-pack="feather" icon="icon-edit" class="mr-4"
                           :to="{name: 'sms-user-profile-edit', params: { id: user_data.id, role:user_data.base_role, tab:3 }}">
                  Edit
                </vs-button>
              </div>


            </div>
          </vx-card>
        </div>

        <div class="vx-col lg:w-1/2 w-full" v-if="all_permissions_data.length > 0">
          <vx-card title="Permissions">
            <div class="vx-row">
              <div class="vx-col w-full">
                <vs-chip class="mt-1" color="success"
                         icon-pack="feather"
                         v-for="(listItem) in all_permissions_data" :key="listItem.id">
                  <vs-avatar icon-pack="feather" icon="icon-shield"/>

                  {{ listItem.name }}
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
        all_user_data: null,
      }
    },
    computed: {

      canViewRole(){
        return commons.hasAccess('sms-role-specific-view');
      },

      canEditRole() {
        return commons.hasAccess('sms-edit-role');
      },

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

      communication_address() {
        if (this.all_user_data) {
          return this.all_user_data.user.communication_address;
        } else {
          return [];
        }
      },

      permanent_address() {
        if (this.all_user_data) {
          return this.all_user_data.user.permanent_address;
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

      profileFirstHalf() {

        const temp = this.getToBeHalvedData;
        return temp.splice(0, temp.length / 2);
      },

      profileSecondHalf() {

        const temp = this.getToBeHalvedData;
        return temp.splice(temp.length / 2, temp.length);
      },

      getToBeHalvedData() {
        const data = JSON.parse(JSON.stringify(this.profile_data));
        delete data['user_id'];
        delete data['parent_id'];
        return Object.entries(data);
      },

    }
    ,


    methods: {

      titleCase(value) {
        return this.$_.startCase(value);
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
            this.all_user_data.user.photoURL = "https://i.pravatar.cc/200";
            return this.all_user_data;
          } else {

            this.$vs.loading();

            this.$store.dispatch("userManagement/fetchUser", this.$route.params.id)
              .then(result => {
                this.$vs.loading.close();

                const role = result.data.base_role.toLowerCase();
                this.all_user_data = result.data[role];
                this.all_user_data['user'] = this.$_.omit(result.data, [role]);
                this.all_user_data.user.photoURL = "https://i.pravatar.cc/200";

                this.$store.dispatch("userManagement/upsertToState",
                  {type: result.data.base_role, data: this.all_user_data});

                return this.all_user_data;


              })
              .catch(err => {
                this.$vs.loading.close();

                console.log("Other profile fetch error");
                console.log(err);



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

            case "parent":
              return item.father_full_name;

            case "wards":
              if (item.length === 0) {
                return "---"
              } else {
                return item.map(a => a.first_name + " " + a.last_name).join(', ')
              }

            default:
              return item
          }
        }
      },

      goToRolePage(id) {
        this.$router.push({name: 'sms-role-specific-view', params: {id: id}}).catch(() => {
        })
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
