<!-- =========================================================================================
    File Name: KnowledgeBase.vue
    Description: Knowledge Base Page
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
      Author: Pixinvent
    Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->


<template>
    <div id="knowledge-base-page">
        <!-- JUMBOTRON -->
        <div class="knowledge-base-jumbotron">
            <div class="knowledge-base-jumbotron-content lg:p-32 md:p-24 sm:p-16 p-8 rounded-lg mb-base">
                <h1 class="mb-1 text-white">Dedicated Source Used on Website</h1>
                <p class="text-white">Bonbon sesame snaps lemon drops marshmallow ice cream carrot cake croissant wafer.</p>
                <vs-input icon-no-border placeholder="Search Topic or Keyword" v-model="knowledgeBaseSearchQuery" icon-pack="feather" icon="icon-search" size="large" class="w-full mt-6" />
            </div>
        </div>

        <!-- KNOWLEDGE BASE CARDS  -->
        <div class="vx-row">
                <div class="vx-col w-full md:w-1/3 sm:w-1/2 mb-base" v-for="item in filteredKB" :key="item.id" @click="$router.push(item.url).catch(() => {})">
                    <vx-card class="text-center cursor-pointer">
                        <img :src="item.graphic" alt="graphic" width="180" class="mx-auto mb-4">
                        <h4 class="mb-2">{{ item.title.toUpperCase() }}</h4>
                        <small>{{ item.description }}</small>
                    </vx-card>
                </div>
            </div>
    </div>
</template>

<script>

export default{
    data() {
        return {
            knowledgeBaseSearchQuery: '',
            kb: [
                {
                  id          : 1,
                  title       : 'Sales Automation',
                  description : 'Muffin lemon drops chocolate carrot cake chocolate bar sweet roll.',
                  graphic     : require("@/assets/images/pages/graphic-1.png"),
                  url         : '/pages/knowledge-base/category'
                },
                {
                  id          : 2,
                  title       : 'Marketing Automation',
                  description : 'Gingerbread sesame snaps wafer soufflé. Macaroon brownie ice cream',
                  graphic     : require("@/assets/images/pages/graphic-2.png"),
                  url         : '/pages/knowledge-base/category'
                },
                {
                  id          : 3,
                  title       : 'Marketing BI',
                  description : 'cotton candy caramels danish chocolate cake pie candy. Lemon drops tart.',
                  graphic     : require("@/assets/images/pages/graphic-3.png"),
                  url         : '/pages/knowledge-base/category'
                },
                {
                  id          : 4,
                  title       : 'Personalization',
                  description : 'Pudding oat cake carrot cake lemon drops gummies marshmallow.',
                  graphic     : require("@/assets/images/pages/graphic-4.png"),
                  url         : '/pages/knowledge-base/category'
                },
                {
                  id          : 5,
                  title       : 'Email Marketing',
                  description : 'Gummi bears pudding icing sweet caramels chocolate',
                  graphic     : require("@/assets/images/pages/graphic-5.png"),
                  url         : '/pages/knowledge-base/category'
                },
                {
                  id          : 6,
                  title       : 'Demand Generation',
                  description : 'Dragée jelly beans candy canes pudding cake wafer. Muffin croissant.',
                  graphic     : require("@/assets/images/pages/graphic-6.png"),
                  url         : '/pages/knowledge-base/category'
                },
            ]
        }
    },
    computed: {
        filteredKB() {
            return this.kb.filter((item) => item.title.toLowerCase().includes(this.knowledgeBaseSearchQuery.toLowerCase()) || item.description.toLowerCase().includes(this.knowledgeBaseSearchQuery.toLowerCase()));
        }
    },
    methods: {},
    components: {}
}
</script>

<style lang="scss">
.knowledge-base-jumbotron-content {
    background-image: url('../../assets/images/pages/knowledge-base-cover.jpg');
    background-size: cover;
}
</style>
