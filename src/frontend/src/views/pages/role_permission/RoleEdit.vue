<template>
  <div class="vx-row">

    <div class="vx-col w-full" id="all_role_div">

      <vx-card title="Common Operations and Their Required Permissions" class="mb-base">
        <div>
          <vs-table stripe  :data="help">

            <template slot="thead">
              <vs-th>
                No.
              </vs-th>
              <vs-th>
                Operation Type
              </vs-th>
              <vs-th>
                Permission Required
              </vs-th>
            </template>

            <template slot-scope="{data}">
              <vs-tr :key="indextr" v-for="(tr, indextr) in data" >
                <vs-td :data="data[indextr].id">
                  {{data[indextr].id}}
                </vs-td>
                <vs-td :data="data[indextr].email">
                  {{data[indextr].operation}}
                </vs-td>

                <vs-td :data="data[indextr].username">
                  {{data[indextr].permissions}}
                </vs-td>

              </vs-tr>
            </template>
          </vs-table>
        </div>

      </vx-card>


      <vx-card title="Edit Role" class="mb-base">

        <form v-if="data_local" id="create-role" data-vv-scope="step-3" @submit.prevent>
          <div class="vx-row">

            <!--            to prevent strange page refresh behaviour on button click-->
            <vs-input class="w-full  mt-4" type="hidden" name="test"/>

            <vs-input class="w-full  mt-4" type="hidden" name="test1"/>


            <div class="vx-col sm:w-1/2 w-full mb-2">

              <vs-input class="w-full  mt-4" v-model="data_local.name" v-validate="'required|max:50'"
                        label="Role Name" name="name"/>
              <span class="text-danger">{{ errors.first('step-3.name') }}</span>
            </div>

            <div class="vx-col sm:w-1/2 w-full mb-2">

              <vs-input class="w-full mt-4" v-model="data_local.password" label="Password" type="password"
                        v-validate="'required|min:6'" name="password"/>
              <span class="text-danger">{{ errors.first('step-3.password') }}</span>

            </div>

          </div>

          <br/>

          <div class="vx-row">


            <div class="vx-col lg:w-1/2 w-full">

              <vx-card title="Assigned Permissions" class="mb-base">

                <draggable :list="data_local.permissions" :group="{name: 'tags'}" class="p-2 cursor-move">

                  <vs-alert :active="data_local.permissions.length > 0" class="mt-5" icon-pack="feather"
                            icon="icon-info">
                    Click on trash icon to remove permissions.
                  </vs-alert>

                  <vs-divider/>

                  <!-- List 1 -->
                  <div class="vx-row">
                    <div class="vx-col w-full">
                      <transition-group>
                        <vs-chip class="m-1" v-on:click="removeItem(index)" color="warning"
                                 closable
                                 icon-pack="feather"
                                 close-icon="icon-trash-2"
                                 v-for="(listItem, index) in data_local.permissions" :key="listItem.id">
                          <vs-avatar icon-pack="feather" icon="icon-shield"/>
                          {{ listItem.name }}
                        </vs-chip>
                      </transition-group>

                      <vs-alert :active="data_local.permissions.length === 0" class="mt-5" icon-pack="feather"
                                icon="icon-info">
                        Drag permissions here...
                      </vs-alert>

                      <span v-if="data_local.permissions.length === 0"
                            class="text-danger"> Please add at least one permission </span>


                    </div>
                  </div>
                </draggable>

              </vx-card>
            </div>

            <div class="vx-col lg:w-1/2 w-full">

              <vx-card title="Available Permissions" class="mb-base">


                <vs-alert :active="allPerms.length > 0" class="mt-5" icon-pack="feather" icon="icon-info">
                  Drag any permission to Assigned Permissions Section
                </vs-alert>

                <vs-alert :active="allPerms.length === 0" class="mt-5" icon-pack="feather" icon="icon-info">
                  Fetching available permissions from the server
                </vs-alert>

                <vs-divider/>

                <div class="vx-row" id="all_roles">
                  <div class="vx-col w-full">
                    <draggable :list="allPerms" :group="{name:'tags',  pull:'clone', put:false }"
                               class="p-2 cursor-move">

                      <vs-chip v-if="notInAssignedPerms(listItem.name)" color="success"
                               v-for="(listItem) in allPerms" :key="listItem.id">
                        <vs-avatar icon-pack="feather" icon="icon-shield"/>
                        {{ listItem.name }}
                      </vs-chip>

                    </draggable>

                  </div>
                </div>

              </vx-card>
            </div>
          </div>


          <div class="vx-row">
            <div class="vx-col w-full">
              <div class="mt-8 flex flex-wrap items-center justify-end">
                <vs-button class="ml-auto mt-2" @click="validateNSubmit" id="save">Save Changes</vs-button>
                <vs-button class="ml-4 mt-2" @click="resetData" type="border" color="warning">Reset</vs-button>
              </div>
            </div>
          </div>


        </form>


      </vx-card>

    </div>

  </div>


