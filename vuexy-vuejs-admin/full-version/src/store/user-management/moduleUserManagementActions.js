/*=========================================================================================
  File Name: moduleCalendarActions.js
  Description: Calendar Module Actions
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

import jwt from "../../http/requests/auth/jwt/index.js"

import state from "../state";

// axios.defaults.headers.common = {
//   'Authorization': `Bearer ${localStorage.getItem("accessToken")}`,
//   'Accept': 'application/json',
//   'Access-Control-Allow-Origin': '*'
// };

export default {


  // addItem({ commit }, item) {
  //   return new Promise((resolve, reject) => {
  //     axios.post("/api/data-list/products/", {item: item})
  //       .then((response) => {
  //         commit('ADD_ITEM', Object.assign(item, {id: response.data.id}))
  //         resolve(response)
  //       })
  //       .catch((error) => { reject(error) })
  //   })
  // },

  // fetchUsers({commit}) {
  //   return new Promise((resolve, reject) => {
  //     axios.get("/api/user-management/users")
  //       .then((response) => {
  //         commit('SET_USERS', response.data)
  //         resolve(response)
  //       })
  //       .catch((error) => {
  //         reject(error)
  //       })
  //   })
  // },

  fetchUser(context, userId) {
    return new Promise((resolve, reject) => {
      jwt.getUser(userId)
        .then((response) => {
          resolve(response)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  updateUser({ commit }, payload) {
    return new Promise((resolve, reject) => {
      jwt.putUser(payload)
        .then((response) => {
          if(payload.id == state.AppActiveUser.id) {
            commit('UPDATE_USER_INFO', payload, {root: true})
          }
          resolve(response)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  updateAdmin({ commit }, payload) {
    return new Promise((resolve, reject) => {
      jwt.putAdmin(payload)
        .then((response) => {
          if(payload.user_id == state.AppActiveUser.id) {
            commit('UPDATE_USER_ROLE_INFO', payload, {root: true})
          }
          resolve(response)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  fetchLoggedInUserRolePermission({ commit }, role) {
    return new Promise((resolve, reject) => {
      jwt.getLoggedInUserDetailsWithRoleAndPerm(role)
        .then((response) => {

          console.log("Role is " + role)
          console.log(response.data)
          if (response.data[role.toLowerCase()]) {
            commit('UPDATE_USER_ROLE_INFO', response.data[role.toLowerCase()], {root: true})
          }

          if (response.data.all_permissions) {
            commit('UPDATE_USER_PERM_INFO', response.data.all_permissions, {root: true})
          }

          resolve(response)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  // removeRecord({commit}, userId) {
  //   return new Promise((resolve, reject) => {
  //     axios.delete(`/api/user-management/users/${userId}`)
  //       .then((response) => {
  //         commit('REMOVE_RECORD', userId)
  //         resolve(response)
  //       })
  //       .catch((error) => {
  //         reject(error)
  //       })
  //   })
  // }
}
