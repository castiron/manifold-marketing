const path = require("path");
const webpack = require("webpack");
const WebpackAssetsManifest = require('webpack-assets-manifest');
const config = require("./base.conf");
const env = { NODE_ENV: JSON.stringify("production") };

const assetsManifest = new WebpackAssetsManifest({
  publicPath(filename, manifest) {
    // Append either asset directory or dev server url
    return path.resolve("/assets/", filename);
  },
  output: path.resolve(config.output.path, "manifest.json"),
  writeToDisk: true,
  done(manifest, stats) {
    console.log(`The asset manifest has been written to ${manifest.getOutputPath()}`);
  }
});

config.plugins.push(assetsManifest);

config.plugins.push(new webpack.DefinePlugin({ "process.env": env }));
config.devtool = "source-map";

module.exports = config;
