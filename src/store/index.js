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
    setGrants(state, grants) {
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
      await dispatch("fetchFilterGrants", [["2020"], "All"]);
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
      else commit("setGrants", data);
      console.log(data);
    },

    async fetchFilterGrants({ commit }, searchOptions) {
      let selected_fiscal_years = [];
      if (typeof searchOptions[0] == "string") {
        selected_fiscal_years.push(searchOptions[0]);
      } else {
        selected_fiscal_years = searchOptions[0];
      }
      let selected_fund_type = searchOptions[1];
      let { data, error } = await supabase.rpc("fetchfilteredpurchases", {
        selected_fiscal_years,
        selected_fund_type,
      });
      if (error) console.error(error);
      else commit("setGrants", data);
      console.log(data);
    },
  },
  modules: {},
});
