// Includes
// --------------------
const path = require("path");
const webpack = require("webpack");

// Plugin/Option Includes
const PhpManifestPlugin = require("webpack-php-manifest");
const ExtractTextPlugin = require("extract-text-webpack-plugin");
const StyleLintPlugin = require("stylelint-webpack-plugin");
const autoprefixer = require("autoprefixer");

// Configuration
// --------------------
const projectRoot = path.resolve(__dirname, "../");
const devServerPort = 8080;
// Project name
const projectName = "manifold-marketing";
const isProduction = process.env.NODE_ENV === "production";

// Filename is always hashed, but can be branched here if need
const baseFileName = "[name]-[hash]";
process.traceDeprecation = true;

// Plugins
// --------------------
// Decalred before rules so they can be used inside rules
const plugins = [];

const extractSass = new ExtractTextPlugin({
  filename: baseFileName + ".css",
  disable: false
});

console.log("✨ Linting Styles...");
const styleLint = new StyleLintPlugin({
  configFile: path.resolve(projectRoot, ".stylelintrc.js"),
  syntax: "scss"
});

const uglifyJs = new webpack.optimize.UglifyJsPlugin({
  compress: { warnings: false },
  sourceMap: true
});

const phpManifest = new PhpManifestPlugin({
  path: "assets",
  // True or false flag to include dev-server js
  devServer: process.env.WEBPACK_DEV_SERVER,
  // Path prefix for assets from dev-server
  pathPrefix: process.env.WEBPACK_DEV_SERVER
    ? `http://localhost:${devServerPort}`
    : null
});

plugins.push(extractSass);
plugins.push(styleLint);
plugins.push(phpManifest);

if (isProduction) {
  plugins.push(uglifyJs);
}

// Rules
// --------------------
const rules = [];

const ruleJavascript = {
  test: /\.js$/,
  use: [
    {
      loader: "babel-loader",
      options: {
        presets: ["es2015", "stage-2"]
      }
    },
    {
      loader: "eslint-loader"
    }
  ],
  exclude: [
    path.resolve(projectRoot, "./node_modules"),
    path.resolve(projectRoot, `./themes/${projectName}/assets/js/lib`)
  ]
};

const ruleScss = {
  test: /\.scss$/,
  use: extractSass.extract({
    use: [
      {
        loader: "css-loader"
      },
      {
        loader: "postcss-loader",
        options: {
          syntax: "postcss-scss",
          plugins: [autoprefixer()]
        }
      },
      {
        loader: "sass-loader"
      }
    ],
    // use style-loader in development
    fallback: "style-loader"
  })
};

const ruleJSON = {
  test: /\.json$/,
  use: ["json-loader"]
};

const generateFileRule = ext => {
  return {
    test: new RegExp(`\\.${ext}$`),
    loader: "file-loader"
  };
};

const fileRuleTypes = [
  "jpg",
  "gif",
  "png",
  "eot",
  "ttf",
  "woff",
  "woff2",
  "svg"
];

rules.push(ruleJavascript);
rules.push(ruleScss);
rules.push(ruleJSON);
fileRuleTypes.forEach(type => {
  rules.push(generateFileRule(type));
});

// Output
// ---------------------
module.exports = {
  entry: {
    [`${projectName}-theme`]: [
      path.resolve(projectRoot, `themes/${projectName}/assets/manifest.js`)
    ]
  },
  // Depnding on process.env, this should be either a hash or a name
  output: {
    path: path.resolve(projectRoot, "www/assets"),
    filename: baseFileName + ".js"
  },
  devtool: "cheap-module-eval-source-map",
  devServer: {
    port: devServerPort,
    contentBase: "www",
    publicPath: "/assets/",
    headers: {
      "Access-Control-Allow-Origin": "*",
      "Access-Control-Allow-Methods": "GET, POST, PUT, DELETE, PATCH, OPTIONS",
      "Access-Control-Allow-Headers":
        "X-Requested-With, content-type, Authorization"
    }
  },
  module: { rules },
  plugins
};
