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

  // eslint-disable-next-line
  updateAdmin({}, payload) {
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
// eslint-disable-next-line
  updateParent({}, payload) {
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
// eslint-disable-next-line
  updateStaff({}, payload) {
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
// eslint-disable-next-line
  updateStudent({}, payload) {

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


  getAllAdmins({dispatch}) {
    return new Promise((resolve, reject) => {
      dispatch('getAdminPage', 1).then(() => {
        resolve()
      }).catch((error) => {
        reject(error)
      })

    });
  },

  getAdminPage({commit, dispatch}, page) {

    return new Promise((resolve, reject) => {
      jwt.getAdmins(page)
        .then((response) => {
          commit('UPDATE_ADMINS', response.data.data);
          if (response.data.next_page_url != null) {
            dispatch('getAdminPage', (page + 1));
          }
          resolve()
        })
        .catch((error) => {
          reject(error)
        })
    });
  },

  getAllParents({dispatch}) {
    return new Promise((resolve, reject) => {

      // commit('RESET_PARENTS');

      dispatch('getParentPage', 1).then(() => {
        resolve()
      }).catch((error) => {
        reject(error)
      })

    });
  },

  getParentPage({commit, dispatch}, page) {

    return new Promise((resolve, reject) => {
      jwt.getParents(page)
        .then((response) => {
          commit('UPDATE_PARENTS', response.data.data);
          if (response.data.next_page_url != null) {
            dispatch('getParentPage', (page + 1));
          }
          resolve()
        })
        .catch((error) => {
          reject(error)
        })
    });
  },

  getAllStaffs({dispatch}) {
    return new Promise((resolve, reject) => {
      dispatch('getStaffPage', 1).then(() => {
        resolve()
      }).catch((error) => {
        reject(error)
      })

    });
  },

  getStaffPage({commit, dispatch}, page) {

    return new Promise((resolve, reject) => {
      jwt.getStaffs(page)
        .then((response) => {
          commit('UPDATE_STAFF', response.data.data);
          if (response.data.next_page_url != null) {
            dispatch('getStaffPage', (page + 1));
          }
          resolve()
        })
        .catch((error) => {
          reject(error)
        })
    });
  },

  getAllStudents({dispatch}) {
    return new Promise((resolve, reject) => {
      dispatch('getStudentPage', 1).then(() => {
        resolve()
      }).catch((error) => {
        reject(error)
      })

    });
  },

  getStudentPage({commit, dispatch}, page) {

    return new Promise((resolve, reject) => {
      jwt.getStudents(page)
        .then((response) => {
          commit('UPDATE_STUDENTS', response.data.data);
          if (response.data.next_page_url != null) {
            dispatch('getStudentPage', (page + 1));
          }
          resolve()
        })
        .catch((error) => {
          reject(error)
        })
    });
  },

  getAllRoles({dispatch}) {
    return new Promise((resolve, reject) => {
      dispatch('getRolePage', 1).then(() => {
        resolve()
      }).catch((error) => {
        reject(error)
      })

    });
  },

  getRolePage({commit, dispatch}, page) {

    return new Promise((resolve, reject) => {
      jwt.getRoles(page)
        .then((response) => {
          commit('UPDATE_ROLES', response.data.data);
          if (response.data.next_page_url != null) {
            dispatch('getRolePage', (page + 1));
          }
          resolve()
        })
        .catch((error) => {
          reject(error)
        })
    });
  },

  getAllPermissions({dispatch}) {
    return new Promise((resolve, reject) => {
      dispatch('getPermissionPage', 1).then(() => {
        resolve()
      }).catch((error) => {
        reject(error)
      })

    });
  },

  getPermissionPage({commit, dispatch}, page) {

    return new Promise((resolve, reject) => {
      jwt.getPermissions(page)
        .then((response) => {
          commit('UPDATE_PERMISSIONS', response.data.data);
          if (response.data.next_page_url != null) {
            dispatch('getPermissionPage', (page + 1));
          }
          resolve()
        })
        .catch((error) => {
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
    if (payload.type === "Role") {
      commit('REMOVE_ROLE', payload.data);
    } else {
      throw "invalid role " + payload.type + " in upsertToState"
    }
  }
}
