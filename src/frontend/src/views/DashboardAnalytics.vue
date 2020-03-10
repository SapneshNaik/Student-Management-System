<template>
  <div id="dashboard-sms">
<!--    <div class="vx-row">-->

<!--      <div v-if="canSeeStudentStats" class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base">-->
<!--        <statistics-card-line icon="UsersIcon" :statistic="studentStats.count" statisticTitle="Total Students"-->
<!--                              :chartData="studentStats.series" type='area'></statistics-card-line>-->
<!--      </div>-->

<!--      <div v-if="canSeeParentStats" class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base">-->
<!--        <statistics-card-line icon="UsersIcon" :statistic="parentStats.count" statisticTitle="Total Parents"-->
<!--                              :chartData="parentStats.series" type='area'></statistics-card-line>-->
<!--      </div>-->

<!--      <div v-if="canSeeStaffStats" class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base">-->
<!--        <statistics-card-line icon="UsersIcon" :statistic="staffStats.count" statisticTitle="Total Staff"-->
<!--                              :chartData="staffStats.series" type='area'></statistics-card-line>-->
<!--      </div>-->

<!--      <div v-if="canSeeAdminStats" class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base">-->
<!--        <statistics-card-line icon="UsersIcon" :statistic="adminStats.count" statisticTitle="Total Admins"-->
<!--                              :chartData="adminStats.series" type='area'></statistics-card-line>-->
<!--      </div>-->

