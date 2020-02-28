<!-- =========================================================================================
    File Name: EmailView.vue
    Description: Email Application - Single Email View (Inbox)
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
      Author: Pixinvent
    Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->


<template>
    <div>
        <vs-sidebar click-not-close parent="#email-app" :hidden-background="true" class="full-vs-sidebar email-view-sidebar items-no-padding" v-model="isSidebarActive" position-right>
            <div class="mail-sidebar-content px-0 sm:pb-6 h-full" v-if="currentMail">
                <div class="flex flex-wrap items-center email-header justify-between md:px-8 px-6 sm:pb-2 sm: pt-6 d-theme-dark-bg">
                    <div class="flex mb-4">
                        <div class="flex items-center">
                            <feather-icon :icon="$vs.rtl ? 'ArrowRightIcon' : 'ArrowLeftIcon'" @click="$emit('closeSidebar')" class="cursor-pointer mr-4" svg-classes="w-6 h-6"></feather-icon>
                            <h4 v-if="currentMail.subject">{{ currentMail.subject }}</h4>
                            <h4 v-else>(no subject)</h4>
                        </div>
                    </div>
                    <div class="ml-10 mb-4 mt-1">
                        <div class="email__actions--single flex items-baseline">

                            <feather-icon icon="StarIcon" class="cursor-pointer" :svgClasses="[{'text-warning stroke-current stroke-current': currentMail.isStarred}, 'h-6 w-6']" @click="toggleIsStarred" />

                            <!-- MOVE TO DROPDOWN -->
                            <vs-dropdown vs-custom-content vs-trigger-click class="cursor-pointer" v-if="mailFilter != 'sent'">
                                <feather-icon icon="FolderIcon" svg-classes="h-6 w-6" class="ml-4"></feather-icon>
                                <vs-dropdown-menu>
                                  <vs-dropdown-item @click="moveTo('inbox')" v-if="currentMail.mailFolder != 'inbox'">
                                    <span class="flex items-center">
                                      <feather-icon icon="MailIcon" svgClasses="h-4 w-4" class="mr-2" />
                                      <span>Inbox</span>
                                    </span>
                                  </vs-dropdown-item>

                                  <vs-dropdown-item @click="moveTo('draft')" v-if="currentMail.mailFolder != 'draft'">
                                    <span class="flex items-center">
                                      <feather-icon icon="Edit2Icon" svgClasses="h-4 w-4" class="mr-2" />
                                      <span>Draft</span>
                                    </span>
                                  </vs-dropdown-item>

                                  <vs-dropdown-item @click="moveTo('spam')" v-if="currentMail.mailFolder != 'spam'">
                                    <span class="flex items-center">
                                      <feather-icon icon="InfoIcon" svgClasses="h-4 w-4" class="mr-2" />
                                      <span>Spam</span>
                                    </span>
                                  </vs-dropdown-item>

                                  <vs-dropdown-item @click="moveTo('trash')" v-if="currentMail.mailFolder != 'trash'">
                                    <span class="flex items-center">
                                      <feather-icon icon="TrashIcon" svgClasses="h-4 w-4" class="mr-2" />
                                      <span>Trash</span>
                                    </span>
                                  </vs-dropdown-item>
                                </vs-dropdown-menu>
                            </vs-dropdown>

                            <!-- ADD LABEL DROPDOWN -->
                            <vs-dropdown vs-custom-content vs-trigger-click class="cursor-pointer">
                                <feather-icon icon="TagIcon" svg-classes="h-6 w-6" class="cursor-pointer ml-4"></feather-icon>
                                <vs-dropdown-menu style="z-index: 40001">
                                        <vs-dropdown-item v-for="(label, index) in emailTags" :key="index">
                                            <vs-checkbox @click.stop :vs-value="label.value" v-model="currentMailLabels">{{ label.text }}</vs-checkbox>
                                        </vs-dropdown-item>
                                </vs-dropdown-menu>
                            </vs-dropdown>

                            <feather-icon icon="MailIcon" svg-classes="h-6 w-6" class="cursor-pointer ml-4" @click="$emit('markUnread')"></feather-icon>
                            <feather-icon v-if="currentMail.mailFolder != 'trash'" icon="TrashIcon" svg-classes="h-6 w-6" class="cursor-pointer ml-4" @click="$emit('removeMail')"></feather-icon>
                            <feather-icon :icon="$vs.rtl ? 'ChevronsRightIcon' : 'ChevronsLeftIcon'" svg-classes="h-6 w-6" class="cursor-pointer ml-4 hidden sm:inline-flex" @click="$emit('previousMail')" />
                            <feather-icon :icon="$vs.rtl ? 'ChevronsLeftIcon' : 'ChevronsRightIcon'" svg-classes="h-6 w-6" class="cursor-pointer ml-4 hidden sm:inline-flex" @click="$emit('nextMail')" />
                        </div>
                    </div>
                </div>

                <component :is="scrollbarTag" class="scroll-area-mail-content md:px-8 md:pb-8 pt-4 px-6 pb-6" :settings="settings" :key="$vs.rtl">
                <!-- LABEL ROW -->
                <div class="vx-row">
                    <div class="vx-col w-full">
                        <div class="email__labels--single flex ml-10 items-center mt-2">
                            <transition-group name="list" tag="div" class="flex">
                                <div v-for="label in currentMail.labels" :key="label" class="open-mail-label flex items-center mr-4">
                                    <div class="h-3 w-3 rounded-full mr-1" :class="'bg-' + labelColor(label)"></div>
                                    <span class="text-sm">{{ label | capitalize }}</span>
                                </div>
                            </transition-group>
                        </div>
                    </div>
                </div>
                <!-- /LABEL ROW -->
                <br>

                <div class="vx-row mb-4" v-if="currentMail.replies.length && !showThread">
                    <div class="vx-col w-full">
                        <span class="text-primary font-medium ml-10 cursor-pointer" @click="showThread = true">{{ currentMail.replies.length }} Earlier Messages</span>
                    </div>
                </div>
                <div v-if="isSidebarActive">

                    <!-- ALL MESSAGES - THREAD -->
                    <div class="vx-row" v-for="threadMail in currentMail.replies.slice().reverse()" :key="threadMail.id" v-if="showThread">
                        <div class="vx-col w-full">
                            <email-mail-card :mailContent="threadMail" class="mb-10" />
                        </div>
                    </div>

                    <!-- LATEST MESSAGE -->
                    <div class="vx-row">
                        <div class="vx-col w-full">
                          <email-mail-card :mailContent="currentMail" />
                        </div>
                    </div>

                    <div class="vx-row" style="margin-top: 2.2rem">
                        <div class="vx-col w-full">
                            <vx-card>
                                <div class="vx-row">
                                    <div class="vx-col w-full flex justify-between">
                                        <span class="text-lg">Click here to <span class="text-primary font-semibold cursor-pointer">Reply</span> or <span class="text-primary font-semibold cursor-pointer">Forward</span></span>
                                        <feather-icon icon="PaperclipIcon"></feather-icon>
                                    </div>
                                </div>
                            </vx-card>
                        </div>
                    </div>
                </div>
                </component>
            </div>
        </vs-sidebar>
    </div>
