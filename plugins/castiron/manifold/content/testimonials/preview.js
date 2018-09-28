import React, { PureComponent } from "react";
import PropTypes from "prop-types";

export default class TestimonialsPreview extends PureComponent {
  static displayName = "Contentment.Element.TestimonialsPreview";
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
      fontSize: 14
    };
    const typeStyles = {
      marginTop: 10,
      marginBottom: 10
    };
    console.log(data);

    return (
      <div key="body" className="cm-preview default">
        <div className="body" style={titleStyles}>
          <strong>{data.title}</strong>
        </div>
        {data.testimonials.map((testimonial) => {
          return (
            <div className="body" style={typeStyles}>
              {testimonial.author}:
              <div className="truncate">
                <div
                  className="cm-rte-content"
                  dangerouslySetInnerHTML={{__html: testimonial.quotation}}
                />
              </div>
            </div>
          );
        })}
      </div>
    );
  }
}
