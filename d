[1mdiff --git a/composer.json b/composer.json[m
[1mindex 4ab3743..cc906f2 100644[m
[1m--- a/composer.json[m
[1m+++ b/composer.json[m
[36m@@ -13,7 +13,6 @@[m
         "bin/heroku-php-nginx"[m
     ],[m
   "require": {[m
[31m-    "hashids/hashids": "1.0.5",[m
[31m-        "aws/aws-sdk-php": "~2.6"[m
[32m+[m[32m    "hashids/hashids": "1.0.5"[m
   }[m
[31m-}[m
[32m+[m[32m}[m
\ No newline at end of file[m
[1mdiff --git a/composer.lock b/composer.lock[m
[1mindex 1d05e1e..b503143 100644[m
[1m--- a/composer.lock[m
[1m+++ b/composer.lock[m
[36m@@ -4,167 +4,9 @@[m
         "Read more about it at https://getcomposer.org/doc/01-basic-usage.md#composer-lock-the-lock-file",[m
         "This file is @generated automatically"[m
     ],[m
[31m-    "hash": "f4f07e61664edfba456658f627bcb91a",[m
[32m+[m[32m    "hash": "27cb225a08c48042ec295f3e9fef8f5e",[m
     "packages": [[m
         {[m
[31m-            "name": "aws/aws-sdk-php",[m
[31m-            "version": "2.8.10",[m
[31m-            "source": {[m
[31m-                "type": "git",[m
[31m-                "url": "https://github.com/aws/aws-sdk-php.git",[m
[31m-                "reference": "2ee053239be2ad4cf020f3b5998f29b5302d82c9"[m
[31m-            },[m
[31m-            "dist": {[m
[31m-                "type": "zip",[m
[31m-                "url": "https://api.github.com/repos/aws/aws-sdk-php/zipball/2ee053239be2ad4cf020f3b5998f29b5302d82c9",[m
[31m-                "reference": "2ee053239be2ad4cf020f3b5998f29b5302d82c9",[m
[31m-                "shasum": ""[m
[31m-            },[m
[31m-            "require": {[m
[31m-                "guzzle/guzzle": "~3.7",[m
[31m-                "php": ">=5.3.3"[m
[31m-            },[m
[31m-            "require-dev": {[m
[31m-                "doctrine/cache": "~1.0",[m
[31m-                "ext-openssl": "*",[m
[31m-                "monolog/monolog": "~1.4",[m
[31m-                "phpunit/phpunit": "~4.0",[m
[31m-                "phpunit/phpunit-mock-objects": "2.3.1",[m
[31m-                "symfony/yaml": "~2.1"[m
[31m-            },[m
[31m-            "suggest": {[m
[31m-                "doctrine/cache": "Adds support for caching of credentials and responses",[m
[31m-                "ext-apc": "Allows service description opcode caching, request and response caching, and credentials caching",[m
[31m-                "ext-openssl": "Allows working with CloudFront private distributions and verifying received SNS messages",[m
[31m-                "monolog/monolog": "Adds support for logging HTTP requests and responses",[m
[31m-                "symfony/yaml": "Eases the ability to write manifests for creating jobs in AWS Import/Export"[m
[31m-            },[m
[31m-            "type": "library",[m
[31m-            "autoload": {[m
[31m-                "psr-0": {[m
[31m-                    "Aws": "src/"[m
[31m-                }[m
[31m-            },[m
[31m-            "notification-url": "https://packagist.org/downloads/",[m
[31m-            "license": [[m
[31m-                "Apache-2.0"[m
[31m-            ],[m
[31m-            "authors": [[m
[31m-                {[m
[31m-                    "name": "Amazon Web Services",[m
[31m-                    "homepage": "http://aws.amazon.com"[m
[31m-                }[m
[31m-            ],[m
[31m-            "description": "AWS SDK for PHP - Use Amazon Web Services in your PHP project",[m
[31m-            "homepage": "http://aws.amazon.com/sdkforphp",[m
[31m-            "keywords": [[m
[31m-                "amazon",[m
[31m-                "aws",[m
[31m-                "cloud",[m
[31m-                "dynamodb",[m
[31m-                "ec2",[m
[31m-                "glacier",[m
[31m-                "s3",[m
[31m-                "sdk"[m
[31m-            ],[m
[31m-            "time": "2015-06-11 23:48:44"[m
[31m-        },[m
[31m-        {[m
[31m-            "name": "guzzle/guzzle",[m
[31m-            "version": "v3.9.3",[m
[31m-            "source": {[m
[31m-                "type": "git",[m
[31m-                "url": "https://github.com/guzzle/guzzle3.git",[m
[31m-                "reference": "0645b70d953bc1c067bbc8d5bc53194706b628d9"[m
[31m-            },[m
[31m-            "dist": {[m
[31m-                "type": "zip",[m
[31m-                "url": "https://api.github.com/repos/guzzle/guzzle3/zipball/0645b70d953bc1c067bbc8d5bc53194706b628d9",[m
[31m-                "reference": "0645b70d953bc1c067bbc8d5bc53194706b628d9",[m
[31m-                "shasum": ""[m
[31m-            },[m
[31m-            "require": {[m
[31m-                "ext-curl": "*",[m
[31m-                "php": ">=5.3.3",[m
[31m-                "symfony/event-dispatcher": "~2.1"[m
[31m-            },[m
[31m-            "replace": {[m
[31m-                "guzzle/batch": "self.version",[m
[31m-                "guzzle/cache": "self.version",[m
[31m-                "guzzle/common": "self.version",[m
[31m-                "guzzle/http": "self.version",[m
[31m-                "guzzle/inflection": "self.version",[m
[31m-                "guzzle/iterator": "self.version",[m
[31m-                "guzzle/log": "self.version",[m
[31m-                "guzzle/parser": "self.version",[m
[31m-                "guzzle/plugin": "self.version",[m
[31m-                "guzzle/plugin-async": "self.version",[m
[31m-                "guzzle/plugin-backoff": "self.version",[m
[31m-                "guzzle/plugin-cache": "self.version",[m
[31m-                "guzzle/plugin-cookie": "self.version",[m
[31m-                "guzzle/plugin-curlauth": "self.version",[m
[31m-                "guzzle/plugin-error-response": "self.version",[m
[31m-                "guzzle/plugin-history": "self.version",[m
[31m-                "guzzle/plugin-log": "self.version",[m
[31m-                "guzzle/plugin-md5": "self.version",[m
[31m-                "guzzle/plugin-mock": "self.version",[m
[31m-                "guzzle/plugin-oauth": "self.version",[m
[31m-                "guzzle/service": "self.version",[m
[31m-                "guzzle/stream": "self.version"[m
[31m-            },[m
[31m-            "require-dev": {[m
[31m-                "doctrine/cache": "~1.3",[m
[31m-                "monolog/monolog": "~1.0",[m
[31m-                "phpunit/phpunit": "3.7.*",[m
[31m-                "psr/log": "~1.0",[m
[31m-                "symfony/class-loader": "~2.1",[m
[31m-                "zendframework/zend-cache": "2.*,<2.3",[m
[31m-                "zendframework/zend-log": "2.*,<2.3"[m
[31m-            },[m
[31m-            "suggest": {[m
[31m-                "guzzlehttp/guzzle": "Guzzle 5 has moved to a new package name. The package you have installed, Guzzle 3, is deprecated."[m
[31m-            },[m
[31m-            "type": "library",[m
[31m-            "extra": {[m
[31m-                "branch-alias": {[m
[31m-                    "dev-master": "3.9-dev"[m
[31m-                }[m
[31m-            },[m
[31m-            "autoload": {[m
[31m-                "psr-0": {[m
[31m-                    "Guzzle": "src/",[m
[31m-                    "Guzzle\\Tests": "tests/"[m
[31m-                }[m
[31m-            },[m
[31m-            "notification-url": "https://packagist.org/downloads/",[m
[31m-            "license": [[m
[31m-                "MIT"[m
[31m-            ],[m
[31m-            "authors": [[m
[31m-                {[m
[31m-                    "name": "Michael Dowling",[m
[31m-                    "email": "mtdowling@gmail.com",[m
[31m-                    "homepage": "https://github.com/mtdowling"[m
[31m-                },[m
[31m-                {[m
[31m-                    "name": "Guzzle Community",[m
[31m-                    "homepage": "https://github.com/guzzle/guzzle/contributors"[m
[31m-                }[m
[31m-            ],[m
[31m-            "description": "PHP HTTP client. This library is deprecated in favor of https://packagist.org/packages/guzzlehttp/guzzle",[m
[31m-            "homepage": "http://guzzlephp.org/",[m
[31m-            "keywords": [[m
[31m-                "client",[m
[31m-                "curl",[m
[31m-                "framework",[m
[31m-                "http",[m
[31m-                "http client",[m
[31m-                "rest",[m
[31m-                "web service"[m
[31m-            ],[m
[31m-            "time": "2015-03-18 18:23:50"[m
[31m-        },[m
[31m-        {[m
             "name": "hashids/hashids",[m
             "version": "1.0.5",[m
             "source": {[m
[36m@@ -220,64 +62,6 @@[m
                 "youtube"[m
             ],[m
             "time": "2015-01-21 00:49:41"[m
[31m-        },[m
[31m-        {[m
[31m-            "name": "symfony/event-dispatcher",[m
[31m-            "version": "v2.7.1",[m
[31m-            "source": {[m
[31m-                "type": "git",[m
[31m-                "url": "https://github.com/symfony/EventDispatcher.git",[m
[31m-                "reference": "be3c5ff8d503c46768aeb78ce6333051aa6f26d9"[m
[31m-            },[m
[31m-            "dist": {[m
[31m-                "type": "zip",[m
[31m-                "url": "https://api.github.com/repos/symfony/EventDispatcher/zipball/be3c5ff8d503c46768aeb78ce6333051aa6f26d9",[m
[31m-                "reference": "be3c5ff8d503c46768aeb78ce6333051aa6f26d9",[m
[31m-                "shasum": ""[m
[31m-            },[m
[31m-            "require": {[m
[31m-                "php": ">=5.3.9"[m
[31m-            },[m
[31m-            "require-dev": {[m
[31m-                "psr/log": "~1.0",[m
[31m-                "symfony/config": "~2.0,>=2.0.5",[m
[31m-                "symfony/dependency-injection": "~2.6",[m
[31m-                "symfony/expression-language": "~2.6",[m
[31m-                "symfony/phpunit-bridge": "~2.7",[m
[31m-                "symfony/stopwatch": "~2.3"[m
[31m-            },[m
[31m-            "suggest": {[m
[31m-                "symfony/dependency-injection": "",[m
[31m-                "symfony/http-kernel": ""[m
[31m-            },[m
[31m-            "type": "library",[m
[31m-            "extra": {[m
[31m-                "branch-alias": {[m
[31m-                    "dev-master": "2.7-dev"[m
[31m-                }[m
[31m-            },[m
[31m-            "autoload": {[m
[31m-                "psr-4": {[m
[31m-                    "Symfony\\Component\\EventDispatcher\\": ""[m
[31m-                }[m
[31m-            },[m
[31m-            "notification-url": "https://packagist.org/downloads/",[m
[31m-            "license": [[m
[31m-                "MIT"[m
[31m-            ],[m
[31m-            "authors": [[m
[31m-                {[m
[31m-                    "name": "Fabien Potencier",[m
[31m-                    "email": "fabien@symfony.com"[m
[31m-                },[m
[31m-                {[m
[31m-                    "name": "Symfony Community",[m
[31m-                    "homepage": "https://symfony.com/contributors"[m
[31m-                }[m
[31m-            ],[m
[31m-            "description": "Symfony EventDispatcher Component",[m
[31m-            "homepage": "https://symfony.com",[m
[31m-            "time": "2015-06-08 09:37:21"[m
         }[m
     ],[m
     "packages-dev": [],[m
[1mdiff --git a/index.php b/index.php[m
[1mindex 6c9b87b..cb604b3 100644[m
[1m--- a/index.php[m
[1m+++ b/index.php[m
[36m@@ -7,14 +7,9 @@[m
  */[m
 [m
     // require autoload / composer[m
[31m-    require 'model/core.php';[m
     require 'vendor/autoload.php';[m
 [m
     // test HashID[m
     $hashids = new Hashids\Hashids('SuperSaltQuotrs.LOL', 7);[m
     $id = $hashids->encode(1);[m
[31m-    echo $id;[m
[31m-    echo "<br/>";[m
[31m-    echo DBNAME;[m
[31m-    echo "<br/>";[m
[31m-    echo $_SERVER["DOCUMENT_ROOT"];[m
\ No newline at end of file[m
[32m+[m[32m    echo $id;[m
\ No newline at end of file[m
[1mdiff --git a/model/core.php b/model/core.php[m
[1mindex 3d73479..8e61edd 100644[m
[1m--- a/model/core.php[m
[1m+++ b/model/core.php[m
[36m@@ -12,12 +12,14 @@[m [mDEFINE('RATIO_POP_MULTIPLI', 0.99519804434435373165003884241728);[m
 [m
 // connexion db[m
 if($_SERVER["REMOTE_ADDR"] != "127.0.0.1"){[m
[31m-	// on heroku[m
[31m-    $urlClearDB = parse_url(getenv("CLEARDB_DATABASE_URL"));[m
[31m-	DEFINE('HOSTNAME', $urlClearDB["host"]);[m
[31m-	DEFINE('DBNAME', substr($urlClearDB["path"], 1));[m
[31m-	DEFINE('USER_DB', $urlClearDB["user"]);[m
[31m-	DEFINE('PASS_DB',$urlClearDB["pass"]);[m
[32m+[m	[32m// online[m
[32m+[m	[32mDEFINE('PREFIX_URL_RELATIF', '');[m
[32m+[m	[32mDEFINE('DOMAINE_COOKIE', 'quotrs.fr');[m
[32m+[m	[32mDEFINE('PROJECT_FOLDER', "");[m
[32m+[m	[32mDEFINE('HOSTNAME', 'db531335009.db.1and1.com');[m
[32m+[m	[32mDEFINE('DBNAME', 'db531335009');[m
[32m+[m	[32mDEFINE('USER_DB', 'dbo531335009');[m
[32m+[m	[32mDEFINE('PASS_DB','PhEP8("QVX@=dM+');[m
 	DEFINE('ROOT', '/kunden/homepages/45/d399347765/htdocs/quotrs/');[m
 }else{[m
 	// local[m
[36m@@ -25,15 +27,30 @@[m [mif($_SERVER["REMOTE_ADDR"] != "127.0.0.1"){[m
 	if($root[strlen($root)-1] == "/"){[m
 		$root = substr($root, 0, strlen($root)-1);[m
 	}[m
[32m+[m	[32mDEFINE('DOMAINE_COOKIE', null);[m
[32m+[m	[32mDEFINE('DOMAINE_COOKIE_JOHTO', null);[m
 	DEFINE('ROOT', $root);[m
[31m-	DEFINE('PROJECT_FOLDER', "/quotrs");[m
[32m+[m	[32mDEFINE('PROJECT_FOLDER', "/rap-site");[m
 	DEFINE('HOSTNAME', 'localhost');[m
 	DEFINE('DBNAME', 'db_quotrap');[m
 	DEFINE('USER_DB', 'root');[m
 	DEFINE('PASS_DB','');[m
[32m+[m	[32mDEFINE('STATIC_URL', '');[m
[32m+[m	[32mDEFINE('PREFIX_URL_RELATIF', '.');[m
 }[m
 DEFINE('WEBROOT', ROOT.PROJECT_FOLDER);[m
[31m-//DEFINE('FOLDER_IMGS', STATIC_URL.'/img');[m
[31m-//DEFINE('FOLDER_COVER_ALBUMS', FOLDER_IMGS.'/albums');[m
[32m+[m[32mDEFINE('FOLDER_IMGS', STATIC_URL.'/img');[m
[32m+[m[32mDEFINE('FOLDER_COVER_ALBUMS', FOLDER_IMGS.'/albums');[m
 [m
[31m-?>[m
[32m+[m[32m// mailChimp[m
[32m+[m[32mDEFINE('MC_API_KEY', '30a308783a9b275034918218453a741a-us7');[m
[32m+[m[32mDEFINE('MC_IDLIST_NEWSLETTER', 'c7700bbae7');[m
[32m+[m
[32m+[m[32m$arrayWordsExplain = Array("Intéressant, dis-m'en plus !", "Continuez Jackson, vous m'intéressez !", "Continuez Jackson, vous m'intéressez !");[m
[32m+[m
[32m+[m
[32m+[m[32m$arrayCorrespondLang = Array("fr_FR" => "Français", "en_US" => "English");[m
[32m+[m[32m$arrayCorrespondTranslateText = Array("fr_FR" => "Traduire en", "en_US" => "Translate to");[m
[32m+[m
[32m+[m[32m$availableLangs = Array("fr_FR", "en_US");[m
[32m+[m[32m?>[m
\ No newline at end of file[m
warning: LF will be replaced by CRLF in composer.lock.
The file will have its original line endings in your working directory.
