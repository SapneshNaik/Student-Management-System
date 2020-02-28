<template>
  <vx-card no-shadow>

    <div class="mb-base">
      <h6 class="mb-4">Activity</h6>

      <div class="flex items-center mb-4">
        <vs-switch v-model="comment" />
        <span class="ml-4">Email me when someone comments onmy article</span>
      </div>
      <div class="flex items-center mb-4">
        <vs-switch v-model="answer" />
        <span class="ml-4">Email me when someone answers on my form</span>
      </div>
      <div class="flex items-center mb-4">
        <vs-switch v-model="follow" />
        <span class="ml-4">Email me hen someone follows me</span>
      </div>
    </div>

    <div>
      <h6 class="mb-4">Application</h6>

      <div class="flex items-center mb-4">
        <vs-switch v-model="news" />
        <span class="ml-4">News and announcements</span>
      </div>
      <div class="flex items-center mb-4">
        <vs-switch v-model="product_update" />
        <span class="ml-4">Weekly product updates</span>
      </div>
      <div class="flex items-center">
        <vs-switch v-model="blog" />
        <span class="ml-4">Weekly blog digest</span>
      </div>
    </div>

    <!-- Save & Reset Button -->
    <div class="flex flex-wrap items-center justify-end mt-base">
      <vs-button class="ml-auto mt-2">Save Changes</vs-button>
      <vs-button class="ml-4 mt-2" type="border" color="warning">Reset</vs-button>
    </div>

  </vx-card>
</template>

<script>
export default {
  data() {
    return {
      comment: true,
      answer: true,
      follow: false,
      news: false,
      product_update: false,
      blog: true,
    }
  },
  computed: {
    activeUserInfo() {
      return this.$store.state.AppActiveUser
    },
  }
}
</script>