</template>

<script>
import VuePerfectScrollbar from 'vue-perfect-scrollbar'
import EmailMailCard from "./EmailMailCard.vue"

export default {
  props: {
    emailTags: {
      type: Array,
      required: true,
    },
    openMailId: {
      required: true,
      validator: prop => typeof prop === 'number' || prop === null
    },
    isSidebarActive: {
      type: Boolean,
      required: true
    },
    mailFilter: {
      type: String
    }
  },
  data() {
    return {
      showThread: false,
      settings: {
        maxScrollbarLength: 60,
        wheelSpeed: 0.50,
      },
    }
  },
  watch: {
    isSidebarActive(value) {
      if (!value) {
        this.$emit('closeSidebar')
        setTimeout(() => {
          this.showThread = false
        }, 500)
      }
    },
  },
  computed: {
    currentMail() {
      return this.$store.getters['email/getMail'](this.openMailId)
    },
    labelColor() {
      return (label) => {
        const tags = this.$store.state.email.mailTags
        return tags.find((tag) => {
          return tag.value == label
        }).color
      }
    },
    currentMailLabels: {
      get() {
        return this.currentMail.labels
      },
      set(value) {
        if (Array.isArray(value)) {
          const payload = { mailId: this.openMailId, labels: value }
          this.$store.dispatch('email/setLabels', payload)
        }
      }
    },
    scrollbarTag() { return this.$store.getters.scrollbarTag },
  },
  methods: {
    toggleIsStarred() {
      const payload = { mailId: this.openMailId, value: !this.currentMail.isStarred }
      this.$store.dispatch('email/toggleIsMailStarred', payload)
    },
    moveTo(to) {
      this.$emit('closeSidebar')
      this.$emit('moveTo', to)
    }
  },
  components: {
    VuePerfectScrollbar,
    EmailMailCard
  },
  updated() {
    if (!this.currentMail) return
    if (this.currentMail.unread && this.isSidebarActive) this.$store.dispatch('email/setUnread', { emailIds: [this.openMailId], unread: false });
  },
}

</script>

