YiiDisqusWidget
===============

This is sample widget wich can help you to add DISQUS
support in to your Yii site.

##Requirements

You must be registered on [DISQUS](http://disqus.com/)

##Installation

Copy `YiiDisqusWidget` folder in you `protected/extensions` folder.

##Usage

Just add this code on your page where you need to include DISQUS.
Simple usage:
```php
// DISQUS_SHORTNAME - You disqus_shortname from DISQUS.
$this->widget('ext.YiiDisqusWidget.YiiDisqusWidget',array('shortname'=>'DISQUS_SHORTNAME'));
```

You can change all off `disqus_` parameters in options array:
```javascript
var disqus_shortname;
var disqus_identifier;
var disqus_title;
var disqus_url;
```
Just add it in option array:
```php
$this->widget(
    'ext.YiiDisqusWidget.YiiDisqusWidget',
    array(
        'shortname' => 'DISQUS_SHORTNAME',
        'identifier' => 'DISQUS_IDENTIFIER',
        'title' => 'DISQUS_TITLE',
        'url' => 'DISQUS_URL',
        'category_id' => 'DISQUS_CATEGORY_ID',
    )
);
```
More information about DISQUS variables on [http://help.disqus.com/](http://help.disqus.com/customer/portal/articles/472098-javascript-configuration-variables#disqus_shortname)

##Resources

 * [GitHub](https://github.com/DexterHD/YiiDisqusWidget)
