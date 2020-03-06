<template>
  <div class="vx-row flex -mx-2">
    <vs-button @click="viewRole(params.value)" class="px-2" radius color="success" type="border" icon-pack="feather"
               icon="icon-eye"></vs-button>
    &nbsp;
    &nbsp;
    <vs-button v-if="canEdit" @click="editRole(params.value)" radius color="warning" type="border" icon-pack="feather"
               icon="icon-edit-2"></vs-button>
    &nbsp;
    &nbsp;
    <vx-tooltip v-if="canDelete" text="You can delete a role only if it is not assigned to any of the users.">
      <vs-button :disabled="params.data.users.length > 0" @click="deleteRole(params.value)" radius color="danger"
                 type="border" icon-pack="feather"
                 icon="icon-trash"></vs-button>
    </vx-tooltip>

    <vs-popup v-if="canDelete" classContent="popup-example" title="Authentication Required" :active.sync="deleteRolePopupActive">

      <form id="delete-role-form" data-vv-scope="step-1" @submit.prevent>
        <div class="vx-row">
          <div class="vx-col w-full mb-4">
            <vs-input v-model="password" class="w-full" label="Password" type="password"
                      v-validate="'required|min:6|'"
                      name="password"/>
            <span class="text-danger">{{ errors.first('step-1.password') }}</span>
          </div>

        </div>

        <vs-button @click="validateNDelete(params.data)" :id="'deleteButton'+params.data.id " color="primary"
                   type="filled">Delete {{params.data.name}}
          Role
        </vs-button>

      </form>

    </vs-popup>

  </div>


</template>

<script>
  import Vue from "vue";
  import jwt from "../../../http/requests/auth/jwt";
  import commons from "../../../commons";

  export default Vue.extend({

    data() {
      return {
        deleteRolePopupActive: false,
        password: "",
      }
    },

    computed: {

      canEdit() {
        return commons.hasAccess("sms-edit-role")
      },

      canDelete() {
        return commons.hasAccess("sms-delete-role")
      }
    },

    methods: {

      viewRole(id) {
        this.$router.push({name: 'sms-role-specific-view', params: {id: id}})
      },
      editRole(id) {
        this.$router.push({name: 'sms-edit-role', params: {id: id}})
      },
      deleteRole() {
        this.deleteRolePopupActive = true;
      },

      validateNDelete(data) {

        this.$validator.validateAll("step-1").then(result => {
          if (result) {
            this.deleteRoleRequest(data)
          }
        })
      },

      deleteRoleRequest(data) {

        this.deleteRolePopupActive = false;

        console.log(data);
        this.$vs.loading({
          'container': "#deleteButton" + this.params.data.id,
          'scale': 0.45
        });

        const payload = {id: data.id, password: this.password}
        console.log(payload)

        jwt.deleteRole(payload).then(() => {

          this.$vs.loading.close("#deleteButton" + this.params.data.id + " > .con-vs-loading");

          this.$vs.notify({
            title: 'Role Deleted',
            text: data.name + " role was deleted",
            iconPack: 'feather',
            icon: 'icon-alert-circle',
            position: 'top-right',
            color: 'warning'
          });


          this.$store.dispatch("userManagement/deleteRecord",
            {type: "Role", data: this.params.data});

        }).catch((error) => {
          this.$vs.loading.close("#deleteButton > .con-vs-loading");

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
    }

  });
</script>
