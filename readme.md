


# Introduction

The PHP function [imagettftext()](https://www.php.net/manual/en/function.imagettftext.php) is  used to write text to an image using TrueType fonts. 
It's usage is not exatcly straight foward, depending a lot on factors such as the PHP Installation, [PHP GD Library](https://www.php.net/manual/en/book.image.php) and it's relation with the Operating System, often otputing the following message:

```
Warning: imagettftext() [function.imagettftext]: Could not find/open font
```

There's a lot of discussion over the internet with equally abundant mixed results regarding the implementation of this specific function. My own experience with the function was frustrating to say the least. And since, researching the topic did not yield a full working example for my setup, here is my humble contribution:

_Note: The [index.php](index.php) contains a working example that creates watermarked file at the output directory, you can skip directly to that file_


## On Windows 


One possible solution is to set, the font file path as one of the installed fonts of the OS.

```php
$font = c:/windows/fonts/arial.ttf
imagettftext($image_png, $fontsize, $angle, $margin_x, $margin_y, $color_red, $font, $watermark_text);
```

For using custom fonts not loaded with the OS, you could set the _GD Library_ font environment as per recommended by [PHP.net](https://www.php.net/manual/en/function.imagettftext.php) (though exactly not for the same reasons) and specify the full os path:

```php
putenv('GDFONTPATH=' . realpath('.'));

$font = dirname(__FILE__) . '/font/freesans.ttf
imagettftext($image_png, $fontsize, $angle, $margin_x, $margin_y, $color_red, $font, $watermark_text);
```

## On Linux

I have yet to find any problems with this function running on the Linux Apache environment, that being said, the following configuration should work:

```php
$font = dirname(__FILE__) . '/font/freesans.ttf');
imagettftext($image_png, $fontsize, $angle, $margin_x, $margin_y, $color_red, $font, $watermark_text);
```


# Prototype
![imagettftext() Output Example](doc/window.png)

The [index.php](index.php) contains a working example that creates watermarked files in the output directory. 
This solution defines a constant for the ```fontpath`` based on the operating system, the implementation is designed for instructives purposes 


```php
    if (PHP_OS == 'WINNT'){

        //Option 1  
        putenv('GDFONTPATH=' . realpath('.'));  //This is necessary to reference font files files on Windows
        define("FONT_PATH_DEFAULT" , dirname(__FILE__) . '/font/freesans.ttf');

        //Option 2
        //define("FONT_PATH_DEFAULT" , 'c:/windows/fonts/arial.ttf'); 
    }else{
        define("FONT_PATH_DEFAULT" , dirname(__FILE__) . '/font/freesans.ttf');
    }

    PNGApplyWaterMark($watermark_text,$original_image);
```


## Basic Troubleshooting

As stated on the PHP manual for this function, it will only work if your version of php as _freetype support_.
To check that, run [phpinfo()](https://www.php.net/manual/en/function.phpinfo.php) on a new web page in your server:

```php
<?php
    echo phpinfo();
?>
```
The page will output a list with every characterist of your system:

![phpInfo Output Example](doc/phpinfo.png)



Confirm if the following libraries are either enabled or installed:

```
GD Library => Installed
GD Support => ENABLED
FreeType Support => Enabled
PNG Support => Enabled
JPEG Support => Enabled
```
