const path = require("path");
const webpack = require("webpack");
const WebpackAssetsManifest = require('webpack-assets-manifest');
const config = require("./base.conf");
const env = { NODE_ENV: JSON.stringify("development") };
const devServerPort = 9090;

config.plugins.push(new webpack.DefinePlugin({ "process.env": env }));
config.devtool = "eval-source-map";


const assetsManifest = new WebpackAssetsManifest({
  publicPath(filename, manifest) {
    // Append dev server url
    return `//localhost:${devServerPort}/assets/${filename}`;
  },
  output: path.resolve(config.output.path, "manifest.json"),
  writeToDisk: true,
  transform(assets, manifest) {
    // Add webpack-dev-server JS
    const withDev = assets;
    withDev['webpack-dev-server.js'] = `//localhost:${devServerPort}/webpack-dev-server.js`;

    return withDev;
  }
});

config.plugins.push(assetsManifest);

config.devServer = {
  port: devServerPort,
  contentBase: "www",
  publicPath: "/assets/",
  headers: {
    "Access-Control-Allow-Origin": "*",
    "Access-Control-Allow-Methods": "GET, POST, PUT, DELETE, PATCH, OPTIONS",
    "Access-Control-Allow-Headers":
      "X-Requested-With, content-type, Authorization"
  }
};

module.exports = config;
