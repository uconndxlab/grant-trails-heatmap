import { createStore } from "vuex";
import supabase from "@/supabase";

export default createStore({
  state: {
    grants: [],
    condensedPurchases: [],
    current_type: "All",
    current_year: "2020",
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
    currentType(state) {
      return state.current_type;
    },
    currentYear(state) {
      return state.current_year;
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
    setCurrentType(state, current_type) {
      state.current_type = current_type;
    },
    setCurrentYear(state, current_year) {
      state.current_year = current_year;
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
        let year_num = parseInt(searchOptions[0]);
        selected_fiscal_years.push(year_num);
      } else {
        let year_nums = searchOptions[0].map((number) => parseInt(number));
        selected_fiscal_years = year_nums;
      }
      let selected_fund_type = searchOptions[1];
      let { data, error } = await supabase.rpc("fetchfilteredpurchasetotal", {
        selected_fiscal_years,
        selected_fund_type,
      });
      if (error) console.error(error);
      else {
        commit("setGrants", data);
        commit("setCurrentType", selected_fund_type);
        commit("setCurrentYear", selected_fiscal_years);
      }
      console.log(data);
    },
  },
  modules: {},
});
