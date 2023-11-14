<?php
	ini_set('max_execution_time', 300);
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: PUT, GET, POST");
	//header("Content-Type: application/json;");
	
	if (isset($_POST['vuln']) && isset($_POST['accion'])) {
		//LFI
		if ($_POST['vuln'] == "lfi") {
			if ($_POST['accion'] == "descargar") {
				exec('docker network create --subnet=172.5.0.0/16 local_file_inclusion');
				exec('sleep 1');
				$command = 'bash -c "docker run -p 8000:80 --net local_file_inclusion --ip 172.5.0.5 --name lfi --hostname cuentos -d davicillo12/lfi:v4 >/dev/null 2>&1" & wait';
				
				// Abre el proceso y captura la salida
				$descriptorspec = array(
					0 => array('pipe', 'r'),  // Entrada estándar
					1 => array('pipe', 'w'),  // Salida estándar
					2 => array('pipe', 'w'),  // Salida de error
				);
				
				$process = proc_open($command, $descriptorspec, $pipes);
				
				if (is_resource($process)) {
					stream_set_blocking($pipes[1], 0); // Hace que la salida no bloquee el script
				
					while (!feof($pipes[1])) {
						echo fgets($pipes[1]); // Muestra la salida en tiempo real
						ob_flush();
						flush();
					}
				
					fclose($pipes[1]);
				
					// Espera a que el proceso termine
					$return_value = proc_close($process);
				}
				exec('sleep 1');
				exec('docker exec lfi service ssh start');
				//exec('wait');
				$check = shell_exec('bash -c "if docker ps | grep \"davicillo12/lfi:v4\" &>/dev/null; then echo \"True\"; else echo \"False\"; fi"');
				if (trim($check) == "True"){
					$a = ["estado" => True];
					echo json_encode($a);
				}
				else {
					$a = ["estado" => False];
					echo json_encode($a);
				}
			}
			if ($_POST['accion'] == "encender") {
				exec('bash -c "docker start lfi"');
				exec('bash -c "docker exec lfi service ssh start"');
				sleep(1);
				$check = shell_exec('bash -c "if docker ps | grep \"davicillo12/lfi:v4\" &>/dev/null; then echo \"True\"; else echo \"False\"; fi"');
				if (trim($check) == "True"){
					$a = ["estado" => True];
					echo json_encode($a);
				}
				else {
					$a = ["estado" => False];
					echo json_encode($a);
				}
			}
			if ($_POST['accion'] == "reiniciar") {
				exec('bash -c "docker stop lfi"');
				exec('bash -c "docker rm lfi"');
				exec('bash -c "docker run -p 8000:80 --net local_file_inclusion --ip 172.5.0.5 --name lfi --hostname cuentos -d davicillo12/lfi:v4"');
				exec('bash -c "docker exec lfi service ssh start"');
				sleep(1);
				$check = shell_exec('bash -c "if docker ps | grep \"davicillo12/lfi:v4\" &>/dev/null; then echo \"True\"; else echo \"False\"; fi"');
				if (trim($check) == "True"){
					$a = ["estado" => True];
					echo json_encode($a);
				}
				else {
					$a = ["estado" => False];
					echo json_encode($a);
				}
			}
			if ($_POST['accion'] == "apagar") {
				exec('docker stop lfi');
				sleep(1);
				$check = shell_exec('bash -c "if docker ps | grep \"davicillo12/lfi:v4\" &>/dev/null; then echo \"True\"; else echo \"False\"; fi"');
				if (trim($check) == "False"){
					$a = ["estado" => False];
					echo json_encode($a);
				
				}
				else {
					$a = ["estado" => True];
					echo json_encode($a);
				}
			}
		}
		// Log Poisoning 
		if ($_POST['vuln'] == "lp") {
			if ($_POST['accion'] == "descargar") {
				exec('bash -c "docker network create --subnet=172.20.0.0/16 log_poisoning"');
				exec('sleep 1');
				$command = 'bash -c "docker run -p 8001:80 --net log_poisoning --ip 172.20.0.10 --name log_poisoning --hostname marvel -d davicillo12/log_poisoning:v5 >/dev/null 2>&1" & wait';
				
				// Abre el proceso y captura la salida
				$descriptorspec = array(
					0 => array('pipe', 'r'),  // Entrada estándar
					1 => array('pipe', 'w'),  // Salida estándar
					2 => array('pipe', 'w'),  // Salida de error
				);
				
				$process = proc_open($command, $descriptorspec, $pipes);
				
				if (is_resource($process)) {
					stream_set_blocking($pipes[1], 0); // Hace que la salida no bloquee el script
				
					while (!feof($pipes[1])) {
						echo fgets($pipes[1]); // Muestra la salida en tiempo real
						ob_flush();
						flush();
					}
				
					fclose($pipes[1]);
				
					// Espera a que el proceso termine
					$return_value = proc_close($process);
				}
				exec('sleep 1');
				
				
				//exec('bash -c "docker run -p 8001:80 --net log_poisoning --ip 172.20.0.10 --name log_poisoning --hostname marvel -d davicillo12/log_poisoning:v5"');
				exec('bash -c "docker exec log_poisoning rm -f /var/log/apache2/error.log"');
				exec('bash -c "docker exec log_poisoning rm -f /var/log/apache2/access.log"');
				exec('bash -c "docker exec log_poisoning service apache2 restart"');
				exec('bash -c "docker start log_poisoning"');
				exec('bash -c "docker exec log_poisoning service cron start"');
				exec('bash -c "docker start log_poisoning"');
				sleep(1);
				$check = shell_exec('bash -c "if docker ps | grep \"davicillo12/log_poisoning:v5\" &>/dev/null; then echo \"True\"; else echo \"False\"; fi"');
				if (trim($check) == "True"){
					$a = ["estado" => True];
					echo json_encode($a);
				}
				else {
					$a = ["estado" => False];
					echo json_encode($a);
				}
			}
			if ($_POST['accion'] == "encender") {
				exec('bash -c "docker start log_poisoning"');
				sleep(1);
				$check = shell_exec('bash -c "if docker ps | grep \"davicillo12/log_poisoning:v5\" &>/dev/null; then echo \"True\"; else echo \"False\"; fi"');
				if (trim($check) == "True"){
					$a = ["estado" => True];
					echo json_encode($a);
				}
				else {
					$a = ["estado" => False];
					echo json_encode($a);
				}
			}
			if ($_POST['accion'] == "reiniciar") {
				exec('bash -c "docker stop log_poisoning"');
				exec('bash -c "docker rm log_poisoning"');
				exec('bash -c "docker run -p 8001:80 --net log_poisoning --ip 172.20.0.10 --name log_poisoning --hostname marvel -d davicillo12/log_poisoning:v5"');
				exec('bash -c "docker exec log_poisoning rm -f /var/log/apache2/error.log"');
				exec('bash -c "docker exec log_poisoning rm -f /var/log/apache2/access.log"');
				exec('bash -c "docker exec log_poisoning service apache2 restart"');
				exec('bash -c "docker start log_poisoning"');
				exec('bash -c "docker exec log_poisoning service cron start"');
				exec('bash -c "docker start log_poisoning"');
				sleep(1);
				$check = shell_exec('bash -c "if docker ps | grep \"davicillo12/log_poisoning:v5\" &>/dev/null; then echo \"True\"; else echo \"False\"; fi"');
				if (trim($check) == "True"){
					$a = ["estado" => True];
					echo json_encode($a);
				}
				else {
					$a = ["estado" => False];
					echo json_encode($a);
				}
			}
			if ($_POST['accion'] == "apagar") {
				exec('bash -c "docker stop log_poisoning"');
				sleep(1);
				$check = shell_exec('bash -c "if docker ps | grep \"davicillo12/log_poisoning:v5\" &>/dev/null; then echo \"True\"; else echo \"False\"; fi"');
				if (trim($check) == "False"){
					$a = ["estado" => False];
					echo json_encode($a);
				
				}
				else {
					$a = ["estado" => True];
					echo json_encode($a);
				}
			}
		}
		// RFI
		if ($_POST['vuln'] == "rfi") {
			if ($_POST['accion'] == "descargar") {
				exec('bash -c "docker network create --subnet=172.21.0.0/16 remote_file_inclusion"');
				//exec('bash -c "docker run -p 8002:80 --net remote_file_inclusion --ip 172.21.0.10 --name rfi --hostname urlvisitor -ti -d davicillo12/rfi:v2"');
				
				exec('sleep 1');
				$command = 'bash -c "docker run -p 8002:80 --net remote_file_inclusion --ip 172.21.0.10 --name rfi --hostname urlvisitor -ti -d davicillo12/rfi:v3 >/dev/null 2>&1" & wait';
				
				// Abre el proceso y captura la salida
				$descriptorspec = array(
					0 => array('pipe', 'r'),  // Entrada estándar
					1 => array('pipe', 'w'),  // Salida estándar
					2 => array('pipe', 'w'),  // Salida de error
				);
				
				$process = proc_open($command, $descriptorspec, $pipes);
				
				if (is_resource($process)) {
					stream_set_blocking($pipes[1], 0); // Hace que la salida no bloquee el script
				
					while (!feof($pipes[1])) {
						echo fgets($pipes[1]); // Muestra la salida en tiempo real
						ob_flush();
						flush();
					}
				
					fclose($pipes[1]);
				
					// Espera a que el proceso termine
					$return_value = proc_close($process);
				}
				exec('sleep 1');
				
				exec('bash -c "docker exec rfi service apache2 start"');
				sleep(1);
				$check = shell_exec('bash -c "if docker ps | grep \"davicillo12/rfi:v3\" &>/dev/null; then echo \"True\"; else echo \"False\"; fi"');
				if (trim($check) == "True"){
					$a = ["estado" => True];
					echo json_encode($a);
				}
				else {
					$a = ["estado" => False];
					echo json_encode($a);
				}
			}
			if ($_POST['accion'] == "encender") {
				exec('bash -c "docker start rfi"');
				exec('bash -c "docker exec rfi service apache2 start"');
				sleep(1);
				$check = shell_exec('bash -c "if docker ps | grep \"davicillo12/rfi:v3\" &>/dev/null; then echo \"True\"; else echo \"False\"; fi"');
				if (trim($check) == "True"){
					$a = ["estado" => True];
					echo json_encode($a);
				}
				else {
					$a = ["estado" => False];
					echo json_encode($a);
				}
			}
			if ($_POST['accion'] == "reiniciar") {
				exec('bash -c "docker stop rfi"');
				exec('bash -c "docker rm rfi"');
				exec('bash -c "docker run -p 8002:80 --net remote_file_inclusion --ip 172.21.0.10 --name rfi --hostname urlvisitor -ti -d davicillo12/rfi:v3"');
				exec('bash -c "docker exec rfi service apache2 start"');
				sleep(1);
				$check = shell_exec('bash -c "if docker ps | grep \"davicillo12/rfi:v3\" &>/dev/null; then echo \"True\"; else echo \"False\"; fi"');
				if (trim($check) == "True"){
					$a = ["estado" => True];
					echo json_encode($a);
				}
				else {
					$a = ["estado" => False];
					echo json_encode($a);
				}
			}
			if ($_POST['accion'] == "apagar") {
				exec('bash -c "docker stop rfi"');
				sleep(1);
				$check = shell_exec('bash -c "if docker ps | grep \"davicillo12/rfi:v3\" &>/dev/null; then echo \"True\"; else echo \"False\"; fi"');
				if (trim($check) == "False"){
					$a = ["estado" => False];
					echo json_encode($a);
				
				}
				else {
					$a = ["estado" => True];
					echo json_encode($a);
				}
			}
		}
		//Sql Injection
		if ($_POST['vuln'] == "isql") {
			if ($_POST['accion'] == "descargar") {
				exec('bash -c "docker network create --subnet=172.18.0.0/16 sql"');
				exec('sleep 1');
				//$command = 'bash -c "bash basedatos.sh >/dev/null 2>&1" & wait';
				$command = 'bash -c "docker run -p 8003:80 --net sql --ip 172.18.0.100 --name sqlinjection --hostname papas -d --link basedatos davicillo12/sqlinjection:v7 >/dev/null 2>&1" & wait';
				// Abre el proceso y captura la salida
				$descriptorspec = array(
					0 => array('pipe', 'r'),  // Entrada estándar
					1 => array('pipe', 'w'),  // Salida estándar
					2 => array('pipe', 'w'),  // Salida de error
				);
				
				$process = proc_open($command, $descriptorspec, $pipes);
				
				if (is_resource($process)) {
					stream_set_blocking($pipes[1], 0); // Hace que la salida no bloquee el script
				
					while (!feof($pipes[1])) {
						echo fgets($pipes[1]); // Muestra la salida en tiempo real
						ob_flush();
						flush();
					}
				
					fclose($pipes[1]);
				
					// Espera a que el proceso termine
					$return_value = proc_close($process);
				}
				exec('sleep 1');
				
				exec('bash -c "docker exec sqlinjection service ssh start"');
				exec('bash -c "docker start basedatos"');
				
				$check = shell_exec('bash -c "if docker ps | grep \"davicillo12/sqlinjection:v7\" &>/dev/null; then echo \"True\"; else echo \"False\"; fi"');
				$check1 = shell_exec('bash -c "if docker ps | grep \"davicillo12/basedatos:v1\" &>/dev/null; then echo \"True\"; else echo \"False\"; fi"');
				if (trim($check) == "True"){
					if (trim($check1) == "True"){
						$a = ["estado" => True,"estado1" => True]; // Funciona las 2
						echo json_encode($a);
					}else{
						$a = ["estado" => True,"estado1" => False]; // Funciona solamente davicillo12/sqlinjection:v7
						echo json_encode($a);
					}
				}
				else {
					if (trim($check1) == "True"){
						$a = ["estado" => False,"estado1" => True]; // Funciona solamente davicillo12/basedatos:v1
						echo json_encode($a);
					}else{
						$a = ["estado" => False,"estado1" => False]; // No funciona ninguna
						echo json_encode($a);
					}
				}
			}
			if ($_POST['accion'] == "encender") {
				exec('bash -c "docker start basedatos"');
				exec('bash -c "docker start sqlinjection"');
				sleep(1);
				$check = shell_exec('bash -c "if docker ps | grep \"davicillo12/sqlinjection:v7\" &>/dev/null; then echo \"True\"; else echo \"False\"; fi"');
				$check1 = shell_exec('bash -c "if docker ps | grep \"davicillo12/basedatos:v1\" &>/dev/null; then echo \"True\"; else echo \"False\"; fi"');
				if (trim($check) == "True"){
					if (trim($check1) == "True"){
						$a = ["estado" => True,"estado1" => True]; // Funciona las 2
						echo json_encode($a);
					}else{
						$a = ["estado" => True,"estado1" => False]; // Funciona solamente davicillo12/sqlinjection:v7
						echo json_encode($a);
					}
				}
				else {
					if (trim($check1) == "True"){
						$a = ["estado" => False,"estado1" => True]; // Funciona solamente davicillo12/basedatos:v1
						echo json_encode($a);
					}else{
						$a = ["estado" => False,"estado1" => False]; // No funciona ninguna
						echo json_encode($a);
					}
				}
			}
			if ($_POST['accion'] == "reiniciar") {
				exec('bash -c "docker stop basedatos"');
				exec('bash -c "docker stop sqlinjection"');
				exec('bash -c "docker rm basedatos"');
				exec('bash -c "docker rm sqlinjection"');
				exec('bash -c "bash basedatos.sh"');		
				exec('bash -c "docker run -p 8003:80 --net sql --ip 172.18.0.100 --name sqlinjection --hostname papas -d --link basedatos davicillo12/sqlinjection:v7"');
				exec('bash -c "docker exec sqlinjection service ssh start"');
				exec('bash -c "bash basedatos.sh"');
				sleep(1);
				$check = shell_exec('bash -c "if docker ps | grep \"davicillo12/sqlinjection:v7\" &>/dev/null; then echo \"True\"; else echo \"False\"; fi"');
				$check1 = shell_exec('bash -c "if docker ps | grep \"davicillo12/basedatos:v1\" &>/dev/null; then echo \"True\"; else echo \"False\"; fi"');
				if (trim($check) == "True"){
					if (trim($check1) == "True"){
						$a = ["estado" => True,"estado1" => True]; // Funciona las 2
						echo json_encode($a);
					}else{
						$a = ["estado" => True,"estado1" => False]; // Funciona solamente davicillo12/sqlinjection:v7
						echo json_encode($a);
					}
				}
				else {
					if (trim($check1) == "True"){
						$a = ["estado" => False,"estado1" => True]; // Funciona solamente davicillo12/basedatos:v1
						echo json_encode($a);
					}else{
						$a = ["estado" => False,"estado1" => False]; // No funciona ninguna
						echo json_encode($a);
					}
				}
			}
			if ($_POST['accion'] == "apagar") {
				exec('bash -c "docker stop basedatos"');
				exec('bash -c "docker stop sqlinjection"');
				sleep(1);
				$check = shell_exec('bash -c "if docker ps | grep \"davicillo12/sqlinjection:v7\" &>/dev/null; then echo \"True\"; else echo \"False\"; fi"');
				$check1 = shell_exec('bash -c "if docker ps | grep \"davicillo12/basedatos:v1\" &>/dev/null; then echo \"True\"; else echo \"False\"; fi"');
				if (trim($check) == "False"){
					if (trim($check1) == "False"){
						$a = ["estado" => False,"estado1" => False]; // Apagada las 2
						echo json_encode($a);
					}else{
						$a = ["estado" => False,"estado1" => True]; // Apagada solamente davicillo12/sqlinjection:v7
						echo json_encode($a);
					}
				}
				else {
					if (trim($check1) == "False"){
						$a = ["estado" => True,"estado1" => False]; // Apagada solamente davicillo12/basedatos:v1
						echo json_encode($a);
					}else{
						$a = ["estado" => True,"estado1" => True]; // Encendida las 2
						echo json_encode($a);
					}
				}	
				
			}
		}
		//Fuerza bruta
		if ($_POST['vuln'] == "bf") {
			if ($_POST['accion'] == "descargar") {
				exec('bash -c "docker network create --subnet=172.30.0.0/16 brute_force"');
				exec('sleep 1');
				//exec('bash -c "docker run -p 8004:80 --net brute_force --ip 172.30.0.5 --name brute_force --hostname tienda -d davicillo12/brute_force:v4"');
				$command = 'bash -c "docker run -p 8004:80 --net brute_force --ip 172.30.0.5 --name brute_force --hostname tienda -d davicillo12/brute_force:v4 >/dev/null 2>&1" & wait';
				
				// Abre el proceso y captura la salida
				$descriptorspec = array(
					0 => array('pipe', 'r'),  // Entrada estándar
					1 => array('pipe', 'w'),  // Salida estándar
					2 => array('pipe', 'w'),  // Salida de error
				);
				
				$process = proc_open($command, $descriptorspec, $pipes);
				
				if (is_resource($process)) {
					stream_set_blocking($pipes[1], 0); // Hace que la salida no bloquee el script
				
					while (!feof($pipes[1])) {
						echo fgets($pipes[1]); // Muestra la salida en tiempo real
						ob_flush();
						flush();
					}
				
					fclose($pipes[1]);
				
					// Espera a que el proceso termine
					$return_value = proc_close($process);
				}
				exec('sleep 1');
				exec('bash -c "docker exec brute_force service ssh start"');
				sleep(2);				
				$check = shell_exec('bash -c "if docker ps | grep \"davicillo12/brute_force:v4\" &>/dev/null; then echo \"True\"; else echo \"False\"; fi"');
				if (trim($check) == "True"){
					$a = ["estado" => True];
					echo json_encode($a);
				}
				else {
					$a = ["estado" => False];
					echo json_encode($a);
				}
			}
			if ($_POST['accion'] == "encender") {
				exec('bash -c "docker start brute_force"');
				exec('bash -c "docker exec brute_force service ssh start"');
				sleep(1);
				
				$check = shell_exec('bash -c "if docker ps | grep \"davicillo12/brute_force:v4\" &>/dev/null; then echo \"True\"; else echo \"False\"; fi"');
				if (trim($check) == "True"){
					$a = ["estado" => True];
					echo json_encode($a);
				}
				else {
					$a = ["estado" => False];
					echo json_encode($a);
				}
			}
			if ($_POST['accion'] == "reiniciar") {
				exec('bash -c "docker stop brute_force"');
				exec('bash -c "docker rm brute_force"');
				exec('bash -c "docker run -p 8004:80 --net brute_force --ip 172.30.0.5 --name brute_force --hostname tienda -d davicillo12/brute_force:v4"');
				exec('bash -c "docker exec brute_force service ssh start"');
				sleep(1);
				
				$check = shell_exec('bash -c "if docker ps | grep \"davicillo12/brute_force:v4\" &>/dev/null; then echo \"True\"; else echo \"False\"; fi"');
				if (trim($check) == "True"){
					$a = ["estado" => True];
					echo json_encode($a);
				}
				else {
					$a = ["estado" => False];
					echo json_encode($a);
				}
			}
			if ($_POST['accion'] == "apagar") {
				exec('bash -c "docker stop brute_force"');
				$check = shell_exec('bash -c "if docker ps | grep \"davicillo12/brute_force:v4\" &>/dev/null; then echo \"True\"; else echo \"False\"; fi"');
				sleep(1);
				if (trim($check) == "False"){
					$a = ["estado" => False];
					echo json_encode($a);
				
				}
				else {
					$a = ["estado" => True];
					echo json_encode($a);
				}
			}
		}
	}
	else {	
		$a = ["estado" => "error2222", "vulne" => $_POST['vuln'], "acc0" => $_POST['accion']];
		echo json_encode($a);
	}
?>
