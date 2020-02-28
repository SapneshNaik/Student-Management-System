<template>
  <div class="the-navbar__user-meta flex items-center" v-if="activeUserInfo.login_id">

    <div class="text-right leading-tight hidden sm:block">
      <p class="font-semibold">{{ activeUserInfo.login_id }}</p>
      <small>{{ activeUserInfo.base_role }}</small>
    </div>

    <vs-dropdown vs-custom-content vs-trigger-click class="cursor-pointer">

      <div class="con-img ml-3">
        <img key="onlineImg" :src="activeUserInfo.photoURL" alt="user-img" width="40"
             height="40" class="rounded-full shadow-md cursor-pointer block"/>
      </div>

      <vs-dropdown-menu class="vx-navbar-dropdown">
        <ul style="min-width: 9rem">

          <li
            class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white"
            @click="$router.push({name: 'sms-user-profile', params: { id: activeUserInfo.id }}).catch(() => {})">
            <feather-icon icon="UserIcon" svgClasses="w-4 h-4"/>
            <span class="ml-2">Profile</span>
          </li>

          <!--          <li-->
          <!--            class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white"-->
          <!--            @click="$router.push('/apps/email').catch(() => {})">-->
          <!--            <feather-icon icon="MailIcon" svgClasses="w-4 h-4"/>-->
          <!--            <span class="ml-2">Inbox</span>-->
          <!--          </li>-->

          <!--          <li-->
          <!--            class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white"-->
          <!--            @click="$router.push('/apps/todo').catch(() => {})">-->
          <!--            <feather-icon icon="CheckSquareIcon" svgClasses="w-4 h-4"/>-->
          <!--            <span class="ml-2">Tasks</span>-->
          <!--          </li>-->

          <!--          <li-->
          <!--            class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white"-->
          <!--            @click="$router.push('/apps/chat').catch(() => {})">-->
          <!--            <feather-icon icon="MessageSquareIcon" svgClasses="w-4 h-4"/>-->
          <!--            <span class="ml-2">Chat</span>-->
          <!--          </li>-->

          <!--          <li-->
          <!--            class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white"-->
          <!--            @click="$router.push('/apps/eCommerce/wish-list').catch(() => {})">-->
          <!--            <feather-icon icon="HeartIcon" svgClasses="w-4 h-4"/>-->
          <!--            <span class="ml-2">Wish List</span>-->
          <!--          </li>-->

          <vs-divider class="m-1"/>

          <li
            class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white"
            @click="logoutJWT">
            <feather-icon icon="LogOutIcon" svgClasses="w-4 h-4"/>
            <span class="ml-2">Logout</span>
          </li>
        </ul>
      </vs-dropdown-menu>
    </vs-dropdown>
  </div>
</template>

<script>

  export default {
    data() {
      return {}
    },
    computed: {
      activeUserInfo() {
        return this.$store.state.AppActiveUser
      }
      //TODO: fetch name here if available from role_data
    },
    methods: {
      logoutJWT() {

        this.$store.dispatch("auth/logoutJWT")
          // eslint-disable-next-line
          .then(res => {

            this.$vs.notify({
              text: 'Logged out',
              iconPack: 'feather',
              icon: 'icon-log-out',
              color: 'success'
            });

            this.$acl.change('admin');

            this.$router.push('/login');

          })
          .catch(err => {
            this.$vs.notify({
              text: 'Error logging out',
              iconPack: 'feather',
              icon: 'icon-log-out',
              color: 'error'
            })

            // this.$router.push('/login');

            console.log("logout")
            console.error(err)
          });

      },
    }
  }
</script>
