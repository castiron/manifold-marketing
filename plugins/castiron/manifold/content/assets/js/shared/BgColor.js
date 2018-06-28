import React, { PureComponent } from "react";
import PropTypes from "prop-types";

export default class ContentmentPreviewSharedBgColor extends PureComponent {
  static displayName = "Contentment.Preview.Shared.BgColor";

  static propTypes = {
    color: PropTypes.string
  };

  render() {
    const bgMap = {
      white: '#ffffff',
      black: '#363636',
      gray: '#f7f7f7',
      primary: '#52e3ac',
      patterned: '#52e3ac',
      'patterned-dark': '#363636'
    };

    const color = this.props.color;

    return(
      <div
        className="bg-preview"
        style={{
          display: 'inline-block',
          width: '1em',
          height: '1em',
          verticalAlign: 'top',
          marginRight: '0.5em',
          backgroundColor: bgMap[color],
          border: color === 'white' ?
            '1px solid #d1d6d9' : 'none',
          borderRadius: '100%',
        }}
      >
      </div>
    );
  }
}
