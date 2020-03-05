<template>
  <div class="the-navbar__user-meta flex items-center" v-if="activeUserInfo.login_id">

    <div class="text-right leading-tight hidden sm:block">
      <p class="font-semibold">{{ activeUserInfo.name ? activeUserInfo.name : activeUserInfo.login_id }}</p>
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
            @click="$router.push({name: 'sms-user-profile', params: { id: activeUserInfo.id, role: activeUserInfo.base_role }}).catch(() => {})">
            <feather-icon icon="UserIcon" svgClasses="w-4 h-4"/>
            <span class="ml-2">Profile</span>
          </li>

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

  import commons from "../../../../commons";

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

        this.$store.commit('userManagement/RESET_ALL');

        commons.clearLocalStorage();

        this.$router.push('/login');


        this.$store.dispatch("auth/logoutJWT")
          // eslint-disable-next-line
          .then(res => {

            this.$vs.notify({
              text: 'Logged out',
              iconPack: 'feather',
              icon: 'icon-log-out',
              color: 'success'
            });

          })
          .catch(err => {
            this.$vs.notify({
              text: err.message,
              iconPack: 'feather',
              icon: 'icon-log-out',
              color: 'error'
            })

            // this.$router.push('/login');

            console.log("logout")
          });

      },
    }
  }
</script>
