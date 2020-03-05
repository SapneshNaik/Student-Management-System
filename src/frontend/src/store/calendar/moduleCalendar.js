/*=========================================================================================
  File Name: moduleCalendar.js
  Description: Calendar Module
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


import state from './moduleCalendarState.js'
import mutations from './moduleCalendarMutations.js'
import actions from './moduleCalendarActions.js'
import getters from './moduleCalendarGetters.js'

export default {
	namespaced: true,
    state: state,
    mutations: mutations,
    actions: actions,
    getters: getters
}
