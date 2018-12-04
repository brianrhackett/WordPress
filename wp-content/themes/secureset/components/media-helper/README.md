# Media Helper

## Requirements

1. Fancybox

## Description

This media helper component is primarily used as a cloned component for other components. It is designed 
to be used as a consistent way to display user generated media in a fluid container. When you clone this 
component into another component user will be able to select from the following media types:

1. Image
1. Video Link
1. Video File ( HTML5 video )

Fancybox is used to display the Video Link as an iFrame and programatically determines aspect ratio of
Fancybox. If a poster image is omitted, the component will use the largest size thumbnail it can find 
from the Youtube or Vimeo API.

See the example-component on how to clone it into ACF and use 
`get_component( 'media-helper', $fields['media_helper'] )` to display the block on the front end.
