Wordpress Plugin

Create a Wordpress Plugin that abides by PHP PSR-2 coding standard.
Plugin must have the following functionalities:

###SHORTCODES GENERATION

One of the functionalities will be generating shortcodes from the array configuration.

An example of shortcode configuration (one item from the array):
```
$shortCode = [
    'name' => string,
    'content' => bool // defines will the shortcode have content and a close tag
    'action' => function ($atts, $content, $tag) {   // closure
    }
];
```

PHP Class has to read the configuration and from it, generate/add the shortcodes.

Put minimally one shortcode example into the configuration that will generate <video>, <audio> and/or any other HTML5
tag.

###WIDGET

Plugin has to generate a widget that will show a simple HTML5+JS calculator in the template sidebar area.
Widget must adhere to the MVC principles.

Calculator

    - must have basic mathematical operations (addition, subtraction, multiplication
      and division),
    - must have a display part of the input
    - buttons for input: numbers 0-9, simbols of mathematical operations, „=“ button
      for result and a „C“ button for resetting/deleting the state
    - must adhere HTML5 syntax and javascript must be object-oriented
    - can not use jQuery or any similar library
    - can use Twitter Bootstrap or some other CSS framework
    - can have arbitrary design (Design is not critical)
