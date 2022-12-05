const { defineConfig } = require("@vue/cli-service");
const Dotenv = require("dotenv-webpack");

module.exports = defineConfig({
  configureWebpack: {
    plugins: [new Dotenv()],
  },
  transpileDependencies: true,
  babel: {
    loaderOptions: {
      ignore: ["./node_mobdules/mapbox-gl/dist/mapbox-gl.js"],
    },
  },
});
