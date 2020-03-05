<template>
  <div class="vx-row -mx-2">

    <vs-button class="mt-2 mr-3" icon-pack="feather" icon="icon-lock" @click="viewRole(listItem.id)" size="small"
                 v-for="(listItem) in params.data.roles" :key="listItem.id"> {{listItem.name}} </vs-button>
<!--      <vs-chip size="small" color="success" @click="viewRole(listItem.id)"-->
<!--             v-for="(listItem) in params.data.roles" :key="listItem.id">-->
<!--      <vs-avatar icon-pack="feather" icon="icon-lock"/>-->
<!--      {{ listItem.name }}-->
<!--    </vs-chip>-->
  </div>


</template>

<script>
  import Vue from "vue";

  export default Vue.extend({
    methods: {
      viewRole(id) {
        this.$router.push({name: 'sms-role-specific-view', params: {id: id}})
      },
    }

  });
</script>
