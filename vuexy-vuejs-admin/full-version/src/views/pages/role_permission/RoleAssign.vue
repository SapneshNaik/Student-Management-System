<template>
  <div class="vx-row">

    <div class="vx-col w-full" id="all_role_div">

      <vx-card title="Available Roles" class="mb-base">

        <vs-alert :active="allRoles.length > 0" class="mt-5" icon-pack="feather" icon="icon-info">
          Drag any role and drop it in the "Assigned Roles" section to assign a role to user.
        </vs-alert>

        <vs-alert :active="allRoles.length === 0" class="mt-5" icon-pack="feather" icon="icon-info">
          Fetching role details from the server. Please wait...
        </vs-alert>

        <div class="vx-row" id="all_roles">
          <div class="vx-col w-full">
            <draggable :list="allRoles" :group="{name:'tags',  pull:'clone', put:false }" class="p-2 cursor-move">
              <vs-chip class="m-1" v-if="notInAssignedRoles(listItem.name)" size="large" color="success"
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

        <vs-alert :active="alertActive" class="mt-5" icon-pack="feather" icon="icon-info">
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

        <vs-alert :active="alertActive" class="mt-5" icon-pack="feather"
                  icon="icon-info">
          Your account password is required to authorize role changes.
        </vs-alert>

        <form id="create-user-profile" data-vv-scope="step-3">

          <vs-input class="w-full mt-4" v-model="password" label="Password" type="password"
                    v-validate="'required|min:6'" name="password"/>
          <span class="text-danger">{{ errors.first('step-3.password') }}</span>

        </form>
      </vx-card>

    </div>


  </div>


</template>

<script>

  import draggable from "vuedraggable";

  export default {
    components: {
      draggable
    },
    data() {
      return {
        password: '',
        assignedRoles: [],

        alertActive: true
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
      this.fetchAllRoles();
    }
  }
</script>