<!--    </div>-->

    <div class="vx-row mb-base">

      <div class="vx-col w-full md:w-1/4 lg:w-1/4 xl:w-1/4">
        <statistics-card-line
          class="md:mb-0 mb-base"
          icon="UserIcon"
          icon-right
          :statistic="studentStats.count"
          statisticTitle="Active Students"
          :chartData="studentStats.series"
          type='area'
          color="success"
        />
      </div>

      <div class="vx-col w-full md:w-1/4 lg:w-1/4 xl:w-1/4">
        <statistics-card-line
          class="md:mb-0 mb-base"
          icon="UsersIcon"
          icon-right
          :statistic="parentStats.count"
          statisticTitle="Active Parents"
          :chartData="parentStats.series"
          type='area'
        />
      </div>

      <div class="vx-col w-full md:w-1/4 lg:w-1/4 xl:w-1/4">
        <statistics-card-line
          class="md:mb-0 mb-base"
          icon="UserIcon"
          icon-right
          :statistic="staffStats.count"
          statisticTitle="Active Staff"
          :chartData="staffStats.series"
          type='area' />
      </div>

      <div class="vx-col w-full md:w-1/4 lg:w-1/4 xl:w-1/4">
        <statistics-card-line
          icon="UserIcon"
          icon-right
          :statistic="adminStats.count"
          statisticTitle="Active Admins"
          :chartData="adminStats.series"
          type='area' />
      </div>
    </div>

    <div class="vx-row">
      <div v-if="canSeeStudentStats" class="vx-col w-full sm:w-1/2 md:w-1/2  mb-base">

        <div class="vx-col w-full">
          <vx-card title="Newly Registered Students">
            <div slot="no-body" class="mt-4">
              <vs-table :data="studentStats.latest" class="table-dark-inverted">
                <template slot="thead">
                  <vs-th>Name</vs-th>
                  <vs-th>Phone Number</vs-th>
                </template>

                <template slot-scope="{data}">
                  <vs-tr :key="indextr" v-for="(tr, indextr) in data">
                    <vs-td :data="data[indextr].first_name">
                      <vs-avatar :src="`https://i.pravatar.cc?u=${data[indextr].user.id}`" size="30px"
                                 class="border-2 border-white border-solid -m-1">

                      </vs-avatar>
                      <span class="ml-4 mb-10">{{data[indextr].first_name}} {{data[indextr].last_name}}</span>
                    </vs-td>
                    <vs-td :data="data[indextr].user.phone_number">
                      <span> {{data[indextr].user.phone_number}} </span>
                    </vs-td>
                  </vs-tr>
                </template>
              </vs-table>
            </div>

          </vx-card>
        </div>
      </div>

      <div v-if="canSeeParentStats" class="vx-col w-full sm:w-1/2 md:w-1/2  mb-base">

        <div class="vx-col w-full">
          <vx-card title="Newly Registered Parents">
            <div slot="no-body" class="mt-4">
              <vs-table :data="parentStats.latest" class="table-dark-inverted">
                <template slot="thead">
                  <vs-th>Name</vs-th>
                  <vs-th>Phone Number</vs-th>
                </template>

                <template slot-scope="{data}">
                  <vs-tr :key="indextr" v-for="(tr, indextr) in data">
                    <vs-td :data="data[indextr].father_full_name">
                      <vs-avatar :src="`https://i.pravatar.cc?u=${data[indextr].user.id}`" size="30px"
                                 class="border-2 border-white border-solid -m-1">

                      </vs-avatar>
                      <span class="ml-4 mb-10">{{data[indextr].father_full_name}}</span>
                    </vs-td>
                    <vs-td :data="data[indextr].user.phone_number">
                      <span> {{data[indextr].user.phone_number}} </span>
                    </vs-td>
                  </vs-tr>
                </template>
              </vs-table>
            </div>

          </vx-card>
        </div>
      </div>

      <div v-if="canSeeStaffStats" class="vx-col w-full sm:w-1/2 md:w-1/2  mb-base">

        <div class="vx-col w-full">
          <vx-card title="Newly Registered Staffs">
            <div slot="no-body" class="mt-4">
              <vs-table :data="staffStats.latest" class="table-dark-inverted">
                <template slot="thead">
                  <vs-th>Name</vs-th>
                  <vs-th>Phone Number</vs-th>
                </template>

                <template slot-scope="{data}">
                  <vs-tr :key="indextr" v-for="(tr, indextr) in data">
                    <vs-td :data="data[indextr].first_name">
                      <vs-avatar :src="`https://i.pravatar.cc?u=${data[indextr].user.id}`" size="30px"
                                 class="border-2 border-white border-solid -m-1">

                      </vs-avatar>
                      <span class="ml-4 mb-10">{{data[indextr].first_name}} {{data[indextr].last_name}}</span>
                    </vs-td>
                    <vs-td :data="data[indextr].user.phone_number">
                      <span> {{data[indextr].user.phone_number}} </span>
                    </vs-td>
                  </vs-tr>
                </template>
              </vs-table>
            </div>

          </vx-card>
        </div>
      </div>

      <div v-if="canSeeAdminStats" class="vx-col w-full sm:w-1/2 md:w-1/2  mb-base">

        <div class="vx-col w-full">
          <vx-card title="Newly Registered Admins">
            <div slot="no-body" class="mt-4">
              <vs-table :data="adminStats.latest" class="table-dark-inverted">
                <template slot="thead">
                  <vs-th>Name</vs-th>
                  <vs-th>Phone Number</vs-th>
                </template>

                <template slot-scope="{data}">
                  <vs-tr :key="indextr" v-for="(tr, indextr) in data">
                    <vs-td :data="data[indextr].father_full_name">
                      <vs-avatar :src="`https://i.pravatar.cc?u=${data[indextr].user.id}`" size="30px"
                                 class="border-2 border-white border-solid -m-1">

                      </vs-avatar>
                      <span class="ml-4 mb-10">{{data[indextr].father_full_name}}</span>
                    </vs-td>
                    <vs-td :data="data[indextr].user.phone_number">
                      <span> {{data[indextr].user.phone_number}} </span>
                    </vs-td>
                  </vs-tr>
                </template>
              </vs-table>
            </div>

          </vx-card>
        </div>
      </div>
    </div>


    <!--    <div class="vx-row">-->
    <!--      &lt;!&ndash; CARD 9: DISPATCHED ORDERS &ndash;&gt;-->
    <!--      <div class="vx-col w-full">-->
    <!--        <vx-card title="Dispatched Orders">-->
    <!--          <div slot="no-body" class="mt-4">-->
    <!--            <vs-table :data="dispatchedOrders" class="table-dark-inverted">-->
    <!--              <template slot="thead">-->
    <!--                <vs-th>ORDER NO.</vs-th>-->
    <!--                <vs-th>STATUS</vs-th>-->
    <!--                <vs-th>OPERATORS</vs-th>-->
    <!--                <vs-th>LOCATION</vs-th>-->
    <!--                <vs-th>DISTANCE</vs-th>-->
    <!--                <vs-th>START DATE</vs-th>-->
    <!--                <vs-th>EST DELIVERY DATE</vs-th>-->
    <!--              </template>-->

    <!--              <template slot-scope="{data}">-->
    <!--                <vs-tr :key="indextr" v-for="(tr, indextr) in data">-->
    <!--                  <vs-td :data="data[indextr].orderNo">-->
    <!--                    <span>#{{data[indextr].orderNo}}</span>-->
    <!--                  </vs-td>-->
    <!--                  <vs-td :data="data[indextr].status">-->
    <!--                    <span class="flex items-center px-2 py-1 rounded"><div class="h-3 w-3 rounded-full mr-2"-->
    <!--                                                                           :class="'bg-' + data[indextr].statusColor"></div>{{data[indextr].status}}</span>-->
    <!--                  </vs-td>-->
    <!--                  <vs-td :data="data[indextr].orderNo">-->
    <!--                    <ul class="users-liked user-list">-->
    <!--                      <li v-for="(user, userIndex) in data[indextr].usersLiked" :key="userIndex">-->
    <!--                        <vx-tooltip :text="user.name" position="bottom">-->
    <!--                          <vs-avatar :src="user.img" size="30px"-->
    <!--                                     class="border-2 border-white border-solid -m-1"></vs-avatar>-->
    <!--                        </vx-tooltip>-->
    <!--                      </li>-->
    <!--                    </ul>-->
    <!--                  </vs-td>-->
    <!--                  <vs-td :data="data[indextr].orderNo">-->
    <!--                    <span>{{data[indextr].location}}</span>-->
    <!--                  </vs-td>-->
    <!--                  <vs-td :data="data[indextr].orderNo">-->
    <!--                    <span>{{data[indextr].distance}}</span>-->
    <!--                    <vs-progress :percent="data[indextr].distPercent" :color="data[indextr].statusColor"></vs-progress>-->
    <!--                  </vs-td>-->
    <!--                  <vs-td :data="data[indextr].orderNo">-->
    <!--                    <span>{{data[indextr].startDate}}</span>-->
    <!--                  </vs-td>-->
    <!--                  <vs-td :data="data[indextr].orderNo">-->
    <!--                    <span>{{data[indextr].estDelDate}}</span>-->
    <!--                  </vs-td>-->
    <!--                </vs-tr>-->
    <!--              </template>-->
    <!--            </vs-table>-->
    <!--          </div>-->

    <!--        </vx-card>-->
    <!--      </div>-->
    <!--    </div>-->
    <!--    <div class="vx-row">-->

    <!--      &lt;!&ndash; CARD 4: SESSION &ndash;&gt;-->
    <!--      <div class="vx-col w-full md:w-1/2 mb-base">-->
    <!--        <vx-card>-->
    <!--          <div class="vx-row flex-col-reverse md:flex-col-reverse sm:flex-row lg:flex-row">-->

    <!--            &lt;!&ndash; LEFT COL &ndash;&gt;-->
    <!--            <div class="vx-col w-full md:w-full sm:w-1/2 lg:w-1/2 xl:w-1/2 flex flex-col justify-between"-->
    <!--                 v-if="salesBarSession.analyticsData">-->
    <!--              <div>-->
    <!--                <h2 class="mb-1 font-bold">{{ salesBarSession.analyticsData.session | k_formatter }}</h2>-->
    <!--                <span class="font-medium">Avg Sessions</span>-->

    <!--                &lt;!&ndash; Previous Data Comparison &ndash;&gt;-->
    <!--                <p class="mt-2 text-xl font-medium">-->
    <!--                  <span :class="salesBarSession.analyticsData.comparison.result >= 0 ? 'text-success' : 'text-danger'">-->
    <!--                    <span v-if="salesBarSession.analyticsData.comparison.result > 0">+</span>-->
    <!--                    <span>{{ salesBarSession.analyticsData.comparison.result }}</span>-->
    <!--                  </span>-->
    <!--                  <span> vs </span>-->
    <!--                  <span>{{ salesBarSession.analyticsData.comparison.str }}</span>-->
    <!--                </p>-->
    <!--              </div>-->
    <!--              <vs-button icon-pack="feather" icon="icon-chevrons-right" icon-after-->
    <!--                         class="shadow-md w-full lg:mt-0 mt-4">View Details-->
    <!--              </vs-button>-->
    <!--            </div>-->

    <!--            &lt;!&ndash; RIGHT COL &ndash;&gt;-->
    <!--            <div-->
    <!--              class="vx-col w-full md:w-full sm:w-1/2 lg:w-1/2 xl:w-1/2 flex flex-col lg:mb-0 md:mb-base sm:mb-0 mb-base">-->
    <!--              <change-time-duration-dropdown class="self-end"/>-->
    <!--              <vue-apex-charts type=bar height=200 :options="analyticsData.salesBar.chartOptions"-->
    <!--                               :series="salesBarSession.series" v-if="salesBarSession.series"/>-->
    <!--            </div>-->

    <!--          </div>-->
    <!--          <vs-divider class="my-6"></vs-divider>-->
    <!--          <div class="vx-row">-->
    <!--            <div class="vx-col w-1/2 mb-3">-->
    <!--              <p>Goal: $100000</p>-->
    <!--              <vs-progress class="block mt-1" :percent="50" color="primary"></vs-progress>-->
    <!--            </div>-->
    <!--            <div class="vx-col w-1/2 mb-3">-->
    <!--              <p>Users: 100K</p>-->
    <!--              <vs-progress class="block mt-1" :percent="60" color="warning"></vs-progress>-->
    <!--            </div>-->
    <!--            <div class="vx-col w-1/2 mb-3">-->
    <!--              <p>Retention: 90%</p>-->
    <!--              <vs-progress class="block mt-1" :percent="70" color="danger"></vs-progress>-->
    <!--            </div>-->
    <!--            <div class="vx-col w-1/2 mb-3">-->
    <!--              <p>Duration: 1yr</p>-->
    <!--              <vs-progress class="block mt-1" :percent="90" color="success"></vs-progress>-->
    <!--            </div>-->
    <!--          </div>-->
    <!--        </vx-card>-->
    <!--      </div>-->

    <!--      &lt;!&ndash; CARD 5: SUPPORT TRACKER &ndash;&gt;-->
    <!--      <div class="vx-col w-full md:w-1/2 lg:w-1/2 xl:w-1/2 mb-base">-->
    <!--        <vx-card title="Support Tracker">-->
    <!--          &lt;!&ndash; CARD ACTION &ndash;&gt;-->
    <!--          <template slot="actions">-->
    <!--            <change-time-duration-dropdown/>-->
    <!--          </template>-->

    <!--          <div slot="no-body" v-if="supportTracker.analyticsData">-->
    <!--            <div class="vx-row text-center">-->

    <!--              &lt;!&ndash; Open Tickets Heading &ndash;&gt;-->
    <!--              <div-->
    <!--                class="vx-col w-full lg:w-1/5 md:w-full sm:w-1/5 flex flex-col justify-between mb-4 lg:order-first md:order-last sm:order-first order-last">-->
    <!--                <div class="lg:ml-6 lg:mt-6 md:mt-0 md:ml-0 sm:ml-6 sm:mt-6">-->
    <!--                  <h1 class="font-bold text-5xl">{{ supportTracker.analyticsData.openTickets }}</h1>-->
    <!--                  <small>Tickets</small>-->
    <!--                </div>-->
    <!--              </div>-->

    <!--              &lt;!&ndash; Chart &ndash;&gt;-->
    <!--              <div-->
    <!--                class="vx-col w-full lg:w-4/5 md:w-full sm:w-4/5 justify-center mx-auto lg:mt-0 md:mt-6 sm:mt-0 mt-6">-->
    <!--                <vue-apex-charts type=radialBar height=385 :options="analyticsData.supportTrackerRadialBar.chartOptions"-->
    <!--                                 :series="supportTracker.series"/>-->
    <!--              </div>-->
    <!--            </div>-->

    <!--            &lt;!&ndash; Support Tracker Meta Data &ndash;&gt;-->
    <!--            <div class="flex flex-row justify-between px-8 pb-4 mt-4">-->
    <!--              <p class="text-center" v-for="(val, key) in supportTracker.analyticsData.meta" :key="key">-->
    <!--                <span class="block">{{ key }}</span>-->
    <!--                <span class="text-2xl font-semibold">{{ val }}</span>-->
    <!--              </p>-->
    <!--            </div>-->
    <!--          </div>-->
    <!--        </vx-card>-->
    <!--      </div>-->
    <!--    </div>-->

    <!--    <div class="vx-row">-->
    <!--      &lt;!&ndash; CARD 6: Product Orders &ndash;&gt;-->
    <!--      <div class="vx-col w-full lg:w-1/3 mb-base">-->
    <!--        <vx-card title="Product Orders">-->
    <!--          &lt;!&ndash; CARD ACTION &ndash;&gt;-->
    <!--          <template slot="actions">-->
    <!--            <change-time-duration-dropdown/>-->
    <!--          </template>-->

    <!--          &lt;!&ndash; Chart &ndash;&gt;-->
    <!--          <div slot="no-body">-->
    <!--            <vue-apex-charts type=radialBar height=420 :options="analyticsData.productOrdersRadialBar.chartOptions"-->
    <!--                             :series="productsOrder.series"/>-->
    <!--          </div>-->

    <!--          <ul>-->
    <!--            <li v-for="orderData in productsOrder.analyticsData" :key="orderData.orderType"-->
    <!--                class="flex mb-3 justify-between">-->
    <!--                            <span class="flex items-center">-->
    <!--                                    <span class="inline-block h-4 w-4 rounded-full mr-2 bg-white border-3 border-solid"-->
    <!--                                          :class="`border-${orderData.color}`"></span>-->
    <!--                                    <span class="font-semibold">{{ orderData.orderType }}</span>-->
    <!--                            </span>-->
    <!--              <span>{{ orderData.counts }}</span>-->
    <!--            </li>-->
    <!--          </ul>-->
    <!--        </vx-card>-->
    <!--      </div>-->

    <!--      &lt;!&ndash; CARD 7: Sales Stats &ndash;&gt;-->
    <!--      <div class="vx-col w-full lg:w-1/3 mb-base">-->
    <!--        <vx-card title="Sales Stats" subtitle="Last 6 Months">-->
    <!--          <template slot="actions">-->
    <!--            <feather-icon icon="MoreVerticalIcon" svgClasses="w-6 h-6 text-grey"></feather-icon>-->
    <!--          </template>-->
    <!--          <div class="flex">-->
    <!--            <span class="flex items-center"><div-->
    <!--              class="h-3 w-3 rounded-full mr-1 bg-primary"></div><span>Sales</span></span>-->
    <!--            <span class="flex items-center ml-4"><div-->
    <!--              class="h-3 w-3 rounded-full mr-1 bg-success"></div><span>Visits</span></span>-->
    <!--          </div>-->
    <!--          <div slot="no-body-bottom">-->
    <!--            <vue-apex-charts type=radar height=385 :options="analyticsData.statisticsRadar.chartOptions"-->
    <!--                             :series="salesRadar.series"/>-->
    <!--          </div>-->
    <!--        </vx-card>-->
    <!--      </div>-->

    <!--      &lt;!&ndash; CARD 8: Activity Timeline &ndash;&gt;-->
    <!--      <div class="vx-col w-full lg:w-1/3 mb-base">-->
    <!--        <vx-card title="Activity Timeline">-->
    <!--          <vx-timeline :data="timelineData"/>-->
    <!--        </vx-card>-->
    <!--      </div>-->
    <!--    </div>-->


  </div>
