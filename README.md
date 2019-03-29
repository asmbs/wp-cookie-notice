## As of March 9, 2019, this project has been abandoned. Please use another package such as [Cookie Notice for GDPR by dFactory](https://wordpress.org/plugins/cookie-notice/).

# WP Cookie Notice

This is a Wordpress plugin that adds a cookie notice. The notice is shown on every page until the user clicks the "Accept" button. This plugin uses implicit consent, meaning that it does not prevent any use of cookies before the user accepts. The notice message and the color scheme can be changed in the settings page, and further customization can be accomplished in your theme with the use of the `wpcn` classes.



## Installation

### Requirements

- [Wordpress](https://wordpress.org/)

*Note that this plugin has only been tested on [Bedrock](https://roots.io/bedrock/)-based Wordpress installations running Wordpress v4.9.6.*

### Tips

- If you're using a Composer-based Wordpress project, simply run the following command in the project root: `composer require asmbs/wp-cookie-notice`
- If you're using a traditional Wordpress project, simply copy these files to a folder named `wp-cookie-notice` in your project's `plugins` folder.
- By default, this plugin uses a canned message and a gray color scheme. To change this, go to your Wordpress administrator dashboard, click "Settings" in the sidebar menu, and then click the "Cookie Notice" menu item that appears.



## Development

### Requirements

- [Wordpress](https://wordpress.org/)
- [NPM](https://www.npmjs.com/)

*Note that this plugin has only been tested on [Bedrock](https://roots.io/bedrock/)-based Wordpress installations running Wordpress v4.9.6 and NPM v6.0.1.*

### Getting Started

1. Run `npm install` from the plugin's root directory. This installs the development dependencies.
2. When you make changes, run `npm run-script build` to build the assets once, or run `npm run-script start` to keep a watcher going.