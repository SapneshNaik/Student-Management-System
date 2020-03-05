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

import _ from 'lodash';

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


  fetchRole(context, id) {
    return new Promise((resolve, reject) => {
      jwt.getRole(id)
        .then((response) => {
          resolve(response)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },


  updateUser({commit}, payload) {
    return new Promise((resolve, reject) => {
      jwt.putUser(payload)
        .then((response) => {
          if (payload.id == state.AppActiveUser.id) {
            commit('UPDATE_USER_INFO', {user: payload}, {root: true})
          }

          resolve(response)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  updateAdmin({commit}, payload) {
    console.log(commit)
    return new Promise((resolve, reject) => {
      jwt.putAdmin(payload)
        .then((response) => {
          if (payload.id == state.AppActiveUser.id) {
            // commit('UPDATE_USER_INFO', payload, {root: true})
            //TODO: update state
          }
          resolve(response)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  updateParent({commit}, payload) {
    console.log(commit)
    return new Promise((resolve, reject) => {
      jwt.putParent(payload)
        .then((response) => {
          if (payload.id == state.AppActiveUser.id) {
            // commit('UPDATE_USER_INFO', payload, {root: true})
            //TODO: update state
          }
          resolve(response)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  updateStaff({commit}, payload) {
    console.log(commit)
    return new Promise((resolve, reject) => {
      jwt.putStaff(payload)
        .then((response) => {
          if (payload.id == state.AppActiveUser.id) {
            // commit('UPDATE_USER_INFO', payload, {root: true})
            //TODO: update state
          }
          resolve(response)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  updateStudent({commit}, payload) {
    console.log(commit)
    console.log(payload)
    return new Promise((resolve, reject) => {
      jwt.putStudent(payload)
        .then((response) => {
          if (payload.id == state.AppActiveUser.id) {
            // commit('UPDATE_USER_INFO', payload, {root: true})
            //TODO: update state
          }
          resolve(response)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },


  fetchLoggedInUserRolePermission({commit}, role) {
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


  getAllAdmins({dispatch}) {
    return new Promise((resolve, reject) => {

      console.log("in getAllAdmins");
      // // commit('RESET_ADMINS');

      dispatch('getAdminPage', 1).then(() => {
        resolve()
      }).catch((error) => {
        console.log(error)
        reject(error)
      })

    });
  },

  getAdminPage({commit, dispatch}, page) {

    return new Promise((resolve, reject) => {
      console.log("in getAdminPage");
      jwt.getAdmins(page)
        .then((response) => {
          commit('UPDATE_ADMINS', response.data.data);
          if (response.data.next_page_url != null) {
            dispatch('getAdminPage', (page + 1));
          }
          resolve()
        })
        .catch((error) => {
          console.log("error in getAdminPage");
          reject(error)
        })
    });
  },

  getAllParents({dispatch}) {
    return new Promise((resolve, reject) => {

      console.log("in getAllParents");
      // commit('RESET_PARENTS');

      dispatch('getParentPage', 1).then(() => {
        resolve()
      }).catch((error) => {
        console.log(error)
        reject(error)
      })

    });
  },

  getParentPage({commit, dispatch}, page) {

    return new Promise((resolve, reject) => {
      console.log("in getParentPage");
      jwt.getParents(page)
        .then((response) => {
          commit('UPDATE_PARENTS', response.data.data);
          if (response.data.next_page_url != null) {
            dispatch('getParentPage', (page + 1));
          }
          resolve()
        })
        .catch((error) => {
          console.log("error in getParentPage");
          reject(error)
        })
    });
  },

  getAllStaffs({dispatch}) {
    return new Promise((resolve, reject) => {

      console.log("in getAllStaffs");
      // commit('RESET_STAFF');

      dispatch('getStaffPage', 1).then(() => {
        resolve()
      }).catch((error) => {
        console.log(error);
        reject(error)
      })

    });
  },

  getStaffPage({commit, dispatch}, page) {

    return new Promise((resolve, reject) => {
      console.log("in getStaffPage");
      jwt.getStaffs(page)
        .then((response) => {
          commit('UPDATE_STAFF', response.data.data);
          if (response.data.next_page_url != null) {
            dispatch('getStaffPage', (page + 1));
          }
          resolve()
        })
        .catch((error) => {
          console.log("error in getStaffPage");
          reject(error)
        })
    });
  },

  getAllStudents({dispatch}) {
    return new Promise((resolve, reject) => {

      console.log("in getAllStudents");
      // commit('RESET_STUDENTS');

      dispatch('getStudentPage', 1).then(() => {
        resolve()
      }).catch((error) => {
        console.log(error);
        reject(error)
      })

    });
  },

  getStudentPage({commit, dispatch}, page) {

    return new Promise((resolve, reject) => {
      console.log("in getStudentPage");
      jwt.getStudents(page)
        .then((response) => {
          commit('UPDATE_STUDENTS', response.data.data);
          if (response.data.next_page_url != null) {
            dispatch('getStudentPage', (page + 1));
          }
          resolve()
        })
        .catch((error) => {
          console.log("error in getStudentPage");
          reject(error)
        })
    });
  },

  getAllRoles({dispatch}) {
    return new Promise((resolve, reject) => {

      console.log("in getAllRoles");
      // commit('RESET_STUDENTS');

      dispatch('getRolePage', 1).then(() => {
        resolve()
      }).catch((error) => {
        console.log(error);
        reject(error)
      })

    });
  },

  getRolePage({commit, dispatch}, page) {

    return new Promise((resolve, reject) => {
      console.log("in getRolePage");
      jwt.getRoles(page)
        .then((response) => {
          commit('UPDATE_ROLES', response.data.data);
          if (response.data.next_page_url != null) {
            dispatch('getRolePage', (page + 1));
          }
          resolve()
        })
        .catch((error) => {
          console.log("error in getRolePage");
          reject(error)
        })
    });
  },

  getAllPermissions({dispatch}) {
    return new Promise((resolve, reject) => {

      console.log("in getAllPermissions");
      // commit('RESET_STUDENTS');

      dispatch('getPermissionPage', 1).then(() => {
        resolve()
      }).catch((error) => {
        console.log(error);
        reject(error)
      })

    });
  },

  getPermissionPage({commit, dispatch}, page) {

    return new Promise((resolve, reject) => {
      console.log("in getPermissionPage");
      jwt.getPermissions(page)
        .then((response) => {
          commit('UPDATE_PERMISSIONS', response.data.data);
          if (response.data.next_page_url != null) {
            dispatch('getPermissionPage', (page + 1));
          }
          resolve()
        })
        .catch((error) => {
          console.log("error in getPermissionPage");
          reject(error)
        })
    });
  },

  upsertToState({commit, rootState}, payload) {
    switch (payload.type) {
      case "Admin":
        commit('ADD_OR_UPDATE_ADMIN', payload.data);
        break;
      case "Parent":
        commit('ADD_OR_UPDATE_PARENT', payload.data);
        break;
      case "Staff":
        commit('ADD_OR_UPDATE_STAFF', payload.data);
        break;
      case "Student":
        commit('ADD_OR_UPDATE_STUDENT', payload.data);
        break;
      case "Role":
        commit('ADD_OR_UPDATE_ROLE', payload.data);
        break;

      default:
        throw "invalid role in upsertToState"
    }

    if (payload.data.user_id == rootState.AppActiveUser.id) {
      commit('UPDATE_USER_PROFILE', _.omit(payload.data, 'user'), {root: true})
    }
  },


  deleteRecord({commit}, payload) {
    switch (payload.type) {
      case "Role":
        commit('REMOVE_ROLE', payload.data);
        break;
      default:
        throw "invalid role " + payload.type + " in upsertToState"
    }
  }
}
