/*=========================================================================================
  File Name: mutations.js
  Description: Vuex Store - mutations
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


const mutations = {


  // /////////////////////////////////////////////
  // COMPONENTS
  // /////////////////////////////////////////////

  // Vertical NavMenu

  TOGGLE_IS_VERTICAL_NAV_MENU_ACTIVE(state, value) {
    state.isVerticalNavMenuActive = value
  },
  TOGGLE_REDUCE_BUTTON(state, val) {
    state.reduceButton = val
  },
  UPDATE_MAIN_LAYOUT_TYPE(state, val) {
    state.mainLayoutType = val
  },
  UPDATE_VERTICAL_NAV_MENU_ITEMS_MIN(state, val) {
    state.verticalNavMenuItemsMin = val
  },
  UPDATE_VERTICAL_NAV_MENU_WIDTH(state, width) {
    state.verticalNavMenuWidth = width
  },


  // VxAutoSuggest

  UPDATE_STARRED_PAGE(state, payload) {

    // find item index in search list state
    const index = state.navbarSearchAndPinList["pages"].data.findIndex((item) => item.url == payload.url)

    // update the main list
    state.navbarSearchAndPinList["pages"].data[index].is_bookmarked = payload.val

    // if val is true add it to starred else remove
    if (payload.val) {
      state.starredPages.push(state.navbarSearchAndPinList["pages"].data[index])
    } else {
      // find item index from starred pages
      const index = state.starredPages.findIndex((item) => item.url == payload.url)

      // remove item using index
      state.starredPages.splice(index, 1)
    }
  },

  // Navbar-Vertical

  ARRANGE_STARRED_PAGES_LIMITED(state, list) {
    const starredPagesMore = state.starredPages.slice(10)
    state.starredPages = list.concat(starredPagesMore)
  },
  ARRANGE_STARRED_PAGES_MORE(state, list) {
    let downToUp = false
    let lastItemInStarredLimited = state.starredPages[10]
    const starredPagesLimited = state.starredPages.slice(0, 10)
    state.starredPages = starredPagesLimited.concat(list)

    state.starredPages.slice(0, 10).map((i) => {
      if (list.indexOf(i) > -1) downToUp = true
    })

    if (!downToUp) {
      state.starredPages.splice(10, 0, lastItemInStarredLimited)
    }
  },


  // ////////////////////////////////////////////
  // UI
  // ////////////////////////////////////////////

  TOGGLE_CONTENT_OVERLAY(state, val) {
    state.bodyOverlay = val
  },
  UPDATE_PRIMARY_COLOR(state, val) {
    state.themePrimaryColor = val
  },
  UPDATE_THEME(state, val) {
    state.theme = val
  },
  UPDATE_WINDOW_WIDTH(state, width) {
    state.windowWidth = width
  },
  UPDATE_WINDOW_SCROLL_Y(state, val) {
    state.scrollY = val
  },


  // /////////////////////////////////////////////
  // User/Account
  // /////////////////////////////////////////////

  // Updates user info in state and localstorage
  UPDATE_USER_INFO(state, payload) {

    // Get Data localStorage
    let userInfo = JSON.parse(localStorage.getItem("userInfo")) || state.AppActiveUser

    for (const property of Object.keys(payload.user)) {

      if (payload.user[property] != null) {
        // If some of user property is null - user default property defined in state.AppActiveUser
        state.AppActiveUser[property] = payload.user[property]

        // Update key in localStorage
        userInfo[property] = payload.user[property]
      }
    }
    // Store data in localStorage
    localStorage.setItem("userInfo", JSON.stringify(userInfo))
  },

  UPDATE_USER_PROFILE(state, payload) {

    let userInfo = JSON.parse(localStorage.getItem("userInfo")) || state.AppActiveUser

    for (const property of Object.keys(payload)) {
      let role = state.AppActiveUser.base_role.toLowerCase();
      state.AppActiveUser[role][property] = payload[property]
      userInfo[role][property] = payload[property]
    }
    // Store data in localStorage
    localStorage.setItem("userInfo", JSON.stringify(userInfo))
  },


  UPDATE_USER_ROLES(state, payload) {
    localStorage.setItem("user_roles", JSON.stringify(payload))

    state.UserRoles = payload
  },

  UPDATE_USER_PERMS(state, payload) {
    localStorage.setItem("user_perms", JSON.stringify(payload))
    state.UserPerms = payload
  },

  UPDATE_USER_ROLE_INFO(state, payload) {

    // Get Data localStorage
    let roleInfo = JSON.parse(localStorage.getItem("role_data")) || state.AppActiveUserRoleDetails

    for (const property of Object.keys(payload)) {
      if (payload[property] != null) {
        // If some of user property is null - user default property defined in state.AppActiveUser
        state.AppActiveUserRoleDetails[property] = payload[property]

        // Update key in localStorage
        roleInfo[property] = payload[property]
      }
    }
    // Store data in localStorage
    localStorage.setItem("role_data", JSON.stringify(roleInfo))
  },


  UPDATE_USER_PERM_INFO(state, payload) {

    // Get Data localStorage
    let perm_data = JSON.parse(localStorage.getItem("perm_data")) || state.AppActiveUserPermDetails

    for (const property of Object.keys(payload)) {

      if (payload[property] != null) {
        // If some of user property is null - user default property defined in state.AppActiveUserPermDetails
        state.AppActiveUserPermDetails [property] = payload[property]

        // Update key in localStorage
        perm_data[property] = payload[property]
      }


    }
    // Store data in localStorage
    localStorage.setItem("perm_data", JSON.stringify(perm_data))
  },

  RESET_USER_DETAILS(state) {
    state.AppActiveUser = {};
    state.AppActiveUserPermDetails = {};
    state.AppActiveUserRoleDetails = {};
    state.UserPerms = [];
    state.UserRoles = [];
  }
}

export default mutations

