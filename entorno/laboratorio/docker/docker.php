<?php
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: PUT, GET, POST");
	header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
	if (isset($_POST['vuln']) && isset($_POST['accion'])) {
		if ($_POST['vuln'] == "lfi") {
			if ($_POST['accion'] == "descargar") {
				exec('docker network create --subnet=172.5.0.0/16 local_file_inclusion');
				exec('docker run -p 8000:80 --net local_file_inclusion --ip 172.5.0.5 --name lfi --hostname cuentos -d davicillo12/lfi:v4');
				exec('docker exec lfi service ssh start');
			}
			if ($_POST['accion'] == "encender") {
				exec('docker start lfi');
				exec('docker exec lfi service ssh start');
			}
			if ($_POST['accion'] == "reiniciar") {
				exec('docker stop lfi');
				exec('docker rm lfi');
				exec('docker run -p 8000:80 --net local_file_inclusion --ip 172.5.0.5 --name lfi --hostname cuentos -d davicillo12/lfi:v4');
				exec('docker exec lfi service ssh start');
			}
			if ($_POST['accion'] == "apagar") {
				exec('docker stop lfi');
			}
		}
		if ($_POST['vuln'] == "lp") {
			if ($_POST['accion'] == "descargar") {
				exec('docker network create --subnet=172.20.0.0/16 log_poisoning');
				exec('docker run -p 8001:80 --net log_poisoning --ip 172.20.0.10 --name log_poisoning --hostname marvel -d davicillo12/log_poisoning:v5');
				exec('docker exec log_poisoning rm -f /var/log/apache2/error.log');
				exec('docker exec log_poisoning rm -f /var/log/apache2/access.log');
				exec('docker exec log_poisoning service apache2 restart');
				exec('docker start log_poisoning');
				exec('docker exec log_poisoning service cron start');
				exec('docker start log_poisoning');
			}
			if ($_POST['accion'] == "encender") {
				exec('docker start log_poisoning');
			}
			if ($_POST['accion'] == "reiniciar") {
				exec('docker stop log_poisoning');
				exec('docker rm log_poisoning');
				exec('docker run -p 8001:80 --net log_poisoning --ip 172.20.0.10 --name log_poisoning --hostname marvel -d davicillo12/log_poisoning:v5');
				exec('docker exec log_poisoning rm -f /var/log/apache2/error.log');
				exec('docker exec log_poisoning rm -f /var/log/apache2/access.log');
				exec('docker exec log_poisoning service apache2 restart');
				exec('docker start log_poisoning');
				exec('docker exec log_poisoning service cron start');
				exec('docker start log_poisoning');
			}
			if ($_POST['accion'] == "apagar") {
				exec('docker stop log_poisoning');
			}
		}
		if ($_POST['vuln'] == "rfi") {
			if ($_POST['accion'] == "descargar") {
				exec('docker network create --subnet=172.21.0.0/16 remote_file_inclusion');
				exec('docker run -p 8002:80 --net remote_file_inclusion --ip 172.21.0.10 --name rfi --hostname urlvisitor -ti -d davicillo12/rfi:v2');
				exec('docker exec rfi service apache2 start');
			}
			if ($_POST['accion'] == "encender") {
				exec('docker start rfi');
				exec('docker exec rfi service apache2 start');
			}
			if ($_POST['accion'] == "reiniciar") {
				exec('docker stop rfi');
				exec('docker rm rfi');
				exec('docker run -p 8002:80 --net remote_file_inclusion --ip 172.21.0.10 --name rfi --hostname urlvisitor -ti -d davicillo12/rfi:v2');
				exec('docker exec rfi service apache2 start');
			}
			if ($_POST['accion'] == "apagar") {
				exec('docker stop rfi');
			}
		}

		//Sql Injection
		if ($_POST['vuln'] == "isql") {
			if ($_POST['accion'] == "descargar") {
				exec('docker network create --subnet=172.18.0.0/16 sql');
				exec('bash basedatos.sh');
				exec('docker run -p 8003:80 --net sql --ip 172.18.0.100 --name sqlinjection --hostname papas -d --link basedatos davicillo12/sqlinjection:v7');
				exec('docker exec sqlinjection service ssh start');
				exec('bash basedatos.sh');
			}
			if ($_POST['accion'] == "encender") {
				exec('docker start basedatos');
				exec('docker start sqlinjection');
			}
			if ($_POST['accion'] == "reiniciar") {
				exec('docker stop basedatos');
				exec('docker stop sqlinjection');
				exec('docker rm basedatos');
				exec('docker rm sqlinjection');
				exec('bash basedatos.sh');		
				exec('docker run -p 8003:80 --net sql --ip 172.18.0.100 --name sqlinjection --hostname papas -d --link basedatos davicillo12/sqlinjection:v7');
				exec('docker exec sqlinjection service ssh start');
				exec('bash basedatos.sh');
			}
			if ($_POST['accion'] == "apagar") {
				exec('docker stop basedatos');
				exec('docker stop sqlinjection');
				
			}
		}
		//Fuerza bruta
		if ($_POST['vuln'] == "bf") {
			if ($_POST['accion'] == "descargar") {
				exec('docker network create --subnet=172.30.0.0/16 brute_force');
				exec('docker run -p 8004:80 --net brute_force --ip 172.30.0.5 --name brute_force --hostname tienda -d davicillo12/brute_force:v4');
				exec('docker exec brute_force service ssh start');
			}
			if ($_POST['accion'] == "encender") {
				exec('docker start brute_force');
				exec('docker exec brute_force service ssh start');
			}
			if ($_POST['accion'] == "reiniciar") {
				exec('docker stop brute_force');
				exec('docker rm brute_force');
				exec('docker run -p 8004:80 --net brute_force --ip 172.30.0.5 --name brute_force --hostname tienda -d davicillo12/brute_force:v4');
				exec('docker exec brute_force service ssh start');
			}
			if ($_POST['accion'] == "apagar") {
				exec('docker stop brute_force');
				
			}
		}
	}
	
?>
