<?php
//Relative to the index.php page.

//Default view if one is not matched. An absolute URL works best.
$router->setDefaultUrl('http://localhost/mvc-php/index.php/index');

//Format is the url extentsion (e.g www.example.com/index.php/index), the path to
//the template from the index.php file and the view controller.
$router->route('index', 'templates/indexView.php', 'indexCtrl');
$router->route('another', 'templates/anotherView.php', 'anotherCtrl');

//Do not close of <?php with ? > 