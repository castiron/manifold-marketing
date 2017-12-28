import { toggleClass, removeClass, addEscListener } from "./lib/dom-help.js";

class ClassBurger {
  constructor(
    label = 'hamburger',
    onClass = "open",
    callback = function() {
      return true;
    }
  ) {
    const toggleSelector = "[data-hamburger-togglable=" + label + "]";
    const triggerSelector = "[data-hamburger-toggle=" + label + "]";
    const dataToggles = document.querySelectorAll(toggleSelector);
    const dataTriggers = document.querySelectorAll(triggerSelector);
    if (dataToggles.length > 0) {
      // Bind toggle trigger
      this.bindTrigger(dataToggles, dataTriggers, label, onClass, callback);
    } else {
      console.log("Togglable element with value " + label + " does not exist.");
    }
  }

  bindTrigger(nodes, triggers, label, onClass, callback) {
    if (triggers.length > 0) {
      // Bind click handler
      [...triggers].forEach(trigger => {
        trigger.addEventListener("click", function() {
          [...triggers].forEach(internalTrigger => {
            toggleClass(internalTrigger, onClass);
          });

          [...nodes].forEach(toggle => {
            toggleClass(toggle, onClass);
            callback(toggle);
          });

          document.addEventListener("keyup", function onEscHandler(event) {
            if (event.keyCode === 27) {
              [...triggers].forEach(trigger => {
                removeClass(trigger, onClass);
              });

              [...nodes].forEach(toggle => {
                removeClass(toggle, onClass);
                callback(toggle);
              });

              document.removeEventListener("keyup", onEscHandler);
            }
          });

          document.addEventListener("click", function onClickHandler(event) {
            let parenting = true;
            let parent = event.target;
            let shouldClose = true;

            while (parenting) {
              if (parent === null || parent === document) {
                shouldClose = true;
                parenting = false;
                break;
              } else if (parent.hasAttribute('data-hamburger-togglable') ||
                  parent.hasAttribute('data-hamburger-toggle')) {
                shouldClose = false;
                parenting = false;
                break;
              }

              parent = parent.parentNode;
            }

            if (shouldClose) {
              [...triggers].forEach(trigger => {
                removeClass(trigger, onClass);
              });

              [...nodes].forEach(toggle => {
                removeClass(toggle, onClass);
              });

              document.removeEventListener("click", onClickHandler);
            }
          });
        });
      });
    } else {
      console.log("Trigger " + label + " does not exist");
    }
  }
}

module.exports = ClassBurger;
