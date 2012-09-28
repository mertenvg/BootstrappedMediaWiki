Installation
============

### Step 1:

Download and extract the zip of this repository to your media wiki {wiki-document-root}/skins directory

 \- OR -

Since cloning into non-empty directories is not permitted by Git the following set of commands can be used to achieve the same result;

```bash
$ cd {wiki-document-root}/skins
$ git init
$ git remote add origin git://github.com/mertenvg/BootstrappedMediaWiki.git
$ git pull origin master
```

### Step 2:

Update your LocalSettings.php MediaWiki configuration file to use Bootstrapped as the default skin

```php
// LocalSettings.php
$wgDefaultSkin = "bootstrapped";
```

Disclaimer
==========

This project has been tested on MediaWiki v1.18.2 with PHP v5.3.10 and to my knowledge contains no malicious code intended to harm you, your data, or your pets. Use of this project is, however, at your own risk.

License
=======

[MediaWiki](http://www.mediawiki.org/wiki/MediaWiki) adopts the [GNU General Public License v2+](http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)

and 

[Twitter Bootstrap](http://twitter.github.com/bootstrap/) adopts the [Apache License, Version 2.0](http://www.apache.org/licenses/LICENSE-2.0)

so as long as you stick to these we shouldn't have any beefs.
