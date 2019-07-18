<?
$path = "../";
include $path."common/conexion.php";
?>
<HTML>
<HEAD>
<TITLE>Administrador de Newsletter<? echo str_repeat("&nbsp;",50) ?></TITLE>
<META http-equiv="" content="text/html; charset=iso-8859-1">
<STYLE>
td, select, input{
	font-family:arial;
	font-size:11px;
}
select,input{
	width:100%;
}
.botones {
	font-family: Webdings;
	font-size: 13px;
	cursor: hand;
}
FIELDSET{
	width:100%;
	height:100%;
}
</STYLE>
<SCRIPT language="JavaScript" src="../includes/javas.js"></SCRIPT>
</HEAD>

<BODY bgcolor="#D4D0c8" style="border:0;margin:0;" scroll="no">
<TABLE width="100%" height="100%" border="0" cellpadding="8" cellspacing="8">
  <TR align="center" valign="top"> 
    <TD width="50%" height="30"> <FIELDSET>
      <LEGEND>Seleccione un Newsletter</LEGEND>
      <TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
        <TR> 
          <TD width="100%"> <INPUT name="txtUbicacion" type="text" id="txtUbicacion"> 
            <INPUT type="hidden" name="id_estructura" value=""> </TD>
          <TD> <INPUT name="sel_ubi" type="button"  class="bot" onClick="abrirVentana('ow.php?tabla=estructura&include=estructura&usuario_admin=<? echo $usuario_admin ?>&seleccionar=si&path=../','ubi','450','350')" value="Seleccionar" > 
          </TD>
          <TD><INPUT type="submit" name="Submit" value="Enviar"></TD>
        </TR>
      </TABLE>
      </FIELDSET></TD>
    <TD width="50%" height="30">&nbsp;</TD>
  </TR>
  <TR align="center" valign="top"> 
    <TD colspan="2"><IFRAME name="abm" src="news.php?id_estructura=<? if(!isset($id_estructura)){ echo "1";}?>" scrolling="auto" style="width:100%;height:100%"></IFRAME></TD>
  </TR>
  <TR align="center" valign="top"> 
    <TD height="30">&nbsp;</TD>
    <TD width="50%" height="30"><FIELDSET>
      <LEGEND>Seleccione una Lista</LEGEND>
      <SELECT name="select">
      </SELECT>
      O un mail en particular
	  <TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
  <TR>
    <TD width="50%"><INPUT type="text" name="textfield"></TD>
    <TD width="50%"><INPUT type="submit" name="Submit" value="Lanzar Newsletter"></TD>
  </TR>
</TABLE>

        
      </FIELDSET></TD>
  </TR>
</TABLE>
</BODY>
</HTML>
