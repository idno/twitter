Twitter for Known
=================

This plugin provides <a title="Publish on your Own Site, Syndicate Elsewhere" href="http://indieweb.org/POSSE">POSSE</a> support for Known.

Installation
------------

* Drop the Twitter folder into the IdnoPlugins folder of your Known installation.
* You need to run ``composer install`` or ``composer update`` if you're updating in the Twitter folder so PHP Composer will download and install the dependencies. (see "Vendor" folder)
* Log into Known and click **Site Configuration**.
* On the **Site Features** tab, click **Enable** next to Twitter. A **Twitter**
  entry is added to the site configuration menu.
* Click **Twitter** in the site configuration menu. Set up your custom Twitter
  application, which will post tweets for your Known instance, and save the API
  key and API secret.

Once you have installed and configured the Twitter plugin, each user of your
Known instance will be able to set up Twitter syndication support using the
**Twitter** entry in the user settings menu.

License
-------

Released under the Apache 2.0 license: http://www.apache.org/licenses/LICENSE-2.0.html

Contains
--------

Also contains tmhOAuth, which is released under the Apache 2.0 license. Source: http://www.apache.org/licenses/LICENSE-2.0.html
