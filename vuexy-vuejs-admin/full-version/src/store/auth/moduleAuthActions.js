/*=========================================================================================
  File Name: moduleAuthActions.js
  Description: Auth Module Actions
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

import jwt from "../../http/requests/auth/jwt/index.js"


import 'firebase/auth'
import router from '@/router'

export default {

  // JWT
  loginJWT({commit}, payload) {

    return new Promise((resolve, reject) => {
      jwt.login(payload.userDetails.login_id, payload.userDetails.password)
        .then(response => {

          console.log("log in success");// If there's user data in response
          if (response.status === 200) {

            console.log("Logged user data");
            console.log(response.data.user);
            // Navigate User to homepage
            router.push(router.currentRoute.query.to || '/dashboard/sms')

            // Set accessToken
            localStorage.setItem("accessToken", response.data.access_token)

            // Update user details
            //DONE: Modify backend to return user data on login and enable below code
            commit('UPDATE_USER_INFO', response.data, {root: true})


            // Set bearer token in axios
            commit("SET_BEARER", response.data.access_token)

            resolve(response)
          } else {
            reject({message: "Wrong Username or Password"})
          }

        })
        .catch(error => {
          reject(error)
        })
    })
  },

  logoutJWT({commit}) {
    commit("RESET_USER_DETAILS", null, {root: true});

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

  registerUserJWT({commit}, payload) {

    const {displayName, email, password, confirmPassword} = payload.userDetails

    return new Promise((resolve, reject) => {

      // Check confirm password
      if (password !== confirmPassword) {
        reject({message: "Password doesn't match. Please try again."})
      }

      jwt.registerUser(displayName, email, password)
        .then(response => {
          // Redirect User
          router.push(router.currentRoute.query.to || '/')

          // Update data in localStorage
          localStorage.setItem("accessToken", response.data.accessToken)
          commit('UPDATE_USER_INFO', response.data.userData, {root: true})

          resolve(response)
        })
        .catch(error => {
          reject(error)
        })
    })
  },

  fetchAccessToken() {
    return new Promise((resolve) => {
      jwt.refreshToken().then(response => {
        resolve(response)
      })
    })
  }
}
