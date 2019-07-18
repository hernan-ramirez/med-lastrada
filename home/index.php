<? $path = "../";
	include $path . "common/motor.php";
	if(!isset($id_estruc)){	$id_estruc=10;}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Leonardo Astrada :: Web Site Oficial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../common/css/estilos.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor="F5F5F5">
<TABLE width="746" border="0" cellspacing="0" cellpadding="0">
<TR>
	<TD class="BigTableLeft">
		<TABLE width="472" border="0" cellspacing="0" cellpadding="0">
		<TR>
			<TD><img src="<? echo $path ?>img/header_actualidad.gif" width="472" height="199"></TD>
		</TR>
		</TABLE>

		<TABLE width="468" border="0" cellspacing="0" cellpadding="0">
		<TR> 
			<TD><img src="<? echo $path ?>img/banner.gif" width="468" height="60" hspace="0" vspace="0"></TD>
		</TR>
		<TR> 
		<TD>
			<TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
			<TR>
				<TD width="50%"><? include "entrevista.php" ?></TD>
				<TD><? include "opinion.php" ?></TD>
			</TR>
			</TABLE>
		</TD>
		</TR>
		<TR>
			<TD><? include "mas_noticias.php "?></TD>
		</TR>
		</TABLE> 
	</TD>
    <TD class="BigTableRight">
		<TABLE border="0" cellpadding="0" cellspacing="0">
        <TR>
					<TD class="RightGrayContent">
						<? include  $path . "especiales/ultimo_partido.php" ?>
						<? include  "cronicas.php" ?>
						<? include  $path . "especiales/proximo_partido.php" ?>
						<? include  $path . "encuesta/encuesta.php" ?>
					</TD>
        </TR>
      </TABLE>
	  </TD>
  </TR>
</TABLE>
<? include  "footer.php" ?>
</body>
</html>
