<template>
  <vx-card no-shadow>

    <!-- Bio -->
    <vs-textarea label="Bio" v-model="bio" placeholder="Your bio..." />

    <!-- DOB -->
    <div class="mt-8">
      <label class="text-sm">Birth Date</label>
      <flat-pickr v-model="dob" :config="{ dateFormat: 'd F Y' }" class="w-full" />
    </div>

    <!-- Country -->
    <div class="mt-8">
      <label class="text-sm">Country</label>
      <v-select v-model="country" :options="countryOptions" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
    </div>

    <!-- Languages -->
    <div class="mt-8">
      <label class="text-sm">Languages</label>
      <v-select v-model="lang_known" multiple :closeOnSelect="false" :options="langOptions" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
    </div>

    <!-- Mobile Number -->
    <vs-input class="w-full mt-8" type="number" label-placeholder="Mobile" v-model="mobile" />

    <!-- Website  -->
    <vs-input class="w-full mt-8" label-placeholder="Website" v-model="website" />

    <!-- Gender -->
    <div class="mt-8 mb-base">
      <label class="text-sm">Gender</label>
      <div class="mt-2">
        <vs-radio v-model="gender" vs-value="male" class="mr-4">Male</vs-radio>
        <vs-radio v-model="gender" vs-value="female" class="mr-4">Female</vs-radio>
        <vs-radio v-model="gender" vs-value="other">Other</vs-radio>
      </div>
    </div>

    <!-- Save & Reset Button -->
    <div class="flex flex-wrap items-center justify-end">
      <vs-button class="ml-auto mt-2">Save Changes</vs-button>
      <vs-button class="ml-4 mt-2" type="border" color="warning">Reset</vs-button>
    </div>
  </vx-card>
</template>

<script>
import flatPickr from 'vue-flatpickr-component'
import 'flatpickr/dist/flatpickr.css'
import vSelect from 'vue-select'

export default {
  components: {
    flatPickr,
    vSelect
  },
  data() {
    return {
      bio: this.$store.state.AppActiveUser.about,
      dob: null,
      country: "USA",
      lang_known: ["English", "Russian"],
      gender: "male",
      mobile: "",
      website: "",

      // Options
      countryOptions: [
        { label: "Australia",  value: "australia"  },
        { label: "France",     value: "france"     },
        { label: "Germany",    value: "germany"    },
        { label: "India",      value: "india"      },
        { label: "Jordan",     value: "jordan"     },
        { label: "Morocco",    value: "morocco"    },
        { label: "Portuguese", value: "portuguese" },
        { label: "Syria",      value: "syria"      },
        { label: "USA",        value: "usa"        },
      ],
      langOptions: [
        { label: "English",  value: "english"  },
        { label: "Spanish",  value: "spanish"  },
        { label: "French",   value: "french"   },
        { label: "Russian",  value: "russian"  },
        { label: "German",   value: "german"   },
        { label: "Arabic",   value: "arabic"   },
        { label: "Sanskrit", value: "sanskrit" },
      ],
    }
  },
  computed: {
    activeUserInfo() {
      return this.$store.state.AppActiveUser
    },
  }
}
</script>
