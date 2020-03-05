<template>
  <div class="vx-row">

    <div class="vx-col w-full" id="all_role_div">

      <vx-card title="Available Roles" class="mb-base">

        <vs-alert :active="true" class="mt-5" icon-pack="feather" icon="icon-info">
          Drag any role and drop it in the "Assigned Roles" section to assign a role to user.
        </vs-alert>

        <vs-alert :active="allRoles.length === 0" class="mt-5" icon-pack="feather" icon="icon-info">
          Fetching role details from the server. Please wait...
        </vs-alert>

        <div class="vx-row" id="all_roles">
          <div class="vx-col w-full">
            <draggable :list="allRoles" :group="{name:'tags',  pull:'clone', put:false }" class="p-2 cursor-move">
              <vs-chip v-if="notInAssignedRoles(listItem.name)" size="large" color="success"
                       v-for="(listItem) in allRoles" :key="listItem.id">
                <vs-avatar icon-pack="feather" icon="icon-lock"/>

                {{ listItem.name }}
              </vs-chip>
            </draggable>
          </div>
        </div>
      </vx-card>

    </div>

    <div class="vx-col lg:w-1/2 w-full">

      <vx-card title="Assigned Roles" class="mb-base">

        <draggable :list="assignedRoles" :group="{name: 'tags'}" class="p-2 cursor-move">

          <vs-alert :active="assignedRoles.length > 0" class="mt-5" icon-pack="feather" icon="icon-info">
            Click on trash icon to remove roles.
          </vs-alert>

          <vs-divider/>

          <!-- List 1 -->
          <div class="vx-row">
            <div class="vx-col w-full">
              <transition-group>
                <vs-chip class="m-1" @click="removeItem(index)" color="warning"
                         closable
                         icon-pack="feather"
                         close-icon="icon-trash-2"
                         v-for="(listItem, index) in assignedRoles" :key="listItem.id">{{ listItem.name }}
                </vs-chip>
              </transition-group>

              <vs-alert :active="assignedRoles.length === 0" class="mt-5" icon-pack="feather" icon="icon-info">
                Drag roles here...
              </vs-alert>

            </div>
          </div>
        </draggable>

      </vx-card>

    </div>

    <div class="vx-col lg:w-1/2 w-full">

      <vx-card title="Assigned Permissions" class="mb-base">

        <vs-alert :active="true" class="mt-5" icon-pack="feather" icon="icon-info">
          This section is updated automatically based on roles.
        </vs-alert>

        <vs-divider/>

        <!-- List 1 -->
        <div class="vx-row">
          <div class="vx-col w-full">
            <vs-chip class="m-1" color="warning"
                     v-for="(listItem) in assignedPerms" :key="listItem.id">
              <vs-avatar icon-pack="feather" icon="icon-shield"/>
              {{ listItem }}
            </vs-chip>
          </div>
        </div>
      </vx-card>
    </div>

    <div class="vx-col w-full" id="role_pwd_div" v-if="assignedRoles.length > 0">

      <vx-card title="Authorize Role Change" class="mb-base">

        <vs-alert :active="true" class="mt-5" icon-pack="feather"
                  icon="icon-info">
          Your account password is required to authorize role changes.
        </vs-alert>

        <form id="create-user-profile" data-vv-scope="step-3">

          <vs-input class="w-full mt-4" v-model="password" label="Password" type="password"
                    v-validate="'required|min:6'" name="password"/>
          <span class="text-danger">{{ errors.first('step-3.password') }}</span>

        </form>
      </vx-card>

      <div class="vx-row">
        <div class="vx-col w-full">
          <div class="mt-8 flex flex-wrap items-center justify-end">
            <vs-button class="ml-auto mt-2" @click="validateNSubmit" id="save" :disabled="!validateForm">Save Changes
            </vs-button>
            <vs-button class="ml-4 mt-2" type="border" color="warning" @click="reset_data">Reset</vs-button>
          </div>
        </div>
      </div>

    </div>


  </div>


</template>

