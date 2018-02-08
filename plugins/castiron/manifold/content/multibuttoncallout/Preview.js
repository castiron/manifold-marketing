import React, { PureComponent } from "react";
import PropTypes from "prop-types";
import { get } from 'lodash';

export default class ContentmentPreviewOneButtonHero extends PureComponent {
  static displayName = "Contentment.Preview.OneButtonHero";

  static propTypes = {
    element: PropTypes.object,
    type: PropTypes.object,
    prompt: PropTypes.func,
  };

  renderButtons(buttons) {
    return(
      <div>
        <span
          style={{fontWeight: 'bold'}}
        >
          {'Buttons:'}
        </span>
        <ul
          style={{
            display: 'inline',
            listStyleType: 'none',
            padding: '0 0 0 0.8em',
          }}
        >
          {buttons.map((button, index) => {
            return(
              <li
                key={button.button_text}
                style={{
                  display: 'inline-block',
                  marginRight: '0.3em'
                }}
              >
                <a
                  href={button.button_link}
                  target="_blank"
                >
                  {button.button_text}
                </a>
                {index < buttons.length - 1 ? ',' : ''}
              </li>
            )
          })}
        </ul>
      </div>
    )
  }

  renderContent(data) {
    return(
      <div className="cm-rte-content">
        { data.title ?
          <header>
            <h3>{data.title}</h3>
          </header> : null
        }
        { data.subtitle ?
          <div className="truncate">
            <div
              dangerouslySetInnerHTML={{__html: data.subtitle}}
            >
            </div>
          </div> : null
        }
        { data.buttons ?
          this.renderButtons(data.buttons) : null
        }
      </div>
    );
  }

  render() {
    const { element, type } = this.props;
    const Prompt = this.props.prompt;

    const data = {
      title: get(element.data, 'title'),
      background: get(element.data, 'background'),
      subtitle: get(element.data, 'subtitle'),
      buttons: get(element.data, 'buttons')
    };

    const hasData = data.title || data.subtitle || data.buttons;

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
