<LINK href="common/css/estilos.css" rel="stylesheet" type="text/css"> 
<table width="472" border="0" cellspacing="2" cellpadding="0">
	<tr> 
		<td class="RedBar"><img src="img/noticias.gif" width="39" height="9"></td>
	</tr>
<?
$sql = "SELECT n.*, f.archivo_imagen, p.pais, d.deporte FROM noticias n
	LEFT JOIN fotos f ON (n.id_foto = f.id)
	LEFT JOIN paises p ON (n.id_pais = p.id)
	LEFT JOIN deportes d ON (n.id_deporte = d.id)
	LEFT JOIN publicaciones pu ON (pu.id_publicado = n.id)
	WHERE pu.id_seccion = 4
	AND pu.id_lista_tablas = 40 
	AND pu.id_estructura = $id_estruc
	ORDER by posicion";
	
$result = mysql_query ($sql);
if(mysql_num_rows($result)!=0){
	while ($row = mysql_fetch_array($result)){
?>	
	<tr> 
		<td class="marginleft"><A HREF="#"><? echo $row["titulo"] ?></A></td>
	</tr>
<?
	} 
}
?>	
</table>
