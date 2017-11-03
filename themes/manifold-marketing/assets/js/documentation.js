import { addClass } from "./lib/dom-help.js";
import DocumentationSidebar from "./docs-sidebar";
import DocumentationBreadcrumb from "./docs-breadcrumb";
import DocumentationPagination from "./docs-pagination";

class Documentation {
  constructor(docs) {
    this.docs = docs;
    const documentationSidebar = new DocumentationSidebar(
      'li',
      'open',
      '[data-sidebar]',
      this.onReady
    );

    if (documentationSidebar.activeNode) {
      const breadcrumb = new DocumentationBreadcrumb(
        documentationSidebar.sidebar,
        documentationSidebar.activeNode
      );
    }

    const documentationPagination = new DocumentationPagination(
      documentationSidebar.previousToggle,
      documentationSidebar.nextToggle
    );
  }

  onReady = () => {
    addClass(this.docs, 'docs-ready');
  }
}

module.exports = Documentation;
