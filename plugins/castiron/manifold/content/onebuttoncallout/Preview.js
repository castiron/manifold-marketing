import React, { PureComponent } from "react";
import PropTypes from "prop-types";
import { get } from 'lodash';

import BgColor from '../assets/js/shared/BgColor';

export default class ContentmentPreviewDefault extends PureComponent {
  static displayName = "Contentment.Preview.Default";

  static propTypes = {
    element: PropTypes.object,
    type: PropTypes.object,
    prompt: PropTypes.func,
  };

  renderContent(data) {
    return(
      <div className="cm-rte-content">
        { data.title ?
          <header>
            { data.image ?
              <figure
                className="image"
                style={{marginBottom: '12px'}}
              >
                <img
                  src={`/storage/app/media${data.image}`}
                />
              </figure> : null
            }
            <h3>
              { data.background ?
                <BgColor
                  color={data.background}
                >
                </BgColor> : null }
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
        { data.buttonLink ?
          <a
            href={data.buttonLink}
            target="_blank"
            className="button"
          >
            { data.buttonText ? data.buttonText : 'No Button Text Set' }
          </a> : null
        }
      </div>
    );
  }

  render() {
    const { element, type } = this.props;
    const Prompt = this.props.prompt;

    const data = {
      title: get(element.data, 'title'),
      image: get(element.data, 'image'),
      background: get(element.data, 'background'),
      description: get(element.data, 'description'),
      buttonLink: get(element.data, 'button_link'),
      buttonText: get(element.data, 'button_text')
    };

    const hasData = data.title || data.description || data.buttonLink;

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
