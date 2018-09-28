import CastironManifoldContentVideoHero from "./videohero/preview.js";
import CastironManifoldContentAnnouncement from "./announcement/preview.js";
import CastironManifoldContentOneButtonCallout from
  "./onebuttoncallout/preview.js";
import CastironManifoldContentAnimatedCallout from
  "./animatedcallout/preview.js";
import CastironManifoldContentActionsListing from "./actionslisting/preview.js";
import CastironManifoldContentMultiButtonCallout from
  "./multibuttoncallout/preview.js";
import CastironManifoldContentServicePackageGroup from
  "./servicepackagegroup/preview.js";
import CastironManifoldContentParallaxCallout from
  "./parallaxcallout/preview.js";
import CastironManifoldContentRss from "./rss/preview.js";
import CastironManifoldContentFeaturedProjectHero from
  "./featuredprojecthero/preview.js";
import CastironManifoldContentTestimonials from "./testimonials/preview.js";
import CastironManifoldContentOneButtonHero from "./onebuttonhero/preview.js";
import CastironManifoldContentServicePackage from "./servicepackage/preview.js";

const previews = {
  CastironManifoldContentVideoHero,
  CastironManifoldContentAnnouncement,
  CastironManifoldContentOneButtonCallout,
  CastironManifoldContentAnimatedCallout,
  CastironManifoldContentActionsListing,
  CastironManifoldContentMultiButtonCallout,
  CastironManifoldContentServicePackageGroup,
  CastironManifoldContentServicePackage,
  CastironManifoldContentParallaxCallout,
  CastironManifoldContentRss,
  CastironManifoldContentFeaturedProjectHero,
  CastironManifoldContentTestimonials,
  CastironManifoldContentOneButtonHero
};

// Add the previews to the plugin manager
Object.keys(previews).forEach(key => {
  window.pluginPreviewManger.add({ [key]: previews[key] });
});
