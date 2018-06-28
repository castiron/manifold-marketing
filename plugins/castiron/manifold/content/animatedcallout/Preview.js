import React, { PureComponent } from "react";
import PropTypes from "prop-types";
import { get } from 'lodash';

import BgColor from '../assets/js/shared/BgColor';

export default class ContentmentPreviewOneButtonHero extends PureComponent {
  static displayName = "Contentment.Preview.OneButtonHero";

  static propTypes = {
    element: PropTypes.object,
    type: PropTypes.object,
    prompt: PropTypes.func,
  };

  renderContent(data) {
    const animationMaps = {
      'book': 'Bookpile',
      'discussion': 'Book Discussion'
    }

    return(
      <div className="cm-rte-content">
        { data.title ?
          <header>
            <h3>
              {data.title}
            </h3>
          </header> : null
        }
        { data.description ?
          <div className="truncate">
            <div
              dangerouslySetInnerHTML={{__html: data.description}}
            >
            </div>
          </div> : null
        }
        { data.animation ?
          <ul className="key-value">
            <li>
              <span
                className="key"
              >
                {'Animation: '}
              </span>
              {animationMaps[data.animation]}
            </li>
          </ul> : null
        }
      </div>
    );
  }

  render() {
    const { element, type } = this.props;
    const Prompt = this.props.prompt;

    const data = {
      title: get(element.data, 'title'),
      description: get(element.data, 'description'),
      animation: get(element.data, 'animation'),
    };

    const hasData = data.title || data.description;

    return(
      type.hasFields ?
        <div key="body" className="cm-preview default">
          {hasData ?
            this.renderContent(data) :
            <Prompt
              element={element}
            ></Prompt>
          }
        </div> : null
    );
  }
}
