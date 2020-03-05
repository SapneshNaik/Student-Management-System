<!-- =========================================================================================
    File Name: TodoItem.vue
    Description: Single todo item component
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
      Author: Pixinvent
    Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->


<template>
    <div @click="displayPrompt" class="px-4 py-4 list-item-component">
        <div class="vx-row">
            <div class="vx-col w-full sm:w-5/6 flex sm:items-center sm:flex-row flex-col">
                <div class="flex items-center">
                    <vs-checkbox v-model="isCompleted" class="w-8 m-0 vs-checkbox-small" @click.stop />
                    <h6 class="todo-title" :class="{'line-through': taskLocal.isCompleted}">{{ taskLocal.title }}</h6>
                </div>
                <div class="todo-tags sm:ml-2 sm:my-0 my-2 flex">
                    <vs-chip v-for="(tag, index) in taskLocal.tags" :key="index">
                        <div class="h-2 w-2 rounded-full mr-1" :class="'bg-' + todoLabelColor(tag)"></div>
                        <span>{{ tag | capitalize }}</span>
                    </vs-chip>
                </div>
            </div>

            <div class="vx-col w-full sm:w-1/6 ml-auto flex sm:justify-end">
                <feather-icon
                  icon="InfoIcon"
                  class="cursor-pointer"
                  :svgClasses="[{'text-success stroke-current': taskLocal.isImportant}, 'w-5', 'h-5 mr-4']"
                  @click.stop="toggleIsImportant" />

                <feather-icon
                  icon="StarIcon"
                  class="cursor-pointer"
                  :svgClasses="[{'text-warning stroke-current': taskLocal.isStarred}, 'w-5', 'h-5 mr-4']"
                  @click.stop="toggleIsStarred" />
                <feather-icon
                  v-if="!taskLocal.isTrashed"
                  icon="TrashIcon"
                  class="cursor-pointer"
                  svgClasses="w-5 h-5"
                  @click.stop="moveToTrash" />
            </div>
        </div>
        <div class="vx-row" v-if="taskLocal.desc">
            <div class="vx-col w-full">
                <p class="mt-2 truncate" :class="{'line-through': taskLocal.isCompleted}">{{ taskLocal.desc }}</p>
            </div>
        </div>
    </div>
</template>

<script>
export default{
    props: {
        taskId: {
            type: Number,
            required: true,
        }
    },
    data() {
        return {
          taskLocal: this.$store.getters["todo/getTask"](this.taskId)
        }
    },
    computed: {
        isCompleted: {
          get () {
              return this.taskLocal.isCompleted
          },
          set (value) {
            this.$store.dispatch("todo/updateTask", Object.assign({}, this.taskLocal, {isCompleted: value}))
              .then((response) => {
                this.taskLocal.isCompleted = response.data.isCompleted
              })
              .catch((error) => { console.error(error) })
          }
        },
        todoLabelColor() {
          return (label) => {
            const tags = this.$store.state.todo.taskTags
            return tags.find((tag) => {
              return tag.value == label
            }).color
          }
        }
    },
    methods: {
        toggleIsImportant() {
          this.$store.dispatch("todo/updateTask", Object.assign({}, this.taskLocal, {isImportant: !this.taskLocal.isImportant}))
            .then((response) => {
              this.taskLocal.isImportant = response.data.isImportant
            })
            .catch((error) => { console.error(error) })
        },
        toggleIsStarred() {
          this.$store.dispatch("todo/updateTask", Object.assign({}, this.taskLocal, {isStarred: !this.taskLocal.isStarred}))
            .then((response) => {
              this.taskLocal.isStarred = response.data.isStarred
            })
            .catch((error) => { console.error(error) })
        },
        moveToTrash() {

          this.$store.dispatch("todo/updateTask", Object.assign({}, this.taskLocal, {isTrashed: true}))
            .then((response) => {
              // console.log(response.data);
              this.taskLocal.isTrashed = response.data.isTrashed
              this.$el.style.display = "none"   // Hides element from DOM
            })
            .catch((error) => { console.error(error) })

          // Un-comment below line if you want to fetch task after task is deleted
          // this.$store.dispatch("todo/fetchTasks", {filter: this.$route.params.filter})
        },
        displayPrompt() {
          this.$emit('showDisplayPrompt', this.taskId)
        }
    },
}
</script>
