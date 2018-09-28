import React, { PureComponent } from "react";
import PropTypes from "prop-types";

export default class ServicePackageGroupPreview extends PureComponent {
  static displayName = "Contentment.Element.ServicePackageGroupPreview";
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
        <div className="heading-preview" style={titleStyles}>
          <strong>{data.title}</strong>
        </div>
      </div>
    );
  }
}
