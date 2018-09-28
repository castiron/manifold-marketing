// Includes
// --------------------
const webpack = require("webpack");
const path = require("path");
const paths = require("./paths");

// Plugin/Option Includes
const UglifyJsPlugin = require("uglifyjs-webpack-plugin");
// const WebpackAssetsManifest = require('webpack-assets-manifest');
const ExtractTextPlugin = require("extract-text-webpack-plugin");

// PostCSS plugins
const cssCustomProperties = require("postcss-custom-properties");
const autoprefixer = require("autoprefixer");

// Configuration
// --------------------
const projectRoot = path.resolve(__dirname, "../");
// Project name
const projectName = "manifold-marketing";
// Mode
// isProduction used internally
const isProduction = process.env.NODE_ENV === "production";
// mode used by webpack
const mode = isProduction ? "production" : "development";

// Filename is always hashed, but can be branched here if need
const baseFileName = "[name]-[hash]";
process.traceDeprecation = true;

// Plugins
// --------------------
// Declared before rules so they can be used inside rules
const plugins = [];

const extractSass = new ExtractTextPlugin({
  filename: baseFileName + ".css",
  disable: false
});

const uglifyJs = new UglifyJsPlugin({
  sourceMap: true,
  uglifyOptions: {
    compress: { warnings: false }
  }
});

plugins.push(extractSass);

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
        presets: ["env", "react"],
        plugins: ["transform-class-properties"]
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
      // NB: Post CSS Loader must come before SASS
      // or it will be skipped
      {
        loader: "postcss-loader",
        options: {
          syntax: "postcss-scss",
          plugins: [cssCustomProperties(), autoprefixer()]
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
  "otf",
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
  mode,
  entry: {
    [`${projectName}-theme`]: [
      path.resolve(projectRoot, `themes/${projectName}/assets/manifest.js`)
    ],
    [`contentment-previews`]: [
      path.resolve(
        projectRoot,
        `plugins/castiron/manifold/content/contentmentPreviews.js`
      )
    ]
  },
  resolve: {
    modules: [paths.js(projectName), "node_modules"]
  },
  output: {
    path: path.resolve(projectRoot, "www/assets"),
    filename: baseFileName + ".js"
  },
  module: { rules },
  plugins
};
