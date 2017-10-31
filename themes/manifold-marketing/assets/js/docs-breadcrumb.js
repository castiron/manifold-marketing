import { addClass, hasClass } from "./lib/dom-help.js";

class DocumentationBreadcrumb {
  constructor(sidebar, activeNode) {
    const activeNodeClone = this.clonedLink(activeNode);
    this.sidebar = sidebar;
    this.breadcrumbArray = [activeNodeClone];
    this.nextParent = activeNode.parentNode;
    this.breadcrumb = document.querySelector('[data-documentation-breadcrumb]');

    if (this.breadcrumb) {
      this.collectLinks();
      this.addBreadcrumb();
    }
  }

  clonedLink(link) {
    const linkClone = document.createElement("a");
    linkClone.href = link.href;
    linkClone.innerHTML = link.innerHTML;
    linkClone.classList = link.classList;

    return linkClone;
  }

  collectLinks() {
    while (this.nextParent !== this.sidebar && this.nextParent !== null) {
      const toggleIndicator = this.nextParent.firstChild;
      const isNode = toggleIndicator.nodeName === 'SPAN';

      if (isNode && hasClass(toggleIndicator, 'toggle-indicator')) {
        const link = toggleIndicator.nextElementSibling;
        const linkClone = this.clonedLink(link);
        this.breadcrumbArray.unshift(linkClone);
        toggleIndicator.click();
      }

      this.nextParent = this.nextParent.parentNode;
    }
  }

  addBreadcrumb() {
    this.breadcrumbArray.forEach((link) => {
      addClass(link, 'breadcrumb-link');
      this.breadcrumb.append(link);
    })
  }
}

module.exports = DocumentationBreadcrumb;
