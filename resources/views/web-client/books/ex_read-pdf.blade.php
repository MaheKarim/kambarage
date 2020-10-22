@php
    // $file = "http://red/library/public/storage/Manuals/bGGoHi2Ffv9GMP036yFlLDvp2pUr9jJHXIs09gGT.pdf";

    $file = asset($book->getFirstMedia('file_path')->getUrl());
    $file = str_replace('android.kambarage.com','kambarage.com',$file);
    $file = urldecode($file); 
    $fileArray = explode('/',$file);
    $pdf = $fileArray[count($fileArray)-1];
    $pdfArray = explode('.',$pdf);
    $name = $pdfArray[0];
    $newName = strrev($name);
    $newfile = str_replace("$name.pdf","$newName.temp",$file);
@endphp
<html>
  <head>
  </head>
  <body>
    <style>
        body{
            margin: 0px;
        }
        #pdf-viewer-container{
            background: gray;
            padding: 20px;
            height: auto;
            min-height: 100%;
        }
        h2{
            color: white;
        }
    </style>
    <div id="pdf-viewer-container">
        <pdfv-iewer source="{{$newfile}}"></pdfv-iewer>
    </div>
    <script src="{{asset('ngpdf/pdf-read-test-es5.js')}}" nomodule defer></script>
    <script src="{{asset('ngpdf/pdf-read-test-es2015.js')}}" type="module"></script>
    </body>
</html>
