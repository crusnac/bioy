# Bible In One Year Wordpress Plugin
BIOY is a simple multi-language Wordpress Plugin that displays a daily reading plan for the current month.  

### Installing the BIOY plugin

- Download the source code zip file
- Upload the entire contnets of into your `wp-contents/plugins/` folder on your website.
- Active the `bioy` plugin

# Usage

`[bioy lang='en' translation='esv' col='3' locale='en_US' display_current_month='yes']`

### Optional Parameters

- `translation` is used to specify which translation you would like to be displayed.  See https://www.biblegateway.com/versions/ for available translation
- `col` is used to specify how many columns are displayed. If not specified, the default is `3` columns. 
- `locale` is used to display the date in the proper language. If not specified, the default is based on your hosting provider. 
- `display_current_month` is used to toggle whether to display the current Month/Year.  If not specified, the default is `yes`

# Adding a New language
This plugin can easily be extended to other languages by simply creating a new bioy_**language**.xml file. See the following instructions on how to add a new language:

- Copy an existing xml file (located in the plugin bioy/xml directory)
- Rename the xml file to the language code that the file has been translated to
- Translate the XML content, specifically the books of the bible (https://www.biblegateway.com/versions/New-King-James-Version-NKJV-Bible/#booklist)
- Reference the new language in the shortcode

# Copyright
Bible Gateway (biblegateway.com) is a searchable online Bible in more than 200 versions and 70 languages that you can freely read, research, and reference anywhere. 
