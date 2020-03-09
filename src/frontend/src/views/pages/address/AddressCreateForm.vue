<template>
  <div>
    <vx-card title="Communication Address" class="mb-base">
      <form id="create-user-comm-address" data-vv-scope="comm-address-form" @submit.prevent>

        <div class="vx-row">

          <div class="vx-col md:w-1/2 w-full mt-5">
            <vs-textarea label="Address"
                         v-model="commAddress.address" class="w-full" name="address"
                         v-validate="'required'"/>
            <span class="text-danger">{{ errors.first('comm-address-form.address') }}</span>
          </div>


          <div class="vx-col md:w-1/2 w-full mt-10">
            <vs-input :disabled="read_only" label="Pin Code"
                      v-model="commAddress.pin_code" class="w-full" name="pin_code"
                      v-validate="'required|numeric'"/>
            <span class="text-danger">{{ errors.first('comm-address-form.pin_code') }}</span>
          </div>

          <div class="vx-col md:w-1/2 w-full mt-5">
            <vs-input :disabled="read_only" label="City"
                      v-model="commAddress.city"
                      class="w-full" name="city" v-validate="'required|max:50|min:3'"/>
            <span class="text-danger">{{ errors.first('comm-address-form.city') }}</span>
          </div>

          <div class="vx-col md:w-1/2 w-full mt-5">
            <vs-input :disabled="read_only"
                      v-model="commAddress.district"
                      label="District"
                      class="w-full" name="district" v-validate="'required|max:50|min:3'"/>
            <span class="text-danger">{{ errors.first('comm-address-form.district') }}</span>
          </div>

          <div class="vx-col md:w-1/2 w-full mt-5">
            <vs-input :disabled="read_only" label="State"
                      v-model="commAddress.state"
                      class="w-full" name="state"
                      v-validate="'required|max:50|min:3'"/>
            <span class="text-danger">{{ errors.first('comm-address-form.state') }}</span>
          </div>

          <div class="vx-col md:w-1/2 w-full mt-5">
            <vs-input :disabled="read_only"
                      label="Country"
                      v-model="commAddress.country" class="w-full"
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

          <div class="vx-row w-full ml-2 mr-1" v-if="!isPermSameAsComm">
            <div class="vx-col md:w-1/2 w-full mt-5">
              <vs-textarea :disabled="read_only" label="Address"
                           v-model="permAddress.address" class="w-full" name="address"
                           v-validate="'required'"/>
              <span class="text-danger">{{ errors.first('perm-address-form.address') }}</span>
            </div>


            <div class="vx-col md:w-1/2 w-full mt-10">
              <vs-input :disabled="read_only" label="Pin Code"
                        v-model="permAddress.pin_code" class="w-full" name="pin_code"
                        v-validate="'required|numeric'"/>
              <span class="text-danger">{{ errors.first('perm-address-form.pin_code') }}</span>
            </div>

            <div class="vx-col md:w-1/2 w-full mt-5">
              <vs-input :disabled="read_only" label="City"
                        v-model="permAddress.city"
                        class="w-full" name="city" v-validate="'required|max:50|min:3'"/>
              <span class="text-danger">{{ errors.first('perm-address-form.city') }}</span>
            </div>

            <div class="vx-col md:w-1/2 w-full mt-5">
              <vs-input :disabled="read_only"
                        label="District"
                        v-model="permAddress.district"
                        class="w-full" name="district" v-validate="'required|max:50|min:3'"/>
              <span class="text-danger">{{ errors.first('perm-address-form.district') }}</span>
            </div>

            <div class="vx-col md:w-1/2 w-full mt-5">
              <vs-input :disabled="read_only" label="State"
                        v-model="permAddress.state"
                        class="w-full" name="state"
                        v-validate="'required|max:50|min:3'"/>
              <span class="text-danger">{{ errors.first('perm-address-form.state') }}</span>
            </div>

            <div class="vx-col md:w-1/2 w-full mt-5">
              <vs-input :disabled="read_only"
                        label="Country"
                        v-model="permAddress.country" class="w-full"
                        name="country" v-validate="'required|min:3|max:50'"/>
              <span class="text-danger">{{ errors.first('perm-address-form.country') }}</span>
            </div>
          </div>

        </div>
      </form>
    </vx-card>
  </div>
</template>

<script>

  export default {
    props: {
      commAddress: {
        type: Object,
        required: true
      },
      permAddress: {
        type: Object,
        required: true
      },
      read_only: {
        type: Boolean,
        required: false,
        default: false
      }
    },


    data() {
      return {
        isPermSameAsComm: false,
      }
    },
    methods: {
      validateInput() {
        return new Promise((resolve, reject) => {
          this.$validator.validateAll('comm-address-form').then(commResult => {
            if (commResult) {
              this.$validator.validateAll('perm-address-form').then(result => {
                if (result) {
                  resolve(true)
                } else {
                  reject("correct perm form values");
                }
              })
            } else {
              reject("correct comm form values");
            }
          })
        })
      }
    }
  }
</script>
