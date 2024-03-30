<?php $title = "home"; ?>

<?php ob_start(); ?>

    <h1>ERREUR 404 Page Not Found</h1>
    
<?php 
echo "<pre>";
var_dump($_POST);
echo "</pre>";
$content = ob_get_clean();
require "layout.php";
?>