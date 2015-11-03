# tna-eventbrite-api

## WordPress plugin

### Shortcode

TNA Eventbrite API plugin allows you to list events in a post or page using the [tna-eventbrite] shortcode. When you're editing a page or post, directly insert the shortcode in your text. The basic usage would be something like this:

Default: \[tna-eventbrite\] (Displays 3 events from default orginiser)

Specifying orginiser ID: \[tna-eventbrite orginiser=224466123\]

Specifying number of events displayed: \[tna-eventbrite orginiser=224466123 numberevents=12\]

### Bugs

* When the shortcode is added twice to a page there is a js conflict and outputs nothing.
* Fixed: The js is relient on the correct file path and naming of the plugin's folder. Folder name should be 'tna-eventbrite-api'.
