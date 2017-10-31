import DocumentationSidebar from "./docs-sidebar";
import DocumentationBreadcrumb from "./docs-breadcrumb";
import DocumentationPagination from "./docs-pagination";

class Documentation {
  constructor() {
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
  }
}

module.exports = Documentation;
