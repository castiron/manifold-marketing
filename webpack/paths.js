const path = require("path");

const root = path.resolve(__dirname, "..");

module.exports = {
  root: root,
  js: projectName => {
    return path.resolve(root, `./themes/${projectName}/assets/javascript`);
  }
};
