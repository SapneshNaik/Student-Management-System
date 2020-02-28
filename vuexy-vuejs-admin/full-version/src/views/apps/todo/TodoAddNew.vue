<!-- =========================================================================================
    File Name: TodoAddNew.vue
    Description: Add new todo component
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
      Author: Pixinvent
    Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->


<template>
    <div class="px-6 pb-2 pt-6">
    <vs-button @click="activePrompt = true" class="w-full">Add Task</vs-button>
    <vs-prompt
        title="Add Task"
        accept-text= "Add Task"
        button-cancel = "border"
        @cancel="clearFields"
        @accept="addTodo"
        @close="clearFields"
        :is-valid="validateForm"
        :active.sync="activePrompt">
        <div>
            <form>
                <div class="vx-row">

                    <div class="vx-col ml-auto flex">
                        <feather-icon icon="InfoIcon" class="cursor-pointer" :svgClasses="[{'text-success stroke-current': taskLocal.isImportant}, 'w-5', 'h-5 mr-4']" @click.prevent="taskLocal.isImportant = !taskLocal.isImportant"></feather-icon>

                        <feather-icon icon="StarIcon" class="cursor-pointer" :svgClasses="[{'text-warning stroke-current': taskLocal.isStarred}, 'w-5', 'h-5 mr-4']" @click.prevent="taskLocal.isStarred = !taskLocal.isStarred"></feather-icon>

                        <vs-dropdown class="cursor-pointer flex" vs-custom-content>

                            <feather-icon icon="TagIcon" svgClasses="h-5 w-5" @click.prevent></feather-icon>
                            <!-- <vs-button radius color="success" type="flat" iconPack="feather" icon="icon-tag" @click.prevent></vs-button> -->

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
                        <vs-input v-validate="'required'" name="title" class="w-full mb-4 mt-5" placeholder="Title" v-model="taskLocal.title" :color="validateForm ? 'success' : 'danger'" />
                        <vs-textarea rows="5" label="Add description" v-model="taskLocal.desc" />
                    </div>
                </div>

            </form>
        </div>
    </vs-prompt>
    </div>
</template>

<script>
export default {
    data() {
        return {
            activePrompt: false,

            taskLocal: {
              title: "",
              desc: "",
              isCompleted: false,
              isImportant: false,
              isStarred: false,
              tags: []
            }
        }
    },
    computed: {
        taskTags() {
            return this.$store.state.todo.taskTags
        },
        validateForm() {
            return !this.errors.any() && this.taskLocal.title != ''
        }
    },
    methods: {
        clearFields() {
            Object.assign(this.taskLocal, {
              title: "",
              desc: "",
              isCompleted: false,
              isImportant: false,
              isStarred: false,
              tags: []
            })
        },
        addTodo() {
            this.$validator.validateAll().then(result => {
                if (result) {
                  this.$store.dispatch('todo/addTask', Object.assign({}, this.taskLocal))
                  this.clearFields()
                }
            })
        }
    },
}
</script>
