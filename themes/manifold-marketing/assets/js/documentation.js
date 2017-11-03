import { addClass } from "./lib/dom-help.js";
import DocumentationSidebar from "./docs-sidebar";
import DocumentationBreadcrumb from "./docs-breadcrumb";
import DocumentationPagination from "./docs-pagination";

class Documentation {
  constructor(docs) {
    const documentationSidebar = new DocumentationSidebar();

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

    addClass(docs, 'docs-ready');
  }
}

module.exports = Documentation;
