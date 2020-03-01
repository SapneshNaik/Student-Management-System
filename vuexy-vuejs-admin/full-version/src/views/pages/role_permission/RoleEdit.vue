<template>
  <div class="vx-row">

    <div class="vx-col w-full" id="all_role_div">

      <vx-card title="Available Roles" class="mb-base">

        <vs-alert :active="alertActive" class="mt-5" icon-pack="feather" icon="icon-info">
          Drag any role and drop it in the "Assigned Roles" section to assign a role to user.
        </vs-alert>

        <vs-alert :active="allRoles.length === 0" class="mt-5" icon-pack="feather" icon="icon-info">
          Fetching role details from the server. Please wait...
        </vs-alert>

        <div class="vx-row" id="all_roles">
          <div class="vx-col w-full">
            <draggable :list="allRoles" :group="{name:'tags',  pull:'clone', put:false }" class="p-2 cursor-move">
              <vs-chip size="large" color="success" v-for="(listItem) in allRoles" :key="listItem.id">{{ listItem.name
                }}
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
                <vs-chip @click="removeItem(index)" color="warning"
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

        <vs-alert :active="alertActive" class="mt-5" icon-pack="feather" icon="icon-info">
          This section is updated automatically based on roles.
        </vs-alert>

        <vs-divider/>

        <!-- List 1 -->
        <div class="vx-row">
          <div class="vx-col w-full">
            <vs-chip color="warning"
                     v-for="(listItem) in assignedPerms" :key="listItem.id">{{ listItem }}
            </vs-chip>
          </div>
        </div>
      </vx-card>
    </div>

    <div class="vx-col w-full" id="role_pwd_div" v-if="assignedRoles.length > 0">

      <vx-card title="Authorize Role Change" class="mb-base">

        <vs-alert :active="alertActive" class="mt-5" icon-pack="feather"
                  icon="icon-info">
          Your account password is required to authorize role changes.
        </vs-alert>

        <form id="create-user-profile" data-vv-scope="step-3">

          <vs-input class="w-full mt-4" v-model="password" type="password"
                    v-validate="'required|max:6'" name="password"/>
          <span class="text-danger">{{ errors.first('step-3.password') }}</span>

        </form>
      </vx-card>

    </div>


  </div>


</template>

<script>

  import draggable from "vuedraggable";

  import jwt from '@/http/requests/auth/jwt/index.js'

  export default {
    components: {
      draggable
    },
    data() {
      return {
        allRoles: [],
        allPerms: [],
        password: '',
        assignedRoles: [],

        alertActive: true
      }
    },

    computed: {
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
      assignedRolesUnique: function () {
        return this.$_.uniq(this.assignedRoles, 'name');
      }
    },

    methods: {

      removeItem: function (index) {
        this.assignedRoles.splice(index, 1);
      },

      fetchAllRoles: function () {

        jwt.getAllRolesWithPerms()
          .then((response) => {
            this.allRoles = response
          })
          .catch((error) => {

            this.$vs.notify({
              title: 'Error fetching roles',
              text: error.response.status,
              iconPack: 'feather',
              icon: 'icon-alert-circle',
              color: 'danger'
            })

            console.log(error)
          })

        jwt.getAllPerms()
          .then((response) => {
            this.allPerms = response
          })
          .catch((error) => {
            console.log(error);

            this.$vs.notify({
              title: 'Error fetching permissions',
              text: error.response.status,
              iconPack: 'feather',
              icon: 'icon-alert-circle',
              color: 'danger'
            })

          })

      },

      validatePassword: function () {
        return new Promise((resolve, reject) => {
          this.$validator.validateAll("step-3").then(result => {
            if (result) {
              resolve(true)
            } else {
              reject("correct all values");
            }
          })
        })
      },
    },

    created() {
      this.fetchAllRoles()
    }
  }
</script>
