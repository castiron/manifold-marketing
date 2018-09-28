// Import Polyfills
import "babel-polyfill";

// Import Styles
import "./stylesheets/styles.scss";

// Import JS
import ManifoldTheme from "./js/manifold-theme";

const theme = new ManifoldTheme();
theme.init();
