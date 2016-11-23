<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">

        <!-- More info https://datatables.net/examples/index -->
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
        <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
        
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <style>
            body {
                padding-top: 50px;
                padding-bottom: 20px;
            }
        </style>
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/main.css">

        <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
  

    <div class="container">
      <?php

      // include_once('/utils/CsvReader.php');
      // $invPath = './inventario/inventario.txt';

      // $csv = new CsvReader();
      // $c = $csv->CSVToArray($invPath, '\t');

      // $userId = $_GET['userId'];
      // echo 'testy ' . $userId;

      // echo '<pre>';
      // print_r($c);
      // echo '</pre>';
      include_once('/classes/Excel.php');
      $excel = new Excel('./inventario/inventario_crm.xls');
      var_dump($excel->toArray());
    ?>
      <hr>

      <footer>
        <p>&copy; United Devs 2016</p>
      </footer>
    </div>
    </body>
</html>