<script>

  import draggable from "vuedraggable";
  import jwt from "../../../http/requests/auth/jwt";

  export default {
    components: {
      draggable
    },
    props: {
      data: {
        type: Array,
        required: true,
      }
    },
    data() {
      return {
        assignedRoles: JSON.parse(JSON.stringify(this.data)),

        password: '',

        apiReqPending: 0,
      }
    },
    watch: {
      apiReqPending(value) {
        if (value > 0) {
          this.$vs.loading({
            'container': "#save",
            'scale': 0.45
          });
        } else {
          this.updateUser();
          this.$vs.loading.close("#save > .con-vs-loading");
        }
      }
    },

    computed: {

      allRoles() {
        return this.$store.state.userManagement.roles;
      },

      assignedPerms: function () {
        let result = [];
        this.assignedRoles.forEach(function (item) {
          if (item.permissions.length > 0) {
            item.permissions.forEach(function (perm) {
              result.indexOf(perm.name) === -1 ? result.push(perm.name) : '';
            })
          }
        });

        return result
      },

      validateForm() {
        return !this.errors.any()
      }

    },

    methods: {
      notInAssignedRoles(name) {
        const i = this.assignedRoles.findIndex(_item => _item.name === name);
        return !(i > -1);
      },

      removeItem: function (index) {
        this.assignedRoles.splice(index, 1);
      },

      fetchAllRoles() {
        this.$store.dispatch("userManagement/getAllRoles").then(() => {

          this.$vs.notify({
            title: 'Sync Update',
            text: 'Role records synced with server',
            color: 'success',
            position: 'top-right'
          })

        }).catch((error) => {
          console.log(error);
        });
      },

      validateNSubmit() {
        this.$validator.validateAll("step-3").then(result => {
          if (result && this.assignedRoles.length > 0) {
            this.save_changes();
          }
        })
      },

      async updateUser() {

        try {
          let result = await this.$store.dispatch("userManagement/fetchUser", this.$route.params.id);

          const role = result.data.base_role.toLowerCase();
          let profData = result.data[role];

          profData['user'] = this.$_.omit(result.data, [role]);
          profData.user.photoURL = "https://i.pravatar.cc/200";

          await this.$store.dispatch("userManagement/upsertToState",
            {type: result.data.base_role, data: profData});


          if (result.data.id == this.$store.state.AppActiveUser.id) {

            const name = {
              user: profData['user']
            };

            this.$store.commit('UPDATE_USER_INFO', name);
          }

          this.$vs.notify({
            title: 'Account Update',
            text: "User synced with system!",
            iconPack: 'feather',
            icon: 'icon-alert-circle',
            color: 'success',
            position: 'top-right'
          });


        } catch {

          this.$vs.notify({
            title: 'Account Update',
            text: "Failed to updated user!",
            iconPack: 'feather',
            icon: 'icon-alert-circle',
            color: 'danger',
            position: 'top-right'
          });
        }

      },

      save_changes() {

        const originalAssignedRoles = JSON.parse(JSON.stringify(this.data));

        const originalAssignedRolesIds = originalAssignedRoles.map(a => a.id);

        const updatedAssignedRolesIds = this.assignedRoles.map(a => a.id);

        let toBeRemoved = originalAssignedRolesIds.filter(function (role) {
          return updatedAssignedRolesIds.indexOf(role) < 0;
        });

        let toBeAdded = updatedAssignedRolesIds.filter(function (role) {
          return originalAssignedRolesIds.indexOf(role) < 0;
        });

        console.log("remove " + toBeRemoved);
        console.log("add " + toBeAdded);

        this.apiReqPending = toBeRemoved.length + toBeAdded.length;

        if (this.apiReqPending === 0) {

          this.$vs.notify({
            title: 'Account Update',
            text: "No change in data!",
            iconPack: 'feather',
            icon: 'icon-alert-circle',
            color: 'warning',
            position: 'top-right'
          });

        } else {
          toBeAdded.forEach(async (role_id) => {
            try {
              await jwt.assignRoleToUser(this.$route.params.id, role_id, this.password);

              this.apiReqPending -= 1;

              this.$vs.notify({
                title: 'Account Update',
                text: "Role " + role_id + " updated to user!",
                iconPack: 'feather',
                icon: 'icon-alert-circle',
                color: 'success',
                position: 'top-right'
              });
            } catch (error) {

              this.apiReqPending -= 1;

              console.log(error);

              if (error.response) {
                this.$vs.notify({
                  title: 'Error adding role to user',
                  text: error.status,
                  iconPack: 'feather',
                  icon: 'icon-alert-circle',
                  color: 'danger',
                  position: 'top-right'
                });
              }
            }
          });


          toBeRemoved.forEach(async (role_id) => {
            try {
              await jwt.unAssignRoleToUser(this.$route.params.id, role_id, this.password);

              this.apiReqPending -= 1;

              this.$vs.notify({
                title: 'Account Update',
                text: "Role " + role_id + " removed from user!",
                iconPack: 'feather',
                icon: 'icon-alert-circle',
                color: 'success',
                position: 'top-right'

              });

            } catch (error) {
              console.log(error);

              this.apiReqPending -= 1;

              if (error.response) {
                this.$vs.notify({
                  title: 'Error removing role from user',
                  text: error.status,
                  iconPack: 'feather',
                  icon: 'icon-alert-circle',
                  color: 'danger',
                  position: 'top-right'
                });
              }
            }

          });
        }


      },

      reset_data() {
        this.assignedRoles = JSON.parse(JSON.stringify(this.data));
        this.password = null;

      }

    },
    created() {
      this.fetchAllRoles();
    }
  }

</script>
