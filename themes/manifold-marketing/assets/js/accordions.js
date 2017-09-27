import { addClass, removeClass, hasClass } from "./lib/dom-help.js";
import { expand, collapse } from "./lib/height-help.js";

// Accordions are a special case of height-reveal toggles+reveals;
// They behave the same as height-reveal elements but utilize the
// "dataGroup" data attribute to handle closing the starting element
// when revealing the 'accordioned' element and clicking on an open
// accordion's toggle collapses it )i.e. returns it to its start state
class AccordionGroup {
  constructor(
    dataToggle = "[data-accordion-toggle]",
    dataReveal = "[data-accordion]",
    onClass = "open",
    dataGroup = "[data-accordion-group]"
  ) {
    // console.log(dataToggle, dataReveal, onClass, dataGroup);
    // Get attribute names for each selector
    const toggleAttr = dataToggle.match(/\[(.*)\]/)[1];
    const revealAttr = dataReveal.match(/\[(.*)\]/)[1];
    // group attribute which the nodes share
    const groupAttr = dataGroup.match(/\[(.*)\]/)[1];

    // Find all elements with toggle data attribute
    const toggles = document.querySelectorAll(dataToggle);

    for (const toggle of [...toggles]) {
      // Get all of the reveal elements that match each trigger and
      // create a class for it
      const toggleId = toggle.getAttribute(toggleAttr);
      const reveals = document.querySelectorAll(
        "[" + revealAttr + "=" + toggleId + "]"
      );

      // Create a class with the height trigger, a node list of its reveals,
      // and the reveal and group attributes
      const accordionTrigger = new AccordionTrigger(
        toggle,
        reveals,
        onClass,
        revealAttr,
        groupAttr
      );
    }
  }
}

class AccordionTrigger {
  constructor(triggerNode, revealNodes, onClass, revealAttr, groupAttr) {
    this.trigger = triggerNode;
    this.reveals = revealNodes;

    // Group to which the nodes belong
    this.revealSelector = revealAttr;
    // Find all members of the group
    this.groupAccordions = document.querySelectorAll(
      "[" + groupAttr + "=" + this.trigger.getAttribute(groupAttr) + "]"
    );

    // Bind click handler
    this.trigger.addEventListener("click", event => {
      event.preventDefault();

      // Loop through group members
      for (const group of [...this.groupAccordions]) {
        if (group === this.trigger) {
          // Toggle onClass on group member if it's the reveals' trigger
          if (!hasClass(this.trigger, onClass)) {
            addClass(this.trigger, onClass);
          } else {
            removeClass(this.trigger, onClass);
          }
          // If it's not the trigger remove onClass
        } else {
          removeClass(group, onClass);
          // If it's also a 'reveal' node collapse it
          if (group.getAttribute(this.revealSelector)) {
            collapse(group);
          }
        }
      }

      // Loop through all of this trigger's reveals, expand/collapse them
      // and add the onClass
      for (const reveal of [...this.reveals]) {
        // Element needs to be opened;
        if (!hasClass(this.trigger, onClass)) {
          // Already handled class removal above
          collapse(reveal);
        } else {
          addClass(reveal, onClass);
          expand(reveal);
          // setTimeout(function() {
          //   reveal.style.maxHeight = "none";
          // }, 1000);
        }
      }
    });
  }
}

module.exports = AccordionGroup;
