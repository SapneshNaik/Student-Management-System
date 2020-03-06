import jwt from "../http/requests/auth/jwt/index.js"


const actions = {

  // /////////////////////////////////////////////
  // COMPONENTS
  // /////////////////////////////////////////////

  // Vertical NavMenu
  updateVerticalNavMenuWidth({commit}, width) {
    commit('UPDATE_VERTICAL_NAV_MENU_WIDTH', width)
  },

  // VxAutoSuggest
  updateStarredPage({commit}, payload) {
    commit('UPDATE_STARRED_PAGE', payload)
  },

  // The Navbar
  arrangeStarredPagesLimited({commit}, list) {
    commit('ARRANGE_STARRED_PAGES_LIMITED', list)
  },
  arrangeStarredPagesMore({commit}, list) {
    commit('ARRANGE_STARRED_PAGES_MORE', list)
  },

  // /////////////////////////////////////////////
  // UI
  // /////////////////////////////////////////////

  toggleContentOverlay({commit}) {
    commit('TOGGLE_CONTENT_OVERLAY')
  },
  updateTheme({commit}, val) {
    commit('UPDATE_THEME', val)
  },

  // /////////////////////////////////////////////
  // User/Account
  // /////////////////////////////////////////////

  updateUserInfo({commit}, payload) {
    commit('UPDATE_USER_INFO', payload)
  },


  getDashboardStats({commit}) {
    jwt.getSMSStats().then((response) => {
      commit('SET_DASHBOARD_STATS', response.data.stats)
    }).catch((error) => {
      console.log(error)
    });
  }
}

export default actions
