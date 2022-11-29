const { defineConfig } = require("@vue/cli-service");
const Dotenv = require("dotenv-webpack");

module.exports = defineConfig({
  configureWebpack: {
    plugins: [new Dotenv()],
  },
  transpileDependencies: true,
  publicPath: "/grant-trails-heatmap/",
  // publicPath:
  //   process.env.NODE_ENV === "production" ? "/grant-trails-redo/" : "/",
});
