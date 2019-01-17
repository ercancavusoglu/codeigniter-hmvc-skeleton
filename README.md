CodeIgniter Skeleton
====================

CodeIgniter Skeleton (CIS) is not only a decent starting point for most web apps but also a new experience for CI-based development to ajaxify everything.

### Application

```
config/
    assets.php                      // Config base URL for assets
core/
    MY_Controller.php               // MY_Controller & Ajax_Controller
helper/
    MY_url_helper.php               // Contain assets_url() function
library/
    Dialog.php                      // Generate HTML for Bootstrap's Modal dialog
    Response.php                    // Handle response for ajax request
    Template.php                    // Handle masterview and views within masterview
modules/
    addons/                         // Add-ons management
    skeleton/                       // Showcase of all included components
third_party/
    MX/                             // Modular Extensions - HMVC
views/
    layout/
        default.php                 // Header + full width container
        pagelet.php                 // Header + half width container
    base_view.php                   // Masterview
    dialog.php                      // HTML template for Bootstrap's Modal dialog
    header.php                      // Page header
```

## License

Copyright An Vo [@an_voz](https://twitter.com/an_voz), 2013-2014.

Using and changing at core from Ercan Cavusoglu [@devredisibirak](https://twitter.com/devredisibirak), 2018.

[CodeIgniter License Agreement](http://ellislab.com/codeigniter/user-guide/license.html), everything else is released under the [MIT License](http://opensource.org/licenses/MIT).
