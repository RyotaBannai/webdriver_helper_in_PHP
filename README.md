# webdriver_helper_in_PHP
This is the HELPER of Webdriver in PHP.
You often have a large amount of codes and long letter functions for using 
 Webdriver classes, WebdriverBy, WebdriverRemote, or WebDriverExpectedCondition, ect many times.
This helper makes that enomously simple, and you to compose quickly more than ever!!
How do we use this? Superingly easy to use!!
The mainly improverd tools are both Item-Clicking and Form-Filling 
althogh several functions are included in this HELPER.
You can code just only a line to compose a findElement func,
complicated relationship flow and order of performing code using "wait" or "ExpectedCondition",
and any form and click items.

I show some example in following.

```ruby:example.php
$clickitems = 
            array(
            array('Xpath','//label'),
            array('Xpath','//div/div/select/option[4]'),
            );
$fillitems = 
            array(
            array('Xpath','//li/input', 'temp_fillitem'),
            array('Xpath','//li[2]/input', 'temp_fillitem'),
            );
self::cast_a_spell($fillitems, $clickitems);
```
Everything you make action is defined first in *$clickitems* and *$fillitems* literally.
And finally you must cast a spell like above "cast_a_spell" func!!!

wd_helper.php is trait file and so since you use this usefulness, include this file and then define *use common_funcs;*
in your editing class.

 
