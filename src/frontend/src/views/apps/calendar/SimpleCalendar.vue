<template>
  <div id="simple-calendar-app">
    <div class="vx-card no-scroll-content">
      <calendar-view
        ref="calendar"
        :displayPeriodUom="calendarView"
        :show-date="showDate"
        :events="simpleCalendarEvents"
        enableDragDrop
        :eventTop="windowWidth <= 400 ? '2rem' : '3rem'"
        eventBorderHeight="0px"
        eventContentHeight="1.65rem"
        class="theme-default"
        @click-date="openAddNewEvent"
        @click-event="openEditEvent"
        @drop-on-date="eventDragged">

        <div slot="header" class="mb-4">

          <div class="vx-row no-gutter">

            <!-- Month Name -->
            <div class="vx-col w-1/3 items-center sm:flex hidden">
              <!-- Add new event button -->
              <vs-button icon-pack="feather" icon="icon-plus" @click="promptAddNewEvent(new Date())">Add</vs-button>
            </div>

            <!-- Current Month -->
            <div class="vx-col sm:w-1/3 w-full sm:my-0 my-3 flex sm:justify-end justify-center order-last">
              <div class="flex items-center">
                <feather-icon
                  :icon="$vs.rtl ? 'ChevronRightIcon' : 'ChevronLeftIcon'"
                  @click="updateMonth(-1)"
                  svgClasses="w-5 h-5 m-1"
                  class="cursor-pointer bg-primary text-white rounded-full" />

                <span class="mx-3 text-xl font-medium whitespace-no-wrap">{{ showDate | month }}</span>

                <feather-icon
                  :icon="$vs.rtl ? 'ChevronLeftIcon' : 'ChevronRightIcon'"
                  @click="updateMonth(1)"
                  svgClasses="w-5 h-5 m-1"
                  class="cursor-pointer bg-primary text-white rounded-full" />
              </div>
            </div>

            <div class="vx-col sm:w-1/3 w-full flex justify-center">
              <template v-for="(view, index) in calendarViewTypes">
                <vs-button
                  v-if="calendarView === view.val"
                  :key="String(view.val) + 'filled'"
                  type="filled"
                  class="p-3 md:px-8 md:py-3"
                  :class="{'border-l-0 rounded-l-none': index, 'rounded-r-none': calendarViewTypes.length !== index+1}"
                  @click="calendarView = view.val"
                  >{{ view.label }}</vs-button>
                <vs-button
                  v-else
                  :key="String(view.val) + 'border'"
                  type="border"
                  class="p-3 md:px-8 md:py-3"
                  :class="{'border-l-0 rounded-l-none': index, 'rounded-r-none': calendarViewTypes.length !== index+1}"
                  @click="calendarView = view.val"
                  >{{ view.label }}</vs-button>
              </template>

            </div>
          </div>

          <div class="vx-row sm:flex hidden mt-4">
            <div class="vx-col w-full flex">
              <!-- Labels -->
              <div class="flex flex-wrap sm:justify-start justify-center">
                  <div v-for="(label, index) in calendarLabels" :key="index" class="flex items-center mr-4 mb-2">
                      <div class="h-3 w-3 inline-block rounded-full mr-2" :class="'bg-' + label.color"></div>
                      <span>{{ label.text }}</span>
                  </div>
                  <div class="flex items-center mr-4 mb-2">
                      <div class="h-3 w-3 inline-block rounded-full mr-2 bg-primary"></div>
                      <span>None</span>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </calendar-view>
    </div>

    <!-- ADD EVENT -->
    <vs-prompt
        class="calendar-event-dialog"
        title="Add Event"
        accept-text= "Add Event"
        @accept="addEvent"
        :is-valid="validForm"
        :active.sync="activePromptAddEvent">

        <div class="calendar__label-container flex">

            <vs-chip v-if="labelLocal != 'none'" class="text-white" :class="'bg-' + labelColor(labelLocal)">{{ labelLocal }}</vs-chip>

            <vs-dropdown vs-custom-content vs-trigger-click class="ml-auto my-2 cursor-pointer">

                <feather-icon icon="TagIcon" svgClasses="h-5 w-5" class="cursor-pointer" @click.prevent></feather-icon>

                <vs-dropdown-menu style="z-index: 200001">
                        <vs-dropdown-item v-for="(label, index) in calendarLabels" :key="index" @click="labelLocal = label.value">
                            <div class="h-3 w-3 inline-block rounded-full mr-2" :class="'bg-' + label.color"></div>
                            <span>{{ label.text }}</span>
                        </vs-dropdown-item>

                        <vs-dropdown-item @click="labelLocal = 'none'">
                            <div class="h-3 w-3 mr-1 inline-block rounded-full mr-2 bg-primary"></div>
                            <span>None</span>
                        </vs-dropdown-item>
                </vs-dropdown-menu>
            </vs-dropdown>

        </div>

        <vs-input name="event-name" v-validate="'required'" class="w-full" label-placeholder="Event Title" v-model="title"></vs-input>
        <div class="my-4">
            <small class="date-label">Start Date</small>
            <datepicker :language="$vs.rtl ? langHe : langEn" name="start-date" v-model="startDate" :disabled="disabledFrom"></datepicker>
        </div>
        <div class="my-4">
            <small class="date-label">End Date</small>
            <datepicker :language="$vs.rtl ? langHe : langEn" :disabledDates="disabledDatesTo" name="end-date" v-model="endDate"></datepicker>
        </div>
        <vs-input name="event-url" v-validate="'url'" class="w-full mt-6" label-placeholder="Event URL" v-model="url" :color="!errors.has('event-url') ? 'success' : 'danger'"></vs-input>

    </vs-prompt>

    <!-- EDIT EVENT -->
    <vs-prompt
        class="calendar-event-dialog"
        title="Edit Event"
        accept-text= "Submit"
        cancel-text = "Remove"
        button-cancel = "border"
        @cancel="removeEvent"
        @accept="editEvent"
        :is-valid="validForm"
        :active.sync="activePromptEditEvent">

        <div class="calendar__label-container flex">

            <vs-chip v-if="labelLocal != 'none'" class="text-white" :class="'bg-' + labelColor(labelLocal)">{{ labelLocal }}</vs-chip>

            <vs-dropdown vs-custom-content class="ml-auto my-2 cursor-pointer">

                <feather-icon icon="TagIcon" svgClasses="h-5 w-5" @click.prevent></feather-icon>

                <vs-dropdown-menu style="z-index: 200001">
                        <vs-dropdown-item v-for="(label, index) in calendarLabels" :key="index" @click="labelLocal = label.value">
                            <div class="h-3 w-3 inline-block rounded-full mr-2" :class="'bg-' + label.color"></div>
                            <span>{{ label.text }}</span>
                        </vs-dropdown-item>

                        <vs-dropdown-item @click="labelLocal = 'none'">
                            <div class="h-3 w-3 mr-1 inline-block rounded-full mr-2 bg-primary"></div>
                            <span>None</span>
                        </vs-dropdown-item>
                </vs-dropdown-menu>
            </vs-dropdown>

        </div>

        <vs-input name="event-name" v-validate="'required'" class="w-full" label-placeholder="Event Title" v-model="title"></vs-input>
        <div class="my-4">
            <small class="date-label">Start Date</small>
            <datepicker :language="$vs.rtl ? langHe : langEn" :disabledDates="disabledDatesFrom" name="start-date" v-model="startDate"></datepicker>
        </div>
        <div class="my-4">
            <small class="date-label">End Date</small>
            <datepicker :language="$vs.rtl ? langHe : langEn" :disabledDates="disabledDatesTo" name="end-date" v-model="endDate"></datepicker>
        </div>
        <vs-input name="event-url" v-validate="'url'" class="w-full mt-6" label-placeholder="Event URL" v-model="url" :color="!errors.has('event-url') ? 'success' : 'danger'"></vs-input>

    </vs-prompt>
  </div>
