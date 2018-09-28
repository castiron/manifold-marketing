import React, { PureComponent } from "react";
import PropTypes from "prop-types";
import { get } from 'lodash';

export default class VideoHeroPreview extends PureComponent {
  static displayName = "Contentment.Element.VideoPreview";
  static propTypes = {
    element: PropTypes.object,
    type: PropTypes.object,
    types: PropTypes.object,
    content: PropTypes.array,
  };

  render() {
    const { element } = this.props;
    const { data } = element;
    const titleStyles = {
      fontSize: 18
    };
    const typeStyles = {
      marginTop: 10,
      marginBottom: 10
    };

    return (
      <div key="body" className="cm-preview default">
        <div className="heading-preview" style={titleStyles}>
          <strong>{data.title}</strong>
        </div>
        <div className="body" style={typeStyles}>
          {data.subtitle}
        </div>
      </div>
    );
  }
}
