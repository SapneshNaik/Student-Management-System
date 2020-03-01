/*=========================================================================================
  File Name: moduleCalendarMutations.js
  Description: Calendar Module Mutations
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

import commons from "../../commons";

export default {
  SET_USERS(state, users) {
    state.users = users
  },


  REMOVE_RECORD(state, itemId) {
    const userIndex = state.users.findIndex((u) => u.id == itemId)
    state.users.splice(userIndex, 1)
  },

  RESET_ADMINS(state) {
    state.admins = []
  },

  ADD_OR_UPDATE_ADMIN(state, item) {
    commons.upsertSort(state.admins, item)
  },

  UPDATE_ADMINS(state, admins) {
    commons.mergeByProperty(state.admins, admins, 'user_id');
    state.admins.sort(commons.compare);
  },

  RESET_PARENTS(state) {
    state.parents = []
  },

  ADD_OR_UPDATE_PARENT(state, item) {
    commons.upsertSort(state.parents, item)
  },

  UPDATE_PARENTS(state, parents) {
    commons.mergeByProperty(state.parents, parents, 'user_id');
    state.parents.sort(commons.compare);

  },

  RESET_STAFF(state) {
    state.staffs = []
  },

  ADD_OR_UPDATE_STAFF(state, item) {
    commons.upsertSort(state.staffs, item)
  },

  UPDATE_STAFF(state, staffs) {
    commons.mergeByProperty(state.staffs, staffs, 'user_id');
    state.staffs.sort(commons.compare);

  },

  RESET_STUDENTS(state) {
    state.students = []
  },

  ADD_OR_UPDATE_STUDENT(state, item) {
    commons.upsertSort(state.students, item)
  },

  UPDATE_STUDENTS(state, students) {
    commons.mergeByProperty(state.students, students, 'user_id');
    state.students.sort(commons.compare);

  },

  RESET_ROLES(state) {
    state.roles = []
  },

  ADD_OR_UPDATE_ROLE(state, item) {
    commons.upsertSort(state.roles, item)
  },

  UPDATE_ROLES(state, roles) {
    commons.mergeByProperty(state.roles, roles, 'id');
    state.roles.sort(commons.compare);
  },

  RESET_PERMISSIONS(state) {
    state.permissions = []
  },

  UPDATE_PERMISSIONS(state, permissions) {
    commons.mergeByProperty(state.permissions, permissions, 'id');
  },

}
