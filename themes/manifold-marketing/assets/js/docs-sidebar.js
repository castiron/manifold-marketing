import {
  debounce,
  addClass,
  removeClass,
  hasClass,
  prefixedEvent
} from "./lib/dom-help.js";
import { expand, collapse } from "./lib/height-help.js";
import DocsBreadcrumb from "./docs-breadcrumb";

// Accordions are a special case of height-reveal toggles+reveals;
// They behave the same as height-reveal elements but utilize the
// "dataGroup" data attribute to handle closing the starting element
// when revealing the 'accordioned' element and clicking on an open
// accordion's toggle collapses it )i.e. returns it to its start state
class DocumentationSidebar {
  constructor(
    toggleSelector = 'li',
    onClass = 'open',
    dataSidebar = '[data-sidebar]'
  ) {
    // Get attribute names for each selector
    const sidebar = document.querySelector(dataSidebar);
    const path = window.location.pathname.split('/');
    const toggles = sidebar.querySelectorAll(toggleSelector);
    let activeNode = null;

    for (const [index, toggle] of [...toggles].entries()) {
      const link = toggle.firstChild;
      const fileName = link.innerHTML.toLowerCase().replace(/ /g, "_");
      const href = link.href;

      if (window.location.href === href) {
        addClass(link, 'active');
        activeNode = link;
      }

      if (!link.nextElementSibling) {
        continue;
      } else if (link.nextElementSibling.tagName === 'UL') {
        // Add accordion toggle
        const toggleIndicator = document.createElement("span");
        addClass(toggleIndicator, 'toggle-indicator');
        toggleIndicator.dataset.toggle = index;
        toggle.insertBefore(toggleIndicator, link);
        addClass(toggle, 'toggle');

        // Identify toggle target
        const reveal = link.nextElementSibling;
        reveal.dataset.reveal = index;
        addClass(reveal, 'accordion');

        const accordionTrigger = new AccordionTrigger(
          toggleIndicator,
          reveal,
          onClass
        );
      }

    }

    if (activeNode) {
      const breadcrumb = new DocsBreadcrumb(sidebar, activeNode);
    }
  }
}

class AccordionTrigger {
  constructor(triggerNode, revealNode, onClass) {
    this.trigger = triggerNode;
    this.reveal = revealNode;
    this.onClass = onClass;

    // Bind click handler
    this.bindTriggers();
    // window.addEventListener('resize', this.resizeHandler);
  }

  resizeHandler = () => {
    debounce(this.close(), 500);
  }

  bindTriggers() {
    prefixedEvent(this.reveal, "TransitionEnd", this.resetHeightDefault);

    this.trigger.addEventListener("click", event => {
      this.updateReveal();
    });
  }

  resetHeightDefault = () => {
    if (hasClass(this.reveal, this.onClass)) {
      this.reveal.style.maxHeight = 'none';
    }
  }

  resetHeight(node) {
    node.style.maxHeight = node.offsetHeight;
  }

  open() {
    addClass(this.trigger, this.onClass);
    addClass(this.reveal, this.onClass);
    expand(this.reveal);
  }

  hide() {
    removeClass(this.trigger, this.onClass);
    this.reveal.style.maxHeight = this.reveal.offsetHeight + 'px';
    setTimeout(() => {
      collapse(this.reveal);
      removeClass(this.reveal, this.onClass);
    }, 50);
  }

  updateReveal() {
    if (hasClass(this.trigger, this.onClass)) {
      this.hide();
    } else {
      this.open();
    }
  }

  close() {
    if (hasClass(this.reveal, this.onClass)) {
      this.hide();
    }
  }
}

module.exports = DocumentationSidebar;