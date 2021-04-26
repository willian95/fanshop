export const state = () => ({
    searchType:"",
    searchQuery:"",
    searchPage:"",
    searchClicked:false,
    loadingStatus:false,
    selectedPurchasedProducts:[]
})
  
export const getters = {

    getSearch(state){

        let search = {
            "type": state.searchType,
            "query": state.searchQuery,
            "page": state.searchPage
        }

        return search
    },
    getSearchClicked(state){
        return state.searchClicked
    },
    isAuthenticated(state) {
        return state.auth.loggedIn
    },
    loggedInUser(state) {
        return state.auth.user
    },
    getSelectedPurchasedProducts(state){
        return state.selectedPurchasedProducts
    },

}

export const actions = {

    storeSearch({commit}, {type, query, page}){
        commit('storeSearch', {type, query, page})
    },
    storeSearchClicked({commit}, {value}){
        commit('storeSearchClicked', {value})
    },
    storeSelectedPurchasedProducts({commit}, {value}){
        commit('storeSelectedPurchasedProducts', {value})
    }

}

export const mutations = {

    storeSearch(state, {type, query, page}){
        state.searchType = type
        state.searchQuery = query
        state.searchPage = page
    },
    storeSearchClicked(state, {value}){
        state.searchClicked = value
    },
    storeSelectedPurchasedProducts(state, {value}){
        state.selectedPurchasedProducts = value
    }

}