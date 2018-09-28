import React, { PureComponent } from "react";
import PropTypes from "prop-types";

export default class RssPreview extends PureComponent {
  static displayName = "Contentment.Element.RssPreview";
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
    console.log(data);

    return (
      <div key="body" className="cm-preview default">
        <div className="body" style={typeStyles}>
          Displays RSS feed from  <a href={data.feed_url} target="_blank">
            {data.feed_url}
          </a>
        </div>
      </div>
    );
  }
}
