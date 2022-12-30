import { createStore } from "vuex";
import supabase from "@/supabase";

export default createStore({
  state: {
    grants: [],
    condensedPurchases: [],
  },
  getters: {
    grants(state) {
      return state.grants;
    },
    condensedPurchases(state) {
      return state.condensedPurchases;
    },
    bootstrapped(state) {
      return state.dataHasBeenRetrieved;
    },
  },
  mutations: {
    setAllGrants(state, grants) {
      state.grants = grants;
    },
    setCondensedPurchases(state, condensedPurchases) {
      state.condensedPurchases = condensedPurchases;
    },
    setDataHasBeenRetrieved(state, retrievedStatus) {
      state.dataHasBeenRetrieved = retrievedStatus;
    },
  },
  actions: {
    async bootstrap({ dispatch, commit }) {
      await dispatch("fetchCondensedPurchases");
      await dispatch("fetchAllGrants");
      console.log("bootstrapped");
      commit("setDataHasBeenRetrieved", true);
    },

    async fetchCondensedPurchases({ commit }) {
      let { data, error } = await supabase.rpc("fetchtotalamount");
      if (error) console.error(error);

      commit("setCondensedPurchases", data);
    },

    async fetchAllGrants({ commit }) {
      let { data, error } = await supabase.rpc("fetchallgrants");
      if (error) console.error(error);
      else commit("setAllGrants", data);
      console.log(data);
    },
  },
  modules: {},
});
