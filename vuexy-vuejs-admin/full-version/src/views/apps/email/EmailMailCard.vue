<!-- =========================================================================================
    File Name: EmailMailCard.vue
    Description: Email Application - Single Email Card View
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
      Author: Pixinvent
    Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->

<template functional>
  <vx-card class="px-4" :class="data.staticClass">
    <!-- MAIL HEAD -->
    <div class="vx-row">
      <div class="vx-col w-full border-b border-l-0 border-r-0 border-t-0 d-theme-border-grey-light border-solid flex justify-between flex items-center">
        <!-- Sender Details -->
        <div class="flex items-center">
          <div>
            <vs-avatar class="sender__avatar--single flex-shrink-0 mr-3 border-2 border-solid border-white" :src="props.mailContent.img" size="65px" />
          </div>

          <div class="flex flex-col">
            <h5 class="mb-1">{{ props.mailContent.sender_name }}</h5>
            <div class="flex items-center">
              <span class="text-sm">{{ props.mailContent.sender }}</span>
              <vs-dropdown vs-custom-content vs-trigger-click class="inline-flex cursor-pointer">
                <feather-icon icon="ChevronDownIcon" class="w-3 h-3" />
                <vs-dropdown-menu style="z-index: 40001">
                  <div class="p-2">
                    <p class="text-sm mb-1">From: <span class="font-semibold"> {{ props.mailContent.sender }} </span></p>
                    <p class="text-sm mb-1">To: <span class="font-semibold"> {{ props.mailContent.to | csv }} </span></p>
                    <p class="text-sm mb-1">Date: <span class="font-semibold"> {{ props.mailContent.time | time }} {{ props.mailContent.time | date(true) }} </span></p>
                    <p class="text-sm mb-1" v-if="props.mailContent.cc.length">cc: <span class="font-semibold"> {{ props.mailContent.cc | csv }} </span></p>
                  </div>
                </vs-dropdown-menu>
              </vs-dropdown>
            </div>
          </div>
        </div>
        <!-- /Sender Details -->

        <!-- Mail Time & Date -->
        <div class="flex flex-col justify-end">
          <span class="text-right">{{ props.mailContent.time | time }}</span>
          <div class="flex justify-end mt-2">
            <span class="text-right">{{ props.mailContent.time | date(true) }}</span>
          </div>
        </div>
      </div>
      <!-- /Mail Time & Date -->
    </div>

    <!-- MAIL CONTENT -->
    <div class="vx-row">
      <div class="vx-col w-full">
        <div class="mail__content break-words mt-8 mb-4" v-html="props.mailContent.message"></div>
      </div>
    </div>

    <!-- MAIL ATTACHMENTS -->
    <div class="vx-row" v-if="props.mailContent.attachments.length">
      <div class="vx-col w-full border-b border-l-0 border-r-0 border-t-0 d-theme-border-grey-light border-solid mb-6 flex">
        <feather-icon icon="PaperclipIcon" class="mr-2" />
        <span class="block py-4">ATTACHMENTS</span>
      </div>
      <div class="flex">
        <div class="mail__attachment" v-for="(attachment, index) in props.mailContent.attachments" :key="index">
          <vs-chip color="primary" class="px-4 py-2 mr-3">{{ attachment }}</vs-chip>
        </div>
      </div>
    </div>
  </vx-card>
</template>

<script>
export default {
  props: {
    mailContent: {
      type: Object,
      required: true
    }
  }
}
</script>