</template>

<script>
  import VueApexCharts from 'vue-apexcharts'
  import StatisticsCardLine from '@/components/statistics-cards/StatisticsCardLine.vue'
  import analyticsData from './ui-elements/card/analyticsData.js'
  import ChangeTimeDurationDropdown from '@/components/ChangeTimeDurationDropdown.vue'
  import VxTimeline from "@/components/timeline/VxTimeline"
  import commons from "../commons";

  export default {
    data() {
      return {
        checkpointReward: {},
        subscribersGained: {},
        ordersRecevied: {},
        salesBarSession: {},
        supportTracker: {},
        productsOrder: {},
        salesRadar: {},


        analyticsData: analyticsData,
      }
    },
    components: {
      VueApexCharts,
      StatisticsCardLine,
      ChangeTimeDurationDropdown,
      VxTimeline
    },

    computed: {

      studentStats() {
        return {
          series: [{
            name: 'Students',
            data: (this.$store.state.Stats.Students) ? this.$store.state.Stats.Students.this_month : []
          }],
          count: (this.$store.state.Stats.Students) ? this.$store.state.Stats.Students.count : 0,
          latest: (this.$store.state.Stats.Students) ? this.$store.state.Stats.Students.latest : [],
        }
      },

      staffStats() {
        return {
          series: [{
            name: 'Staffs',
            data: (this.$store.state.Stats.Staff) ? this.$store.state.Stats.Staff.this_month : []
          }],
          count: (this.$store.state.Stats.Staff) ? this.$store.state.Stats.Staff.count : 0,
          latest: (this.$store.state.Stats.Staff) ? this.$store.state.Stats.Staff.latest : [],
        }
      },

      parentStats() {
        return {
          series: [{
            name: 'Parents',
            data: (this.$store.state.Stats.Parents) ? this.$store.state.Stats.Parents.this_month : []
          }],
          count: (this.$store.state.Stats.Parents) ? this.$store.state.Stats.Parents.count : 0,
          latest: (this.$store.state.Stats.Parents) ? this.$store.state.Stats.Parents.latest : [],
        }
      },

      adminStats() {
        return {
          series: [{
            name: 'Admin',
            data: (this.$store.state.Stats.Admins) ? this.$store.state.Stats.Admins.this_month : []
          }],
          count: (this.$store.state.Stats.Admins) ? this.$store.state.Stats.Admins.count : 0,
          latest: (this.$store.state.Stats.Admins) ? this.$store.state.Stats.Admins.latest : [],
        }
      },

      canSeeStudentStats() {
        return commons.hasAccess("sms-view-students");
      },

      canSeeAdminStats() {
        return commons.hasAccess("sms-view-admins");
      },

      canSeeParentStats() {
        return commons.hasAccess("sms-view-parents");
      },

      canSeeStaffStats() {
        return commons.hasAccess("sms-view-staff");
      },

      canSeeAnyOne() {
        return this.canSeeStudentStats || this.canSeeAdminStats || this.canSeeParentStats || this.canSeeStaffStats;
      }

    },
    created() {

      if (this.canSeeAnyOne) {
        this.$store.dispatch('getDashboardStats');
      }

      //  User Reward Card
      // this.$http.get("/api/user/checkpoint-reward")
      //   .then((response) => {
      //     this.checkpointReward = response.data
      //   })
      //   .catch((error) => {
      //     console.log(error)
      //   })
      //
      // // Subscribers gained - Statistics
      // this.$http.get("/api/card/card-statistics/subscribers")
      //   .then((response) => {
      //     this.subscribersGained = response.data
      //   })
      //   .catch((error) => {
      //     console.log(error)
      //   })
      //
      // // Orders - Statistics
      // this.$http.get("/api/card/card-statistics/orders")
      //   .then((response) => {
      //     this.ordersRecevied = response.data
      //   })
      //   .catch((error) => {
      //     console.log(error)
      //   })
      //
      // // Sales bar - Analytics
      // this.$http.get("/api/card/card-analytics/sales/bar")
      //   .then((response) => {
      //     this.salesBarSession = response.data
      //   })
      //   .catch((error) => {
      //     console.log(error)
      //   })
      //
      // // Support Tracker
      // this.$http.get("/api/card/card-analytics/support-tracker")
      //   .then((response) => {
      //     this.supportTracker = response.data
      //   })
      //   .catch((error) => {
      //     console.log(error)
      //   })
      //
      // // Products Order
      // this.$http.get("/api/card/card-analytics/products-orders")
      //   .then((response) => {
      //     this.productsOrder = response.data
      //   })
      //   .catch((error) => {
      //     console.log(error)
      //   })
      //
      // // Sales Radar
      // this.$http.get("/api/card/card-analytics/sales/radar")
      //   .then((response) => {
      //     this.salesRadar = response.data
      //   })
      //   .catch((error) => {
      //     console.log(error)
      //   })
      //
      // // Dispatched Orders
      // this.$http.get("/api/table/dispatched-orders")
      //   .then((response) => {
      //     this.dispatchedOrders = response.data
      //   })
      //   .catch((error) => {
      //     console.log(error)
      //   })
    }
  }
</script>

<style lang="scss">
  /*! rtl:begin:ignore */
  #dashboard-sms {
    .greet-user {
      position: relative;

      .decore-left {
        position: absolute;
        left: 0;
        top: 0;
      }

      .decore-right {
        position: absolute;
        right: 0;
        top: 0;
      }
    }

    @media(max-width: 576px) {
      .decore-left, .decore-right {
        width: 140px;
      }
    }
  }

  /*! rtl:end:ignore */
</style>