</template>

<script>
import { CalendarView, CalendarViewHeader } from "vue-simple-calendar"
import moduleCalendar from '@/store/calendar/moduleCalendar.js'
require("vue-simple-calendar/static/css/default.css")

import Datepicker from 'vuejs-datepicker'
import { en, he } from "vuejs-datepicker/src/locale"

export default {
  components: {
    CalendarView,
    CalendarViewHeader,
    Datepicker
  },
  data() {
    return {
      showDate: new Date(),
      disabledFrom: false,
      id: 0,
      title: '',
      startDate: '',
      endDate: '',
      labelLocal: 'none',

      langHe: he,
      langEn: en,

      url: '',
      calendarView: 'month',

      activePromptAddEvent: false,
      activePromptEditEvent: false,

      calendarViewTypes: [
        {
          label: "Month",
          val: "month"
        },
        {
          label: "Week",
          val: "week"
        },
        {
          label: "Year",
          val: "year"
        },
      ]
    }
  },
  computed: {
    simpleCalendarEvents() {
        return this.$store.state.calendar.events
    },
    validForm() {
        return this.title != '' && this.startDate != '' && this.endDate != '' && (Date.parse(this.endDate) - Date.parse(this.startDate)) >= 0 && !this.errors.has('event-url');
    },
    disabledDatesTo() {
        return { to: new Date(this.startDate) }
    },
    disabledDatesFrom() {
        return { from: new Date(this.endDate) }
    },
    calendarLabels() {
        return this.$store.state.calendar.eventLabels
    },
    labelColor() {
        return (label) => {
            if (label == "business") return "success"
            else if (label == "work") return "warning"
            if (label == "personal") return "danger"
            if (label == "none") return "primary"
        }
    },
    windowWidth() {
      return this.$store.state.windowWidth
    }
  },
  methods: {
    addEvent() {
        const obj = { title: this.title, startDate: this.startDate, endDate: this.endDate, label: this.labelLocal, url: this.url }
        obj.classes = "event-" + this.labelColor(this.labelLocal)
        this.$store.dispatch('calendar/addEvent', obj);
    },
    updateMonth(val) {
      this.showDate = this.$refs.calendar.getIncrementedPeriod(val);
    },
    clearFields() {
        this.title = this.endDate = this.url = "";
        this.id= 0;
        this.labelLocal = "none";
    },
    promptAddNewEvent(date) {
        this.disabledFrom = false;
        this.addNewEventDialog(date);
    },
    addNewEventDialog(date) {
        this.clearFields();
        this.startDate = date;
        this.endDate = date;
        this.activePromptAddEvent = true;
    },
    openAddNewEvent(date) {
        this.disabledFrom = true;
        this.addNewEventDialog(date);
    },
    openEditEvent(event) {
      const e = this.$store.getters['calendar/getEvent'](event.id)
      this.id = e.id
      this.title = e.title
      this.startDate = e.startDate
      this.endDate = e.endDate
      this.url = e.url
      this.labelLocal = e.label
      this.activePromptEditEvent = true;
    },
    editEvent() {
      const obj = { id: this.id, title: this.title, startDate: this.startDate, endDate: this.endDate, label: this.labelLocal, url: this.url }
      obj.classes = "event-" + this.labelColor(this.labelLocal)
      this.$store.dispatch('calendar/editEvent', obj)
    },
    removeEvent() {
      this.$store.dispatch('calendar/removeEvent', this.id)
    },
    eventDragged(event, date) {
      this.$store.dispatch('calendar/eventDragged', {event: event, date: date})
    }
  },
  created() {
    this.$store.registerModule('calendar', moduleCalendar)
    this.$store.dispatch("calendar/fetchEvents")
    this.$store.dispatch("calendar/fetchEventLabels")
  },
  beforeDestroy() {
    this.$store.unregisterModule('calendar')
  }
}
</script>

<style lang="scss">
@import "@/assets/scss/vuexy/apps/simple-calendar.scss";
</style>
