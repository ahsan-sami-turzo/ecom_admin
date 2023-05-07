<?php


use Illuminate\Support\Facades\Request;
use Intervention\Image\Facades\Image;


function doUploadImage($name=null, $path, $photo, $optimizePath, $width=null, $height=null, $format, $unlink = null): string
{

    $imageName = $name . '.' . $format;
    $path = public_path("$path/$imageName");
    $pathOptimize = public_path("$optimizePath/$imageName");
    Image::make( $photo )->encode($format)->save( $path );
    Image::make( $photo )->resize($width, $height, function ($constraint) {
        $constraint->aspectRatio();
        $constraint->upsize();
    })->save( $pathOptimize );
   // ImageOptimizer::optimize($pathThumbs);
    return $imageName ;
}

if (! function_exists('words')) {
    /**
     * Limit the number of words in a string.
     *
     * @param  string  $value
     * @param  int     $words
     * @param  string  $end
     * @return string
     */
    function words($value, $words = 100, $end = '...')
    {
        return \Illuminate\Support\Str::words($value, $words, $end);
    }
}

function generateProductSku($productName, $vendorId)
    {
        return str_pad( strtoupper( substr( preg_replace("/[^a-zA-Z]+/", "", $productName), 0, 3) ), 3, "0" , STR_PAD_RIGHT).'_'. str_pad($vendorId,5,'0',STR_PAD_LEFT).'_'.uniqid();
    }
//sdfdfghsdfg
//sdf ......
//SDF-12223-rgygf566



