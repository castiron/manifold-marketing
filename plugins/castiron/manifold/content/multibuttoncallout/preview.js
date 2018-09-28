import React, { PureComponent } from "react";
import PropTypes from "prop-types";

export default class MultiButtonCalloutPreview extends PureComponent {
  static displayName = "Contentment.Element.MultiButtonCalloutPreview";
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
        </div>
        <div className="body" style={typeStyles}>
          <div className="truncate">
            <div
              className="cm-rte-content"
              dangerouslySetInnerHTML={{__html: data.subtitle}}
            />
          </div>
        </div>
        {data.buttons.map((button) => {
          return (
            <div className="body" key={button.button_link} style={typeStyles}>
              <div className="truncate">
                <u>{button.button_text}</u> [{button.button_link}]
                <p>{button.button_description}</p>
              </div>
            </div>
          );
        })}
      </div>
    );
  }
}
