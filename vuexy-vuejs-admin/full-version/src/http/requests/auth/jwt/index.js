import axios from "../../../axios/index.js"
import _ from 'lodash';

// import store from "../../../../store/store.js"

// Token Refresh
// let isAlreadyFetchingAccessToken = false
// let subscribers = []

// function onAccessTokenFetched(access_token) {
//   subscribers = subscribers.filter(callback => callback(access_token))
// }
//
// function addSubscriber(callback) {
//   subscribers.push(callback)
// }

axios.defaults.headers.common = {
  'Authorization': `Bearer ${localStorage.getItem("accessToken")}`,
  // 'Accept': 'application/json',
  // 'Access-Control-Allow-Origin': '*'
};

export default {
  init() {
    axios.interceptors.response.use(function (response) {
      return response
    }, function (error) {
      // const { config, response: { status } } = error
      // const { config, response } = error
      // const originalRequest = config

      // if (response && response.status === 401) {
      //   if (!isAlreadyFetchingAccessToken) {
      //     isAlreadyFetchingAccessToken = true
      //     store.dispatch("auth/fetchAccessToken")
      //       .then((access_token) => {
      //         isAlreadyFetchingAccessToken = false
      //         onAccessTokenFetched(access_token)
      //       })
      //   }
      //
      //   const retryOriginalRequest = new Promise((resolve) => {
      //     addSubscriber(access_token => {
      //       originalRequest.headers.Authorization = 'Bearer ' + access_token
      //       resolve(axios(originalRequest))
      //     })
      //   })
      //   return retryOriginalRequest
      // }
      return Promise.reject(error)
    })
  },

  sanitizePayload(a){
    return _(a).omitBy(_.isNil).omitBy(i => i === "").value()
  },

  login(login_id, pwd) {
    return axios.post("/api/v1/login", {login_id: login_id, password: pwd})
  },

  logout() {
    return axios.get("/api/v1/logout")
  },

  createUser(payload) {
    return axios.post("/api/v1/register", this.sanitizePayload(payload))
  },

  createAdminProfile(user_id, payload) {
    return axios.post(`/api/v1/admins/${user_id}`, this.sanitizePayload(payload))
  },

  createStaffProfile(user_id, payload) {
    return axios.post(`/api/v1/staffs/${user_id}`, this.sanitizePayload(payload))
  },

  createParentProfile(user_id, payload) {
    return axios.post(`/api/v1/parents/${user_id}`, this.sanitizePayload(payload))
  },

  createStudentProfile(user_id, payload) {
    return axios.post(`/api/v1/students/${user_id}`, this.sanitizePayload(payload))
  },

  assignRoleToUser(user_id, role_id, password) {
    return axios.post(`/api/v1/roles/${role_id}/addUser/${user_id}`, {password})
  },

  // refreshToken() {
  //   return axios.post("/api/auth/refresh-token", {accessToken: localStorage.getItem("accessToKen")})
  // },

  getLoggedInUserDetailsWithRoleAndPerm(role) {
    return axios.get(`api/v1/user?include=roles,${role}&append=all_permissions`)
  },

  getUser(userId) {
    return axios.get(`api/v1/users/${userId}?include=roles,admin,staff,parent,student&append=all_permissions`)
  },

  getParent(userId) {
    return axios.get(`api/v1/parents/${userId}`)
  },

  putUser(payload) {
    return axios.put(`api/v1/users/${payload.id}`, this.sanitizePayload(payload));
  },

  putAdmin(payload) {
    return axios.put(`api/v1/admins/${payload.user_id}`, this.sanitizePayload(payload));
  },

  getAllRolesWithPerms(URL = "api/v1/roles?include=permissions&fields[permissions]=id,name", allRoles = []) {

    return axios.get(URL)
      .then((response) => {
        allRoles = allRoles.concat(response.data.data);
        if (response.data.next_page_url != null) {
          return this.getAllRolesWithPerms(response.data.next_page_url, allRoles);
        } else {
          return allRoles;
        }
      })
  },


  getAllPerms(URL = "/api/v1/permissions", allPerms = []) {
    return axios.get(URL)
      .then((response) => {
        allPerms = allPerms.concat(response.data.data);
        if (response.data.next_page_url != null) {
          return this.getAllPerms(response.data.next_page_url, allPerms);
        } else {
          return allPerms;
        }
      })
  },

  getParentSearch(searchTerm) {
    return axios.get(`/api/v1/parent-search?value=${searchTerm}`);
  }
  // allPerms() {
  //   return axios.put(`api/v1/roles?include=permissions&fields[permissions]=id,name`);
  // }
}
