<template>
  <div class="vx-row">

    <div class="vx-col w-full" id="all_role_div">

      <vx-card :title="roleData.name + ' Role'" class="mb-base">


        <div class="vx-row">

          <div class="vx-col lg:w-1/2 w-full">

            <vx-card title="Permissions" class="mb-base">

              <vs-divider/>

              <!-- List 1 -->
              <div class="vx-row">
                <div class="vx-col w-full">
                  <transition-group>
                    <vs-chip class="m-1" color="success"
                             v-for="(listItem) in roleData.permissions" :key="listItem.id">
                      <vs-avatar icon-pack="feather" icon="icon-shield"/>
                      {{ listItem.name }}
                    </vs-chip>
                  </transition-group>

                </div>
              </div>

            </vx-card>
          </div>


          <div class="vx-col lg:w-1/2 w-full">

            <vx-card title="Users" class="mb-base">

              <vs-divider/>

              <!-- List 1 -->
              <div class="vx-row">
                <div class="vx-col w-full">
                  <transition-group>


                    <vs-chip class="m-1" color="#24c1a0" closable
                             icon-pack="feather"
                             close-icon="icon-log-in"
                             @click="goToUserPage(listItem.id, listItem.base_role)" v-for="(listItem) in roleData.users"
                             :key="listItem.id">
                      <vs-avatar :src="require('@/assets/images/portrait/small/avatar-s-11.jpg')"/>
                      {{ listItem.login_id }}
                    </vs-chip>
                  </transition-group>

                </div>
              </div>

            </vx-card>
          </div>

        </div>

      </vx-card>

    </div>

  </div>


</template>

<script>

  import draggable from "vuedraggable";
  import commons from "../../../commons";


  export default {
    components: {
      draggable
    },
    computed: {
      roleData() {
        return commons.getUserDataFromRole("Role", this.$route.params.id, this.$store.state);
      },
    },

    methods: {

      fetchData() {

        if (this.roleData == null) {
          this.$vs.loading();
        }

        this.$store.dispatch("userManagement/fetchRole", this.$route.params.id)
          .then(response => {
            this.$vs.loading.close();

            this.$store.dispatch("userManagement/upsertToState",
              {type: "Role", data: response.data});

            this.$vs.notify({
              title: 'Role data updated from the backend',
              iconPack: 'feather',
              icon: 'icon-alert-circle',
              position: 'top-right',
              color: 'success'
            });

          }).catch(err => {
          console.log(err)

          this.$vs.notify({
            title: 'Failed to fetch Role from the serve',
            iconPack: 'feather',
            icon: 'icon-alert-circle',
            position: 'top-right',
            color: 'danger'
          });

          this.$vs.loading.close();

          if (err.response.status === 401) {
            this.$router.push({name: 'login'});
          } else if (err.response.status === 404) {
            this.$router.push({name: 'page-error-404'});
          } else if (err.response.status === 403) {
            alert(err.response.message)
            this.$router.push({name: 'dashboard-sms'});
          }

        })


      },

      goToUserPage(id, role) {
        this.$router.push({name: 'sms-user-profile', params: {id: id, role: role}}).catch(() => {
        })
      }


    },


    created() {
      this.fetchData();
    }
  }
</script>
