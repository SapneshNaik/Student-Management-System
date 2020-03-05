<!-- =========================================================================================
    File Name: ChatContact.vue
    Description: Chat contact - single component for chat
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
      Author: Pixinvent
    Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->

<template>
    <div class="chat__contact flex items-center px-2 pt-4 pb-2" :class="{'bg-primary-gradient text-white shadow-lg': isActiveChatUser}">
        <div class="contact__avatar mr-1">
            <vs-avatar class="border-2 border-solid border-white" :src="contact.photoURL" size="42px" />
        </div>
        <div class="contact__container w-full flex items-center justify-between overflow-hidden">
            <div class="contact__info flex flex-col truncate w-5/6">
                <h5 class="font-semibold" :class="{'text-white': isActiveChatUser}">{{ contact.displayName }}</h5>
                <span class="truncate">{{ showLastMsg ? $store.getters['chat/chatLastMessaged'](contact.uid).textContent : contact.about }}</span>
            </div>

            <div class="chat__contact__meta flex self-start flex-col items-end w-1/6">
                <span class="whitespace-no-wrap">{{ lastMessaged | date }}</span>
                <vs-chip class="number" color="primary" v-if="unseenMsg">{{ unseenMsg }}</vs-chip>
            </div>
        </div>
    </div>
</template>

<script>
export default {
  props: {
    contact          : { type: Object,  required: true, },
    isActiveChatUser : { type: Boolean },
    lastMessaged     : { type: String,  default : "", },
    showLastMsg      : { type: Boolean, default: false },
    unseenMsg        : { type: Number,  default : 0, }
  },
}
</script>

