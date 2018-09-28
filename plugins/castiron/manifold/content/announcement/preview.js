import React, { PureComponent } from "react";
import PropTypes from "prop-types";

export default class AnnouncementPreview extends PureComponent {
  static displayName = "Contentment.Element.AnnouncementPreview";
  static propTypes = {
    element: PropTypes.object,
    type: PropTypes.object,
    types: PropTypes.object,
    content: PropTypes.array,
  };

  render() {
    const titleStyles = {
      fontSize: 18
    };
    const typeStyles = {
      marginTop: 10,
      marginBottom: 10
    };

    return (
      <div key="body" className="cm-preview default">
        <div className="body" style={typeStyles}>
          The content element renders the most recent news article.
        </div>
      </div>
    );
  }
}
