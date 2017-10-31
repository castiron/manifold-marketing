import { addClass } from "./lib/dom-help.js";

class DocumentationPagination {
  constructor(previous, next) {
    this.pagination = document.querySelector('[data-documentation-pagination]');
    this.pageLeft = this.pagination.querySelector('[data-docs-pager="left"]');
    this.pageRight = this.pagination.querySelector('[data-docs-pager="right"]');
    this.previousLink = this.extractLink(previous);
    this.nextLink = this.extractLink(next);

    this.setPagination();
  }

  extractLink(toggle) {
    if (!toggle) { return null; }

    const children = toggle.children;
    const link = {'href': null, 'title': null};

    if (toggle.children.length > 1) {
      const child = toggle.children[1];
      link.href = child.href;
      link.title = child.innerHTML;
    } else {
      const child = toggle.children[0];
      link.href = child.href;
      link.title = child.innerHTML;
    }

    return link;
  }

  setPagination() {
    if (this.previousLink) {
      this.pageLeft.href = this.previousLink.href;
      this.pageLeft.innerHTML = this.previousLink.title;
    } else {
      addClass(this.pageLeft, 'hidden');
    }

    if (this.nextLink) {
      this.pageRight.href = this.nextLink.href;
      this.pageRight.innerHTML = this.nextLink.title;
    } else {
      addClass(this.pageRight, 'hidden');
    }
  }
}

module.exports = DocumentationPagination;
