<!-- =========================================================================================
  File Name: Todo.vue
  Description: Todo Application to keep you ahead of time
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->


<template>
    <div id="todo-app" class="border border-solid d-theme-border-grey-light rounded relative overflow-hidden">
        <vs-sidebar class="items-no-padding" parent="#todo-app" :click-not-close="clickNotClose" :hidden-background="clickNotClose" v-model="isSidebarActive">

            <todo-add-new />

            <component :is="scrollbarTag" class="todo-scroll-area" :settings="settings" :key="$vs.rtl">
                <todo-filters @closeSidebar="toggleTodoSidebar"></todo-filters>
            </component>

        </vs-sidebar>
        <div :class="{'sidebar-spacer': clickNotClose}" class="no-scroll-content border border-r-0 border-b-0 border-t-0 border-solid d-theme-border-grey-light no-scroll-content">

            <div class="flex d-theme-dark-bg items-center border border-l-0 border-r-0 border-t-0 border-solid d-theme-border-grey-light">

                <!-- TOGGLE SIDEBAR BUTTON -->
                <feather-icon class="md:inline-flex lg:hidden ml-4 mr-4 cursor-pointer" icon="MenuIcon" @click.stop="toggleTodoSidebar(true)" />

                <!-- SEARCH BAR -->
                <vs-input icon-no-border size="large" icon-pack="feather" icon="icon-search" placeholder="Search..." v-model="searchQuery" class="vs-input-no-border vs-input-no-shdow-focus w-full" />
            </div>

            <!-- TODO LIST -->
            <component :is="scrollbarTag" class="todo-content-scroll-area" :settings="settings" ref="taskListPS" :key="$vs.rtl">

                <transition-group class="todo-list" name="list-enter-up" tag="ul" appear>
                    <li
                      class="cursor-pointer todo_todo-item"
                      v-for="(task, index) in taskList"
                      :key="String(currFilter) + String(task.id)"
                      :style="[{transitionDelay: (index * 0.1) + 's'}]">

                      <todo-task :taskId="task.id" @showDisplayPrompt="showDisplayPrompt($event)" :key="String(task.title) + String(task.desc)" />
                        <!--
                        Note: Remove "todo-task" component's key just concat lastUpdated field in li key list.
                        e.g. <li class="..." v-for="..." :key="String(currFilter) + String(task.id) + String(task.lastUpdated)" .. >
                        -->
                    </li>
                </transition-group>
            </component>
            <!-- /TODO LIST -->

        </div>

        <!-- EDIT TODO DIALOG -->
        <todo-edit :displayPrompt="displayPrompt" :taskId="taskIdToEdit" @hideDisplayPrompt="hidePrompt" v-if="displayPrompt"></todo-edit>
    </div>
</template>

<script>
import moduleTodo          from '@/store/todo/moduleTodo.js'
import TodoAddNew          from "./TodoAddNew.vue"
import TodoTask            from "./TodoTask.vue"
import TodoFilters         from "./TodoFilters.vue"
import TodoEdit            from "./TodoEdit.vue"
import VuePerfectScrollbar from 'vue-perfect-scrollbar'

export default {
  data() {
    return {
      currFilter           : "",
      clickNotClose        : true,
      displayPrompt        : false,
      taskIdToEdit         : 0,
      isSidebarActive      : true,
      settings : {
        maxScrollbarLength : 60,
        wheelSpeed         : 0.30,
      },
    }
  },
  watch: {
    todoFilter() {
      const scroll_el = this.$refs.taskListPS.$el || this.$refs.taskListPS
      scroll_el.scrollTop = 0

      this.toggleTodoSidebar()

      // Fetch Tasks
      let filter = this.$route.params.filter
      this.$store.dispatch("todo/fetchTasks", { filter: filter })
      this.$store.commit("todo/UPDATE_TODO_FILTER", filter)
    },
    windowWidth() {
      this.setSidebarWidth()
    },
  },
  computed: {
    todo()         { return this.$store.state.todo.todoArray              },
    todoFilter()   { return this.$route.params.filter                     },
    taskList()     { return this.$store.getters["todo/queriedTasks"]      },
    searchQuery:   {
      get()        { return this.$store.state.todo.todoSearchQuery        },
      set(val)     { this.$store.dispatch('todo/setTodoSearchQuery', val) }
    },
    scrollbarTag() { return this.$store.getters.scrollbarTag              },
    windowWidth()  { return this.$store.state.windowWidth                 }
  },
  methods: {
    showDisplayPrompt(itemId) {
      this.taskIdToEdit  = itemId
      this.displayPrompt = true
    },
    hidePrompt() {
      this.displayPrompt = false
    },
    setSidebarWidth() {
      if (this.windowWidth < 992) {
        this.isSidebarActive = this.clickNotClose = false
      } else {
        this.isSidebarActive = this.clickNotClose = true
      }
    },
    toggleTodoSidebar(value = false) {
      if (!value && this.clickNotClose) return
      this.isSidebarActive = value
    },
  },
  components: {
    TodoAddNew,
    TodoTask,
    TodoFilters,
    TodoEdit,
    VuePerfectScrollbar
  },
  created() {
    this.$store.registerModule('todo', moduleTodo)
    this.setSidebarWidth()

    let filter = this.$route.params.filter

    // Fetch Tasks
    this.$store.dispatch("todo/fetchTasks", { filter: filter })
    this.$store.commit("todo/UPDATE_TODO_FILTER", filter)

    // Fetch Tags
    this.$store.dispatch("todo/fetchTags")
  },
  beforeUpdate() {
    this.currFilter = this.$route.params.filter
  },
  beforeDestroy: function() {
    this.$store.unregisterModule('todo')
  },
  mounted() {
    this.$store.dispatch("todo/setTodoSearchQuery", "")
  }
}

</script>


<style lang="scss">
@import "@/assets/scss/vuexy/apps/todo.scss";
</style>
