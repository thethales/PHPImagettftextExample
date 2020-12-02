<?php


    //Defines a constant for the Font path for each instance of operating system
    if (PHP_OS == 'WINNT'){

        //Option 1  
        putenv('GDFONTPATH=' . realpath('.'));  //This is necessary to reference font files files on Windows
        define("FONT_PATH_DEFAULT" , dirname(__FILE__) . '/font/freesans.ttf');

        //Option 2
        //define("FONT_PATH_DEFAULT" , 'c:/windows/fonts/arial.ttf'); 
    }else{
        define("FONT_PATH_DEFAULT" , dirname(__FILE__) . '/font/freesans.ttf');
    }



     /**
     * Sample function that applies a watermark to a PNG document
     * @param $watermark_text  Watermark Text
     * @param $original_file_path Fullpath to the source image
     * @return string Returns  the name of the file
     *          success - Boolean - Descreve se o procedimento foi bem sucedido [True]
     *          message - String  - Mensagem de Erro quando houver success=False
     *          content - Null|String Base64 - Arquivo Binário assinado no formato Base64
     */
    function PNGApplyWaterMark(string $watermark_text,string $original_file_path){
 
        //Sets the output file with random name
        $output_file_path = dirname(__FILE__) . '\output\\' . uniqid() . '.png';
        
        //Creates a PNG file from the input file, to create a JPEG see imagecreatefromjpeg()               
        $image_png = imagecreatefrompng($original_file_path);
                        
        //Sets X and Y margins for watermark placement
        $image_png_x = imagesx($image_png);
        $image_png_y = imagesy($image_png);
        $margin_x = $image_png_x - 20;
        $margin_y = $image_png_y - 10;
        //Sets The Angle, Font Size and Color
        $angle = 90;
        $fontsize=20;
        $color_red = imagecolorallocate($image_png, 255, 0, 0);
    
        
        imagettftext($image_png, $fontsize, $angle, $margin_x, $margin_y, $color_red, FONT_PATH_DEFAULT, $watermark_text); //Write watermark on file
        imagepng($image_png, $output_file_path); //Write image to file
        
        return basename($output_file_path);

    }

    //Calls  the function for exhibition purposes
    $original_image = realpath('sample_files/PDF_LoremIpsum_TwoPages_0001.png');
    $watermark_text = 'If I have seen further than others, it is by standing upon the shoulders of giants. - Isaac Newton';
    $image1 = 'output/' . PNGApplyWaterMark($watermark_text,$original_image);

    $original_image = realpath('sample_files/PDF_LoremIpsum_TwoPages_0002.png');
    $image2 = 'output/' .PNGApplyWaterMark($watermark_text,$original_image);

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        
        <title>PHP imagettftext Example</title>

        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="css/sticky-footer.css" rel="stylesheet">
    </head>

  <body>

    <!-- Begin page content -->
    <main role="main" class="container">
      <h1 class="mt-5">PHP imagettftext Example</h1>

        <p class="mt-3">The PHP <a href="https://www.php.net/manual/en/function.imagettftext.php" class="font-italic">imagettftext()</a> 
                is a function used to write text to an image using TrueType fonts. 
                This is a working sample for both Windows e Linux based hosting on PHP 5 and 7.
        <div class="mt-5 row">
            <div class="card ml-4" style="width: 18rem;">
                <img class="card-img-top" src="sample_files/PDF_LoremIpsum_TwoPages_0001.png" alt="Original Image" width="500px;">
                <div class="card-body">
                    <p class="card-text">Original Image</p>
                </div>
            </div>
            <div class="card ml-4" style="width: 18rem;">
                <img class="card-img-top" src="<?= $image1?>" alt="Original Image" width="500px;">
                <div class="card-body">
                    <p class="card-text">Processed Image</p>
                </div>
            </div>
        </div>
    
    </main>

    <footer class="footer">
      <div class="container">
        <span class="text-muted">Working example of imagettftext() <a href="https://www.php.net/manual/en/function.imagettftext.php" class="font-italic">imagettftext()</a> </span>
      </div>
    </footer>
  

</body></html>