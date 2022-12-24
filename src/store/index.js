import { createStore } from "vuex";
import supabase from "@/supabase";

export default createStore({
  state: {
    zipcodes: [],
    coordinates: [],
  },
  getters: {
    zipcodes(state) {
      return state.zipcodes;
    },
    coordinates(state) {
      return state.coordinates;
    },
    bootstrapped(state) {
      return state.dataHasBeenRetrieved;
    },
  },
  mutations: {
    setCoordinates(state, coordinates) {
      state.coordinates = coordinates;
    },
    setDataHasBeenRetrieved(state, retrievedStatus) {
      state.dataHasBeenRetrieved = retrievedStatus;
    },
  },
  actions: {
    async bootstrap({ dispatch, commit }) {
      await dispatch("getCoordinates");
      console.log("bootstrapped");
      commit("setDataHasBeenRetrieved", true);
    },
    async getCoordinates({ commit }) {
      let { data: zipCodes, error } = await supabase
        .from("purchases")
        .select("Zip");
      if (error) throw error;

      let coordinates = [];

      const mapBoxToken = process.env.VUE_APP_MAPBOX_ACCESS_TOKEN;
      for await (const zipCode of zipCodes) {
        if (zipCode.Zip) {
          const response = await fetch(
            `https://api.mapbox.com/geocoding/v5/mapbox.places/${zipCode.Zip}.json?access_token=${mapBoxToken}&limit=1`
          );
          const data = await response.json();
          coordinates.push(data.features[0].geometry.coordinates);
        }
      }

      commit("setCoordinates", coordinates);
      console.log(coordinates);
    },
  },
  modules: {},
});
