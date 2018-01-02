import domHelp from "./lib/dom-help";
import ClassBurger from "./class-burger";
import Accordions from "./accordions";
import DocumentationSidebar from "./docs-sidebar";
import HeightMatch from "./height-match";
import ScrollTarget from "./scroll-target";
import ScrollLock from "./ScrollLock";
import CssSlider from "./css-slider";
import Tabs from "./tabs";
import VideoOverlay from "./video-overlay";
import Rellax from "rellax";
import AjaxListener from "./lib/ajax-listener";
import Modernizr from "./lib/modernizr-custom";

class ManifoldTheme {
  init() {
    domHelp.ready(()=> {
      // Instantiate scroll lock for use with hamburgers
      const scrollLock = new ScrollLock();

      // Initialize Overlay Burgers
      const hamburgerOverlay = new ClassBurger('hamburger', 'open', (el) => {
        scrollLock.lock(el);
      }, function(el) {
        scrollLock.unlock(el);
      });

      // Instantiate video players with overlay
      const videoOverlay = new VideoOverlay('[data-overlay-video]');

      // Initialize Accordions
      const accordions = new Accordions();

      // Initialize Mobile Documentation Sidebar
      if (document.querySelector('.sidebar')) {
        const mobileDocSidebar = new ClassBurger('sidebar', 'open');
      }

      // Initialize Documentation Sidebar Accordions
      const docSidebar = new DocumentationSidebar();

      // Initialize height matching elements
      const summaryNames = new HeightMatch('[data-mh=summary-name]');

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

      // Initialize tabs
      const tabbedSections = document.querySelectorAll('[data-tabbed]');
      [...tabbedSections].forEach(function(tabbedSection) {
        const sliderEl = tabbedSection.querySelector('[data-element]');
        const count = sliderEl.getAttribute('data-count');
        const tabs = new Tabs(count, tabbedSection);
      });

      // Initialize Parallaxes
      if (document.querySelectorAll('.rellax-image').length > 0) {
        const parallaxes = new Rellax(
          '.rellax-image',
          {
            center: true,
            speed: 2,
            round: true
          }
        );
      }

      // Initialize scroll triggered elements
      const scrollTargets = document.querySelectorAll('[data-scroll-target]');
      [...scrollTargets].forEach(function(target) {
        const scrollTarget = new ScrollTarget(target, 'animated');
      });
    });
  }
}

export default ManifoldTheme;
