<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>~Laboratorio~</title>
	<link rel="icon" type="image/png" href="../img/logo.png" />
	<link href='http://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="./estilos.css">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>
	<div class="fondo"><div id="particles-js"></div></div>
	<div id="lab">
		<h1>Laboratorio</h1>
		<div id="table">
			<div class="sub-table">
				<div class="table-items">Local File Inclusion</div>
				<div class="table-items boton-lfi" align="center">
					<?php
						if (exec('if docker images | grep "davicillo12/lfi" >/dev/null 2>&1; then echo yes; else echo no; fi| xargs echo') == "no") {
					?>
							<input type="submit" value="Descargar" class="boton1">
					<?php
						} else {
							?>
							<input type="submit" value="Descargado" class="boton1" disabled>
							<?php
					}
					?>
				</div>
				<div class="table-items boton-lfi"  align="center"><input type="submit" value="Encender" class="boton2"></div>
				<div class="table-items boton-lfi" align="center"><input type="submit" value="Reiniciar" class="boton3"></div>
				<div class="table-items boton-lfi" align="center"><input type="submit" value="Apagar" class="boton4"></div>
				<div class="table-items" id="local1">
				<?php
					if (exec('if docker ps | grep "lfi" >/dev/null 2>&1; then echo yes; else echo no; fi') == "yes") {
						echo '<a class="enlace" target="_blank" href="http://schoolhack.local:8000">http://schoolhack.local:8000</a>';
					}
					else {
						echo '<a class="enlace" target="_blank"></a>';
					}
				?>
				</div>
			</div>
			<div class="sub-table">
				<div class="table-items">Log Poisoning</div>
				<div class="table-items boton-lp" align="center">
					<?php
						if (exec('if docker images | grep "davicillo12/log_poisoning" >/dev/null 2>&1; then echo yes; else echo no; fi| xargs echo') == "no") {
					?>
							<input type="submit" value="Descargar" class="boton1">
					<?php
						} else {
							?>
							<input type="submit" value="Descargado" class="boton1" disabled>
							<?php
					}
					?>
				</div>
				<div class="table-items boton-lp" align="center"><input type="submit" value="Encender" class="boton2"></div>
				<div class="table-items boton-lp" align="center"><input type="submit" value="Reiniciar" class="boton3"></div>
				<div class="table-items boton-lp" align="center"><input type="submit" value="Apagar" class="boton4"></div>
				<div class="table-items" id="local1">
					<?php
					if (exec('if docker ps | grep "log_poisoning" >/dev/null 2>&1; then echo yes; else echo no; fi') == "yes") {
						echo '<a class="enlace" target="_blank" href="http://schoolhack.local:8001">http://schoolhack.local:8001</a>';
					}
					else {
						echo '<a class="enlace" target="_blank"></a>';
					}
					?>
				</div>
			</div>
			<div class="sub-table">
				<div class="table-items">Remote File Inclusion</div>
				<div class="table-items boton-rfi" align="center">
					<?php
						if (exec('if docker images | grep "davicillo12/rfi" >/dev/null 2>&1; then echo yes; else echo no; fi| xargs echo') == "no") {
					?>
							<input type="submit" value="Descargar" class="boton1">
					<?php
						} else {
							?>
							<input type="submit" value="Descargado" class="boton1" disabled>
							<?php
					}
					?>
				</div>
				<div class="table-items boton-rfi" align="center"><input type="submit" value="Encender" class="boton2"></div>
				<div class="table-items boton-rfi" align="center"><input type="submit" value="Reiniciar" class="boton3"></div>
				<div class="table-items boton-rfi" align="center"><input type="submit" value="Apagar" class="boton4"></div>
				<div class="table-items" id="local1">
					<?php
					if (exec('if docker ps | grep "rfi" >/dev/null 2>&1; then echo yes; else echo no; fi') == "yes") {
						echo '<a class="enlace" target="_blank" href="http://schoolhack.local:8002">http://schoolhack.local:8002</a>';
					}
					else {
						echo '<a class="enlace" target="_blank"></a>';
					}
					?>
				</div>
			</div>
			<div class="sub-table">
				<div class="table-items">Inyección SQL</div>
				<div class="table-items boton-isql" align="center">
					<?php
						if (exec('if docker images | grep "davicillo12/sqlinjection" >/dev/null 2>&1; then echo yes; else echo no; fi| xargs echo') == "no" || exec('if docker images | grep "davicillo12/basedatos" >/dev/null 2>&1; then echo yes; else echo no; fi| xargs echo') == "no") {
					?>
							<input type="submit" value="Descargar" class="boton1">
					<?php
						} else {
							?>
							<input type="submit" value="Descargado" class="boton1" disabled>
							<?php
					}
					?>
				</div>
				<div class="table-items boton-isql" align="center"><input type="submit" value="Encender" class="boton2"></div>
				<div class="table-items boton-isql" align="center"><input type="submit" value="Reiniciar" class="boton3"></div>
				<div class="table-items boton-isql" align="center"><input type="submit" value="Apagar" class="boton4"></div>
				<div class="table-items" id="local1">
					<?php
					if (exec('if docker ps | grep "sqlinjection" >/dev/null 2>&1; then echo yes; else echo no; fi') == "yes" && exec('if docker ps | grep "basedatos" >/dev/null 2>&1; then echo yes; else echo no; fi') == "yes") {
						echo '<a class="enlace" target="_blank" href="http://schoolhack.local:8003">http://schoolhack.local:8003</a>';
					}
					else {
						echo '<a class="enlace" target="_blank"></a>';
					}
					?>
				</div>
			</div>
			<div class="sub-table">
				<div class="table-items">Fuerza Bruta</div>
				<div class="table-items boton-bf" align="center">
					<?php
						if (exec('if docker images | grep "davicillo12/brute_force" >/dev/null 2>&1; then echo yes; else echo no; fi| xargs echo') == "no") {
					?>
							<input type="submit" value="Descargar" class="boton1">
					<?php
						} else {
							?>
							<input type="submit" value="Descargado" class="boton1" disabled>
							<?php
					}
					?>
				</div>
				<div class="table-items boton-bf" align="center"><input type="submit" value="Encender" class="boton2"></div>
				<div class="table-items boton-bf" align="center"><input type="submit" value="Reiniciar" class="boton3"></div>
				<div class="table-items boton-bf" align="center"><input type="submit" value="Apagar" class="boton4"></div>
				<div class="table-items" id="local1">
					<?php
					if (exec('if docker ps | grep "brute_force" >/dev/null 2>&1; then echo yes; else echo no; fi') == "yes") {
						echo '<a class="enlace" target="_blank" href="http://schoolhack.local:8004">http://schoolhack.local:8004</a>';
					}
					else {
						echo '<a class="enlace" target="_blank"></a>';
					}
					?>
				</div>
			</div>
		</div>
	</div>
	<!--Inicio del contenido-->
	<div id="cargando">
		<div class="f1078404_sup"><div class="f978404_petit"><div class="f1078404_fond"><div class="f1078404"></div></div></div></div>
	</div>

		
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="js/particles.js"></script>
	<script src="js/particulas.js"></script>
	<script src="js/script.js"></script>
	<script>
		let ip = "<?php echo $_SERVER['SERVER_ADDR']; ?>"
	</script>
</body>
</html>
