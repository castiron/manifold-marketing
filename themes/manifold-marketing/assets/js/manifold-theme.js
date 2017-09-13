import domHelp from "./lib/dom-help";
import ClassBurger from "./class-burger";
import HeightMatch from "./height-match";
import CssSlider from "./css-slider";

class ManifoldTheme {
  init() {
    domHelp.ready(()=> {
      // Initialize Overlay Burgers
      const hamburgerOverlay = new ClassBurger();

      // Initialize height matching elements
      const partnerNames = new HeightMatch('[data-mh=partner-name]');
      const partnerDescriptions = new HeightMatch(
        '[data-mh=partner-description]'
      );

      const blogPostNames = new HeightMatch('[data-mh=blog-post-name]');
      const blogPostDescriptions = new HeightMatch(
        '[data-mh=blog-post-description]'
      );

      // Initialize sliders
      const sliders = document.querySelectorAll('[data-slider]');
      [...sliders].forEach(function(slider) {
        const sliderEl = slider.querySelector('[data-element]');
        const count = sliderEl.getAttribute('data-count');
        const cssSlider = new CssSlider(count, slider);
      });
    });
  }
}

export default ManifoldTheme;
