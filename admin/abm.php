<? 
############# QUERY #########
if ($accion == "modificar" || $accion == "borrar"){ $strQuery = "SELECT * FROM " . $tabla . " WHERE id=" . $id;}
if ($accion == "agregar"){ $strQuery = "SELECT * FROM " . $tabla . " LIMIT 1";}
$query = mysql_query($strQuery);
$cantidad_campos = mysql_num_fields($query);
$row = mysql_fetch_array($query);
$mensaje = "";
################### FORMACION DE QUERYSTRING #####################
if(isset($ejecutar)){
	$ejecutar_query = true;
	$var = "var_" . $accion;
	$QueryExec_A1 = "INSERT INTO " . $tabla . " ("; 
	$QueryExec_A2 = ") VALUES (";
	$QueryExec_M = "UPDATE " . $tabla . " SET "; 
	for($Campo = 0; $Campo < $cantidad_campos; $Campo++){
		if(mysql_field_name($query,$Campo) != "id"){
			$QueryExec = "";
			$nom = mysql_field_name($query,$Campo);
			$tip = mysql_field_type($query,$Campo);
			$QueryExec_A1 .= "`" . $nom . "`";
			$QueryExec_M .= $nom . "=";
			if (isset(${$var}[$nom]) && substr($nom, 0, 8) != "archivo_"){
				if ($tip!="int"){ $QueryExec .= "'";}
				if ($tip=="int" && ${$var}[$nom]==""){ $QueryExec .= "''";}
				$QueryExec .= addslashes( ${$var}[$nom] );
				if ($tip!="int"){ $QueryExec .= "'";}
				if (substr($nom, 0, 5) == "clave"){ ####### si es clave
					$QueryExec = " PASSWORD(" . $QueryExec . ") ";
				}				
								
			}elseif(($tip=="date" || $tip=="datetime") && isset(${$var}[$nom.'_anio'])){
				$QueryExec .= "'" .${$var}[$nom.'_anio']. "-" . ${$var}[$nom.'_mes']. "-" . ${$var}[$nom.'_dia'] ;
				if ($tip=="datetime"){ $QueryExec .= " " . date("H:i:s");} 
				$QueryExec .= "'";
			###### AGREGAR ARCHIVO ########
			}elseif (substr($nom, 0, 8) == "archivo_" && $accion != "borrar"){
				$nombre_carpeta = substr($nom, 8, strlen($nom));
				if(!isset($id)){
					$row_id = mysql_fetch_array(mysql_query("SHOW TABLE STATUS LIKE '" . $tabla . "'"));
					$id = $row_id["Auto_increment"];
				}
				$extencion = explode(".", $HTTP_POST_FILES[$nom]['name']);
				if(
				(strtolower($extencion[1]) == "jpg" || 
				 strtolower($extencion[1]) == "jpeg" || 
				 strtolower($extencion[1]) == "gif" || 
				 strtolower($extencion[1]) == "mov" || 
				 strtolower($extencion[1]) == "avi" || 
				 strtolower($extencion[1]) == "mpeg" || 
				 strtolower($extencion[1]) == "wav" || 
				 strtolower($extencion[1]) == "mp3" || 
				 strtolower($extencion[1]) == "rpm" ) &&
				 is_uploaded_file($HTTP_POST_FILES[$nom]['tmp_name'])
				){
					$destino = "clipart/". $nombre_carpeta . "/" . $id . "." . $extencion[1]; 
					if(!is_dir("clipart/". $nombre_carpeta . "/")){
						mkdir ("clipart/". $nombre_carpeta . "/"); 
					}
					
					move_uploaded_file( $HTTP_POST_FILES[$nom]['tmp_name'], $destino);
					$mensaje = "Archivo adjuntado";
					$QueryExec .= "'" . $id . "." . $extencion[1] . "'";
					chmod( $destino, 0777 ); 
				}else{
					$mensaje = "No se pudo subir " . $HTTP_POST_FILES[$nom]['tmp_name'];
					$QueryExec .= "''";
					$ejecutar_query = false;
	
				} ## fin del is_upload_file
			
			######  FIN AGREGAR ARCHIVO ########
			}else{
				$QueryExec .="''";
			}
		
			$QueryExec_A2 .= $QueryExec ; 
			$QueryExec_M .= $QueryExec ;
			if ($Campo != $cantidad_campos-1){$QueryExec_A1 .= ", ";$QueryExec_A2 .= ", ";$QueryExec_M .= ", ";	}			
		}
		}
		$QueryExec_A = $QueryExec_A1 . $QueryExec_A2 . ");";
#########  ABM
	switch($ejecutar){
		case "AGREGAR": 
			$ExecQuery = $QueryExec_A ; 
		break;
		
		case "MODIFICAR": 
			$ExecQuery = $QueryExec_M . " WHERE id=" . $id; 
		break;
		
		case "BORRAR": 
			$ExecQuery = "DELETE FROM " . $tabla . " WHERE id=" . $id; 
		break;
	}
	if($ejecutar_query){
		if (mysql_query($ExecQuery)){
			$id = mysql_insert_id();
			echo  $mensaje;
			#echo "<FONT size=2 color=ff9900 face=verdana><B>  Acción Exitosa en la base de datos</B></FONT>";
		}else{
			#echo "<FONT size=2 color=red face=verdana><B>  ERROR en la Operación</B></FONT>";
			echo $ExecQuery;
		}
	}
	
	if( (isset($include) && $include!="")  ){ ##### && !isset($tiene_solapas)
		if ($row_usuario['nombre']== "Hernán" && $row_usuario['apellido']=="Ramirez"){echo "<BR>" . $ExecQuery;}
		include "vertabla.php";
	}
/*
	if (!isset($tiene_solapas)){
		exit;
	}
*/	
}ELSE{	## sin no esta ejecutar 
//######################## JS #####################################
?>
<SCRIPT language="JavaScript">
<!-- comprovacion de modificacion del campo por HJR
function envio(){
	pass = 1;
	var nombre_campo = new Array();
<? $cont = 0; 
	FOR($Campo = 0; $Campo < $cantidad_campos; $Campo++){ 
			if(mysql_field_name($query,$Campo) != "id" && strstr(mysql_field_flags ($query, $Campo), "not_null") != false){ 
 ?>	nombre_campo[<? echo $cont ?>] = "<? echo mysql_field_name($query,$Campo) ?>"; 
 <? $cont++;
			 }
		}?>
	for (var i=0; i<nombre_campo.length; i++){
		campo_base = nombre_campo[i];
		
		for (var u=0; u<document.formulario_abm.length; u++){
			campo_form = document.formulario_abm.elements[u].name;
			if(campo_form == campo_base){
				campo_extra = document.formulario_abm.elements[u];
			}else	if(campo_form.indexOf(campo_base)!=-1){
				campo = document.formulario_abm.elements[u];
			}
		}
		if( campo.type == "select-one" ){
			if(campo.selectedIndex==-1){
				alert("Olvidó seleccionar una opción en el campo " + campo_base.toUpperCase());
				pass = 0;
			}
			
		}else if( campo.value == "" ){
			alert("Olvidó llenar el campo " + campo_base.toUpperCase());
			pass = 0;
		}
		
	}
	
	if (pass == 1){
		document.formulario_abm.submit();
	}
}
function agregarVinculado(tabla){
	archivo = "<? if(isset($path_de_relacion)){ echo $path_de_relacion;} ?>ow.php?accion=agregar&tabla="+ tabla + "&base=<? echo $base ?>";
	nombre_ventana = "agregar_" + tabla[1];
	window.open(archivo, nombre_ventana, "WIDTH=300, HEIGHT=250, scrollbars, resizable, top=150, left=150");
}
//-->
</SCRIPT>
<? 
//######################## VOLCADO ##################################### 
?>
<LINK href="includes/estilos_admin.css" rel="stylesheet" type="text/css">
<FORM name="formulario_abm" method="post" action="<? echo $PHP_SELF ?>?include=<? if(isset($include)){ echo $include;} ?>&ejecutar=<? echo strtoupper($accion) ?>&accion=<? echo $accion; if(isset($id)){ echo '&id=' . $id;}; if(isset($back_campo)){ echo '&back_campo=' .$back_campo; } ?>" enctype="multipart/form-data">
    <INPUT name="tabla" type="hidden" value="<? echo $tabla ?>">
    <INPUT name="base" type="hidden" value="<? echo $base ?>">
    <? if(isset($num_pagina)){ ?>
    <INPUT name="num_pagina" type="hidden" value="<? echo $num_pagina ?>">
    <? } ?>
    <? if(isset($ordenado)){ ?>
    <INPUT name="ordenado" type="hidden" value="<? echo $ordenado ?>">
    <? } ?>
    <? if(isset($ordenado_forma)){ ?>
    <INPUT name="ordenado_forma" type="hidden" value="<? echo $ordenado_forma ?>">
    <? } ?>
    <?	if (isset($buscar)){
	 while (list($clave, $valor) = each ($var_buscar)) { ?>
    <INPUT name="var_buscar[<? echo $clave ?>]" type="hidden" value="<? echo $valor ?>">
    <? } ?>
    <INPUT name="buscar" type="hidden" value="realizar">
    
  <? } 
  
  include "abm_header.php";
  
  ?>
        
 
  <TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
    <TR> 
		<TD width="15%" class="HeaderContenido">Campo</TD>
		<TD width="1" bgcolor="D6EBFF"><IMG src="../image/spacer.gif" width="1" height="1"></TD>
		<TD width="85%" class="HeaderContenido">Datos</TD>
    </TR>
</TABLE>
  <TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
          
    <? FOR($Campo = 0; $Campo < $cantidad_campos; $Campo++){ 
	 		 if (mysql_field_name($query,$Campo) != "log" 
			 && mysql_field_name($query,$Campo) != "fecha_stmp" 
			 && mysql_field_name($query,$Campo) != "_timestamp" 
			 && mysql_field_name($query,$Campo) != "_id_usuario" 
			 && mysql_field_name($query,$Campo) != "id"
			 ){ ?>
    <TR<? if((isset($oculto_abm) && $oculto_abm!="") && strstr(",".$oculto_abm.",", ",".mysql_field_name($query,$Campo).",")!=false ){ echo " style='display:none'";} ?>> 
            
      <TD align="right" width="15%" valign="top" class="Celeste">
        <TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
          <TR>
            <TD class="Celeste" align="right" height="20">
              <? leyenda_campo($query,$Campo) ?>
            </TD>
          </TR>
        </TABLE>
        </TD>
      <TD bgcolor="#D6EBFF" width="1"><IMG src="image/spacer.gif" width="1" height="1"></TD>
      <TD class="Celeste"> 
              
        <SPAN class="selectINT">
        <? if (isset($buscar) && $accion == "agregar"){
					tipo_campo("agregar_buscada", $query, $Campo, $var_buscar, $base);
			  	}else{
					tipo_campo($accion, $query, $Campo, $row, $base);
				} ?>
        </SPAN>
      </TD>
    </TR>
    <TR<? if((isset($oculto_abm) && $oculto_abm!="") && strstr(",".$oculto_abm.",", ",".mysql_field_name($query,$Campo).",")!=false ){ echo " style='display:none'";} ?> bgcolor="#D6EBFF">
      <TD><IMG src="image/spacer.gif" width="1" height="1"></TD>
      <TD width="1"><IMG src="image/spacer.gif" width="1" height="1"></TD>
      <TD bgcolor="#D6EBFF"><IMG src="image/spacer.gif" width="1" height="1"></TD>
    </TR>
		 
    <? }else{ 
		 		switch(mysql_field_name($query,$Campo)){
				case "log":
		 			$who = strtoupper(substr($row_log['nombre'], 0, 1)) . strtoupper(substr($row_log['apellido'], 0, 1));  ?>
  					
    <INPUT name="<? echo "var_" . $accion . "[log]" ?>" type="hidden" value="<? echo $who ?>">
		 
    <? 	break;	
		 		case "fecha_stmp":
					$fecha_stmp = date("Y-m-d"); ?>  					
    <INPUT name="<? echo "var_" . $accion . "[fecha_stmp]" ?>" type="hidden" value="<? echo $fecha_stmp ?>">		 
<?	 break;
		 		case "_timestamp":
					?><INPUT name="<? echo "var_" . $accion . "[_timestamp]" ?>" type="hidden" value="NOW()+0"><?	 
				break;
		 		case "_id_usuario":
					?><INPUT name="<? echo "var_" . $accion . "[_id_usuario]" ?>" type="hidden" value="<? echo $id_usuario ?>"><?	 
				break;
	}
}
} ?>        
  </TABLE>
</FORM>
<CENTER>
  <? if (isset($include)){ ?>
  <P><A href="javascript:history.back();">VOLVER</A> 
    <? }else{ ?>
    <A href="javascript:window.close();">CERRAR</A> 
    <? } ?>
  </P>
</CENTER>
<? } ## sacar esto para las solapas ?>