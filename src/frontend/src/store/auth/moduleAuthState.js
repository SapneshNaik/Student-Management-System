/*=========================================================================================
  File Name: moduleAuthState.js
  Description: Auth Module State
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


// import auth from "@/auth/authService";

import 'firebase/auth'

export default {
    isUserLoggedIn: () => {
      if(localStorage.getItem("accessToken")) {
        return true;
      }

      return false;
    },
}
