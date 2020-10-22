@php
    // $file = "http://red/library/public/storage/Manuals/bGGoHi2Ffv9GMP036yFlLDvp2pUr9jJHXIs09gGT.pdf";

    $file = asset($book->getFirstMedia('file_path')->getUrl());
@endphp
<!doctype HTML>
<html style="height:100%;">
    <head>
        <title>
            Read File
        </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Read E-book file">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
            integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>
    <body class="bg-dark h-100">

        <div class="container-fluid bg-dark h-100">
            <div class="row h-100">
                <div class="col-12 col-md-10 col-lg-8 mx-auto h-100">
                <iframe class="w-100 text-center bg-white h-100" src='https://docs.google.com/viewer?url={{$file}}&embedded=true' frameborder='0'></iframe>
                </div>
            </div>
        </div>
    </body>
</html>