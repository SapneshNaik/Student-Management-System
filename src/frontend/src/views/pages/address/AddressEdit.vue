<!-- =========================================================================================
  File Name: UserEditTabInformation.vue
  Description: User Edit Information Tab content
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->

<template>
  <div id="address-edit-tab">

    <div>
      <vx-card title="Communication Address" class="mb-base">
        <form id="create-user-comm-address" data-vv-scope="comm-address-form" @submit.prevent>

          <div class="vx-row">

            <div class="vx-col md:w-1/2 w-full mt-5">
              <vs-textarea label="Address"
                           v-model="commAddressLocal.address" class="w-full" name="address"
                           v-validate="'required'"/>
              <span class="text-danger">{{ errors.first('comm-address-form.address') }}</span>
            </div>


            <div class="vx-col md:w-1/2 w-full mt-10">
              <vs-input label="Pin Code"
                        v-model="commAddressLocal.pin_code" class="w-full" name="pin_code"
                        v-validate="'required|numeric'"/>
              <span class="text-danger">{{ errors.first('comm-address-form.pin_code') }}</span>
            </div>

            <div class="vx-col md:w-1/2 w-full mt-5">
              <vs-input label="City"
                        v-model="commAddressLocal.city"
                        class="w-full" name="city" v-validate="'required|max:50|min:3'"/>
              <span class="text-danger">{{ errors.first('comm-address-form.city') }}</span>
            </div>

            <div class="vx-col md:w-1/2 w-full mt-5">
              <vs-input
                v-model="commAddressLocal.district"
                label="District"
                class="w-full" name="district" v-validate="'required|max:50|min:3'"/>
              <span class="text-danger">{{ errors.first('comm-address-form.district') }}</span>
            </div>

            <div class="vx-col md:w-1/2 w-full mt-5">
              <vs-input label="State"
                        v-model="commAddressLocal.state"
                        class="w-full" name="state"
                        v-validate="'required|max:50|min:3'"/>
              <span class="text-danger">{{ errors.first('comm-address-form.state') }}</span>
            </div>

            <div class="vx-col md:w-1/2 w-full mt-5">
              <vs-input
                label="Country"
                v-model="commAddressLocal.country" class="w-full"
                name="country" v-validate="'required|min:3|max:50'"/>
              <span class="text-danger">{{ errors.first('comm-address-form.country') }}</span>
            </div>
          </div>
        </form>
      </vx-card>

      <vx-card title="Permanent Address" class="mb-base">
        <form id="create-user-perm-address" data-vv-scope="perm-address-form" @submit.prevent>

          <div class="vx-row">

            <div class="vx-col w-full mt-5 mb-5">
              <vs-checkbox v-model="isPermSameAsComm">Same as the Communication Address</vs-checkbox>
            </div>

            <div class="vx-row m-auto" v-if="!isPermSameAsComm">
              <div class="vx-col md:w-1/2 w-full mt-5">
                <vs-textarea label="Address"
                             v-model="permAddressLocal.address" class="w-full" name="address"
                             v-validate="'required'"/>
                <span class="text-danger">{{ errors.first('perm-address-form.address') }}</span>
              </div>


              <div class="vx-col md:w-1/2 w-full mt-10">
                <vs-input label="Pin Code"
                          v-model="permAddressLocal.pin_code" class="w-full" name="pin_code"
                          v-validate="'required|numeric'"/>
                <span class="text-danger">{{ errors.first('perm-address-form.pin_code') }}</span>
              </div>

              <div class="vx-col md:w-1/2 w-full mt-5">
                <vs-input label="City"
                          v-model="permAddressLocal.city"
                          class="w-full" name="city" v-validate="'required|max:50|min:3'"/>
                <span class="text-danger">{{ errors.first('perm-address-form.city') }}</span>
              </div>

              <div class="vx-col md:w-1/2 w-full mt-5">
                <vs-input
                  label="District"
                  v-model="permAddressLocal.district"
                  class="w-full" name="district" v-validate="'required|max:50|min:3'"/>
                <span class="text-danger">{{ errors.first('perm-address-form.district') }}</span>
              </div>

              <div class="vx-col md:w-1/2 w-full mt-5">
                <vs-input label="State"
                          v-model="permAddressLocal.state"
                          class="w-full" name="state"
                          v-validate="'required|max:50|min:3'"/>
                <span class="text-danger">{{ errors.first('perm-address-form.state') }}</span>
              </div>

              <div class="vx-col md:w-1/2 w-full mt-5">
                <vs-input
                  label="Country"
                  v-model="permAddressLocal.country" class="w-full"
                  name="country" v-validate="'required|min:3|max:50'"/>
                <span class="text-danger">{{ errors.first('perm-address-form.country') }}</span>
              </div>
            </div>

          </div>
        </form>
      </vx-card>
    </div>


    <!-- Save & Reset Button -->
    <div class="vx-row">
      <div class="vx-col w-full">
        <div class="mt-8 flex flex-wrap items-center justify-end">
          <vs-button class="ml-auto mt-2" @click="save_changes" id="save" :disabled="!validateForm">Save Changes
          </vs-button>
          <vs-button class="ml-4 mt-2" type="border" color="warning" @click="reset_data">Reset</vs-button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import jwt from "../../../http/requests/auth/jwt";
  import commons from "../../../commons";

  export default {
    props: {
      commAddress: {
        type: Object,
        required: true
      },
      permAddress: {
        type: Object,
        required: true
      }
    },
    data() {
      return {
        commAddressLocal: JSON.parse(JSON.stringify(this.commAddress)),
        permAddressLocal: JSON.parse(JSON.stringify(this.permAddress)),
        isPermSameAsComm: false,

      }
    },
    computed: {
      validateForm() {
        return !this.errors.any()
      }
    },
    methods: {

      save_changes() {
        if (!this.validateForm) return;

        this.$vs.loading({
          'container': "#save",
          'scale': 0.45
        });

        let permAddTemp = (this.isPermSameAsComm) ? commons.cloneObject(this.commAddressLocal) : this.permAddressLocal;
        permAddTemp.type = "Permanent";

        jwt.putAddress(this.commAddressLocal)
          .then(() => {

            jwt.putAddress(permAddTemp)
              .then((permUpdateResponse) => {

                this.$vs.loading.close("#save > .con-vs-loading");

                this.$vs.notify({
                  title: 'Account Update',
                  text: 'User addresses updated!',
                  iconPack: 'feather',
                  icon: 'icon-alert-circle',
                  color: 'success',
                  position: 'top-right'
                });


                const role = permUpdateResponse.data.user.base_role.toLowerCase();
                let profileData = {
                  user_id: permAddTemp.user_id,
                  user: this.$_.omit(permUpdateResponse.data.user, role)
                };


                this.$store.dispatch('userManagement/upsertToState', {
                  data: profileData,
                  type: permUpdateResponse.data.user.base_role
                });

                if (this.profileData.user_id == this.$store.state.AppActiveUser.id) {

                  this.$store.commit('UPDATE_USER_INFO', profileData);
                }

              }).catch(error => {

              console.log(error);

              this.$vs.loading.close("#save > .con-vs-loading");

              this.$vs.notify({
                title: 'Error',
                text: "Error updating user permanent address",
                iconPack: 'feather',
                icon: 'icon-alert-circle',
                color: 'danger',
                position: 'top-right'
              })
            });

          })
          .catch(error => {

            console.log(error);

            this.$vs.loading.close("#save > .con-vs-loading");

            this.$vs.notify({
              title: 'Error',
              text: "Error updating user communication address",
              iconPack: 'feather',
              icon: 'icon-alert-circle',
              color: 'danger',
              position: 'top-right'
            })
          })
      },

      reset_data() {
        this.commAddressLocal = JSON.parse(JSON.stringify(this.commAddress));
        this.permAddressLocal = JSON.parse(JSON.stringify(this.permAddress));
      },

      update_avatar() {

      },

    },
  }
</script>
