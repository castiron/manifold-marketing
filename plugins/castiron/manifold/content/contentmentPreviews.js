// Manually import all plugin previews

import AnimatedCallout from "./animatedcallout/Preview"
import MultiButtonCallout from "./multibuttoncallout/Preview"
import OneButtonHero from "./onebuttonhero/Preview";
import OneButtonCallout from "./onebuttoncallout/Preview";

const previews = {
  AnimatedCallout,
  'Multi-ButtonCallout': MultiButtonCallout,
  OneButtonHero,
  OneButtonCallout
};

// Add the previews to the plugin manager
Object.keys(previews).forEach(key => {
  window.pluginPreviewManger.add({ [key]: previews[key] });
});
