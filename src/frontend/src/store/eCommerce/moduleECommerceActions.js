/*=========================================================================================
  File Name: moduleEcommerceActions.js
  Description: Ecommerce Module Actions
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

export default {
    toggleItemInWishList({ commit }, item) {
        commit('TOGGLE_ITEM_IN_WISH_LIST', item)
    },
    toggleItemInCart({ getters, commit, dispatch }, item) {
        getters.isInCart(item.objectID) ? commit('REMOVE_ITEM_FROM_CART', item) : dispatch("additemInCart", item)
    },
    additemInCart({ commit }, item) {

        // Below properties should be added as per requirement from back-end
        // This is added just for demo purpose
        item["quantity"] = 1
        item["discount_in_percentage"] = Math.floor(Math.random() * 20) + 4
        item["offers_count"] = Math.floor(Math.random() * 4) + 1
        item["delivery_date"] = new Date(new Date().getTime() + (Math.random()*10*24*60*60*1000)).toDateString().slice(0, -4)

        commit('ADD_ITEM_IN_CART', item)
    },
    updateItemQuantity({ commit }, payload){
      commit('UPDATE_ITEM_QUANTITY', payload)
    }
}
