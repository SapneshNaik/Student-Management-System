<!-- =========================================================================================
    File Name: TodoEdit.vue
    Description: Edit todo component
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
      Author: Pixinvent
    Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->


<template>
    <vs-prompt
        title="Edit Task"
        accept-text= "Submit"
        cancel-text = "Remove"
        button-cancel = "border"
        @cancel="removeTodo"
        @accept="submitTodo"
        @close="init"
        :is-valid="validateForm"
        :active.sync="activePrompt">
        <div>
            <form>
                <div class="vx-row">
                    <div class="vx-col w-1/6 self-center">
                        <vs-checkbox v-model="taskLocal.isCompleted" class="w-8"></vs-checkbox>
                    </div>

                    <div class="vx-col ml-auto flex">
                        <feather-icon icon="InfoIcon" class="cursor-pointer" :svgClasses="[{'text-success stroke-current': taskLocal.isImportant}, 'w-5', 'h-5 mr-4']" @click.prevent="taskLocal.isImportant = !taskLocal.isImportant"></feather-icon>

                        <feather-icon icon="StarIcon" class="cursor-pointer" :svgClasses="[{'text-warning stroke-current': taskLocal.isStarred}, 'w-5', 'h-5 mr-4']" @click.prevent="taskLocal.isStarred = !taskLocal.isStarred"></feather-icon>

                        <vs-dropdown class="cursor-pointer flex" vs-custom-content>

                            <feather-icon icon="TagIcon" svgClasses="h-5 w-5"></feather-icon>

                            <vs-dropdown-menu style="z-index: 200001">
                                    <vs-dropdown-item v-for="(tag, index) in taskTags" :key="index">
                                        <vs-checkbox @click.stop :vs-value="tag.value" v-model="taskLocal.tags">{{ tag.text }}</vs-checkbox>
                                    </vs-dropdown-item>
                            </vs-dropdown-menu>
                        </vs-dropdown>
                    </div>
                </div>

                <div class="vx-row">
                    <div class="vx-col w-full">
                        <vs-input v-validate="'required'" name="title" class="w-full mb-4 mt-5" placeholder="Title" v-model="taskLocal.title" />
                        <vs-textarea rows="5" label="Add description" v-model="taskLocal.desc" />
                    </div>
                </div>

            </form>
        </div>
    </vs-prompt>
</template>

<script>
export default {
    props: {
        displayPrompt: {
            type: Boolean,
            required: true,
        },
        taskId: {
            type: Number,
            required: true,
        }
    },
    data() {
        return {
            taskLocal: Object.assign({}, this.$store.getters["todo/getTask"](this.taskId))
        }
    },
    computed: {
        activePrompt: {
            get() {
                return this.displayPrompt;
            },
            set(value) {
                this.$emit('hideDisplayPrompt', value);
            }
        },
        taskTags() {
            return this.$store.state.todo.taskTags;
        },
        validateForm() {
            return !this.errors.any() && this.taskLocal.title != '';
        }
    },
    methods: {
        removeTodo() {
          this.$store.dispatch("todo/updateTask", Object.assign({}, this.taskLocal, {isTrashed: true}))
            .then(() => {
              // Fetch Tasks
              this.$store.dispatch("todo/fetchTasks", { filter: this.$route.params.filter })
            })
            .catch((error) => { console.error(error) })
        },
        init() {
            this.taskLocal = Object.assign({}, this.$store.getters["todo/getTask"](this.taskId))
        },
        submitTodo() {
            this.$store.dispatch("todo/updateTask", this.taskLocal)
        }
    },
}
</script>
