<?
//################# CONFIGURACION DE CONEXION ##############
$base = "especiales"; 
$conexion = mysql_connect("localhost", "especiales", "especiales"); 
$db = mysql_select_db($base, $conexion);
//################# VARIABLES GLOBALES ##############
//include "grab_globals.lib.php";
    if (!empty($_GET)) {
        extract($_GET);
    } else if (!empty($HTTP_GET_VARS)) {
        extract($HTTP_GET_VARS);
    } 
    if (!empty($_POST)) {
        extract($_POST);
    } else if (!empty($HTTP_POST_VARS)) {
        extract($HTTP_POST_VARS);
    } 
	
    if (!empty($_SERVER)) {
        extract($_SERVER);
    } else if (!empty($HTTP_SERVER_VARS)) {
        extract($HTTP_SERVER_VARS);
    } 
	
    if (!empty($_COOKIE)) {
        extract($_COOKIE);
    } else if (!empty($HTTP_COOKIE_VARS)) {
        extract($HTTP_COOKIE_VARS);
    } 
	
 /*   if (!empty($_FILES)) {
        while (list($name, $value) = each($_FILES)) {
           	${$name}['temporal'] = $value['tmp_name'];
			${$name}['original'] = $value['name'];
			${$name}['peso'] = $value['size'];
        }
    } else if (!empty($HTTP_POST_FILES)) {
        while (list($name, $value) = each($HTTP_POST_FILES)) {
            ${$name}['temporal'] = $value['tmp_name'];
			${$name}['original'] = $value['name'];
			${$name}['peso'] = $value['size'];
        }
    } */
//################# CIERRE DE SESSION ##############
if(isset($salir)){ 
	session_unset();
	unset($id_usuario);
	setcookie("id_usuario", "",time()+3);
}
?>