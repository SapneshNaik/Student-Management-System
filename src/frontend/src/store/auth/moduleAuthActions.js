import jwt from "../../http/requests/auth/jwt/index.js"


import router from '@/router'

export default {

  // JWT
  loginJWT({commit}, payload) {

    return new Promise((resolve, reject) => {
      jwt.login(payload.userDetails.login_id, payload.userDetails.password)
        .then(response => {

          if (response.status === 200) {


            // Navigate User to homepage

            // Set accessToken
            localStorage.setItem("accessToken", response.data.access_token);

            // Update user details
            //DONE: Modify backend to return user data on login and enable below code
            commit('UPDATE_USER_INFO', response.data, {root: true});
            commit('SET_NAV_MENU_ITEMS', response.data.user.all_permissions, {root: true});
            commit('SET_ACCESS_TOKEN', response.data.access_token, {root: true});


            // Set bearer token in axios
            commit("SET_BEARER", response.data.access_token);

            router.push(router.currentRoute.query.to || '/dashboard/sms');


            resolve(response)
          } else {
            reject({message: "Wrong Login Id or Password"})
          }

        })
        .catch(error => {
          reject(error)
        })
    })
  },

  logoutJWT() {
    return new Promise((resolve, reject) => {
      jwt.logout()
        .then(response => {
          resolve(response)
        })
        .catch(error => {
          reject(error)
        })
    })
  },

}
