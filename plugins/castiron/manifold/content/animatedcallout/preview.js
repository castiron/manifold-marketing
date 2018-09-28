import React, { PureComponent } from "react";
import PropTypes from "prop-types";

export default class AnimatedCalloutPreview extends PureComponent {
  static displayName = "Contentment.Element.AnimatedCalloutPreview";
  static propTypes = {
    element: PropTypes.object,
    type: PropTypes.object,
    types: PropTypes.object,
    content: PropTypes.array,
  };

  render() {
    const { element } = this.props;
    const { data } = element;
    if (!data) return null;

    const titleStyles = {
      fontSize: 18
    };
    const typeStyles = {
      marginTop: 10,
      marginBottom: 10
    };

    return (
      <div key="body" className="cm-preview default">
        <div className="body" style={titleStyles}>
          <strong>{data.title}</strong>
          {data.subtitle ?
            <span><br />{data.subtitle}</span>
            : null
          }
        </div>
        <div className="body" style={typeStyles}>
          <div className="truncate">
            <div
              className="cm-rte-content"
              dangerouslySetInnerHTML={{__html: data.description}}
            />
          </div>
        </div>
        <div className="body" style={typeStyles}>
          <strong>Animation:</strong> {data.animation}
        </div>
      </div>
    );
  }
}