</template>

<script>

  import draggable from "vuedraggable";
  import jwt from '@/http/requests/auth/jwt/index.js';
  import commons from "../../../commons";
  import constants from "../../../constants";


  export default {
    components: {
      draggable
    },

    data() {
      return {
        data_local: null,
        help: constants.ROLE_HELP

      }
    },

    mounted() {
      this.data_local = (this.roleData) ? JSON.parse(JSON.stringify(this.roleData)) : null;

      if (this.data_local === null) {
        console.log("role not found in Vuex store")
        this.$vs.loading();
        this.fetchRoleNUpdateIfDataNull();
      }
    },

    computed: {

      roleData() {
        return commons.getUserDataFromRole("Role", this.$route.params.id, this.$store.state);
      },

      allPerms() {
        return this.$store.state.userManagement.permissions;
      },
    },

    methods: {

      removeItem: function (index) {
        this.data_local.permissions.splice(index, 1);
      },

      fetchAllPermissions() {
        this.$store.dispatch("userManagement/getAllPermissions").then(() => {

          this.$vs.notify({
            title: 'Sync Update',
            text: 'Permission records synced with the server',
            color: 'success',
            position: 'top-right'
          })

        }).catch((error) => {
          console.log(error);
        });
      },

      validateForm() {
        return !this.errors.any()
      },

      validateNSubmit() {
        this.$validator.validateAll("step-3").then(result => {
          if (result && this.data_local.permissions.length > 0) {
            this.saveRoleChanges()
          }
        })
      },

      notInAssignedPerms(name) {
        const i = this.data_local.permissions.findIndex(_item => _item.name === name);
        return !(i > -1);
      },

      fetchRoleNUpdateIfDataNull() {

        this.$store.dispatch("userManagement/fetchRole", this.$route.params.id)
          .then(response => {
            this.$vs.loading.close();

            this.$store.dispatch("userManagement/upsertToState",
              {type: "Role", data: response.data});

            if (this.data_local == null) {

              this.data_local = JSON.parse(JSON.stringify(this.roleData));

              this.$vs.loading.close();

              this.$vs.notify({
                title: 'Role details fetched from the backend',
                iconPack: 'feather',
                icon: 'icon-alert-circle',
                position: 'top-right',
                color: 'success'
              });
            }


          }).catch(err => {
          console.log(err);

          this.$vs.notify({
            title: 'Failed to fetch Role from the server',
            iconPack: 'feather',
            icon: 'icon-alert-circle',
            position: 'top-right',
            color: 'danger'
          });

          this.$vs.loading.close();

        })

      },

      saveRoleChanges() {

        let reqParams = JSON.parse(JSON.stringify(this.data_local));

        reqParams.permissions = this.data_local.permissions.map(a => a.id);

        this.$vs.loading({
          'container': "#save",
          'scale': 0.45
        });


        jwt.putRole(reqParams).then(() => {

          this.$vs.loading.close("#save > .con-vs-loading");

          this.$vs.notify({
            title: 'Role Updated',
            text: this.data_local.name + " role updated successfully",
            iconPack: 'feather',
            icon: 'icon-alert-circle',
            position: 'top-right',
            color: 'success'
          });


          this.$store.dispatch("userManagement/upsertToState",
            {type: "Role", data: this.data_local});

        }).catch((error) => {
          this.$vs.loading.close("#save > .con-vs-loading");

          if (error.response) {
            let errors = Object.values(error.response.data);
            errors = errors.flat();
            errors.forEach((error) => {
              this.$vs.notify({
                title: 'Error',
                text: error,
                iconPack: 'feather',
                icon: 'icon-alert-circle',
                color: 'danger',
                position: 'top-right',

              })
            });
          } else {
            this.$vs.notify({
              title: 'Error',
              text: error.message,
              iconPack: 'feather',
              icon: 'icon-alert-circle',
              color: 'danger',
              position: 'top-right',

            })
          }
        });
      },

      resetData() {
        this.data_local = JSON.parse(JSON.stringify(this.roleData))
      }
    }
    ,

    created() {
      this.fetchAllPermissions();
    }
  }
</script>
