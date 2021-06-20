#!/bin/bash

# Autor: David Ojeda Guijarro

#Despliega un entorno de contenedores donde puedas probar las vulnerabilidades web más comunes que puedes encontrar a la hora de comprometer un entrono empresarial

#Colors
greenColor="\e[0;32m\033[1m"
endColor="\033[0m\e[0m"
redColor="\e[0;31m\033[1m"
blueColor="\e[0;34m\033[1m"
yellowColor="\e[0;33m\033[1m"
purpleColor="\e[0;35m\033[1m"
turquoiseColor="\e[0;36m\033[1m"
grayColor="\e[0;37m\033[1m"

trap ctrl_c INT

function ctrl_c() {
	echo -e "\n\n\t${redColor}[*] Saliendo....${endColor}"
	tput cnorm
	exit 1
}

if [ $(id -u) -eq 0 ]; then
	tput civis
	clear
	echo -e "${greenColor}
              ,---------------------------,
              |  /---------------------\  |
              | |                       | |${endColor} \t\t ${purpleColor}Autor${endColor} ${greenColor}
              | |                       | |${endColor} \t  ${purpleColor}David Ojeda Guijarro${endColor} ${greenColor}
              | |      SchoolHack       | |
              | |                       | |
              | |                       | |
              |  \_____________________/  |
              |___________________________|
            ,---\_____     []     _______/------,
          /         /______________\           /|
        /___________________________________ /  |____
        |                                   |   |    )
        |  _ _ _                 [-------]  |   |   (
        |  o o o                 [-------]  |  /    _)_
        |__________________________________ |/     / / /
    /-------------------------------------/|      (___)
  /-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/ /
/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/ /
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~${endColor}  "
                                              

	echo -e "\n ${grayColor}[${greenColor}+${endColor}${grayColor}] Bienvenido a \"${redColor}SchoolHack${endColor}${grayColor}\".\n"
	sleep 1
	echo -e " ${grayColor}[*] SchoolHack es un proyecto que te permite desplegar en cuestión de segundos un entorno lleno de máquinas 
     objetivas, con la finalidad de que puedas comprometer la seguridad de dichas máquinas.  ${endColor}\n"
	sleep 2
	echo -e " ${grayColor}[*] Este script te desplegará un entorno web por el puerto 80. Este entorno presenta apartados uno te permitirá
     conocer y aprender sobre las vulnerabilidades más comunes que existen hoy en día y el otro es el \"laboratorio\", el cuál
     te permitirá desplegar las máquinas que quieras intentar comprometer. Se aconseja que si no tienes conocimientos previos
     sobre las vulnerabilidades se lea y se comprenda cada una de ellas antes de desplegarlas en el laboratorio.  ${endColor}\n"
	sleep 3
	
	if [ -d entorno ]; then
		echo -e " ${grayColor}[*] Comprobando requisitos necesarios${endColor}\n"
		apt update -y >/dev/null 2>&1
		which docker >/dev/null
		if [ $? -ne 0 ]; then
			echo -e " ${grayColor}[${redColor}!${endColor}${grayColor}] Docker no esta instalado${endColor}"
			echo "deb [arch=amd64 signed-by=/usr/share/keyrings/docker-archive-keyring.gpg] https://download.docker.com/linux/debian buster stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null

			echo -e " \t${turquoiseColor}>>${endColor} ${greenColor}Instalando...${endColor}"
			sudo apt-get install apt-transport-https ca-certificates curl gnupg lsb-release -y >/dev/null 2>&1
			curl -fsSL https://download.docker.com/linux/debian/gpg | sudo gpg --dearmor -o /usr/share/keyrings/docker-archive-keyring.gpg
			apt-get update -y >/dev/null 2>&1
			apt-get install docker-ce docker-ce-cli containerd.io -y >/dev/null 2>&1
		else
			echo -e " \t${grayColor}[${greenColor}+${endColor}${grayColor}] Docker${endColor}"

		fi

		which apache2 > /dev/null
		if [ $? -ne 0 ]; then
			echo -e " ${grayColor}[${redColor}!${endColor}${grayColor}] Apache2 no esta instalado${endColor}"
		echo -e " \t${turquoiseColor}>>${endColor} ${greenColor}Instalando...${endColor}"
			apt install apache2 -y >/dev/null 2>&1
		else
			echo -e " \t${grayColor}[${greenColor}+${endColor}${grayColor}] Apache2${endColor}"
		fi

		which php > /dev/null
		if [ $? -ne 0 ]; then
			echo -e " ${grayColor}[${redColor}!${endColor}${grayColor}] PHP no esta instalado${endColor}"
			echo -e " \t${turquoiseColor}>>${endColor} ${greenColor}Instalando...${endColor}"
			apt install php php-cgi php-mysqli php-pear php-mbstring libapache2-mod-php php-common php-phpseclib php-mysql -y >/dev/null 2>&1
		else
			echo -e " \t${grayColor}[${greenColor}+${endColor}${grayColor}] PHP${endColor}"
		fi

		echo -e "\n ${grayColor}[${greenColor}+${endColor}${grayColor}] Montando entorno de aprendizaje web${endColor}\n"
		rm -rf /var/www/html/*
		cp -r ./entorno/* /var/www/html/
		rm -rf entorno 
		chmod -R 777 /var/www/html
		usermod -aG docker -s /bin/bash www-data
		grep "SchoolHack.local" /etc/hosts >/dev/null 2>&1
		if [ $? -ne 0 ]; then
			echo "127.0.0.1		SchoolHack.local" >> /etc/hosts
		fi

		echo -e " ${grayColor}[*] Recuerde que debe levantar el servidor apache o ejecutar este script cada vez que quiera utilizar ${endColor}${redColor}SchoolHack${endColor}"
		sleep 3
		echo -e " ${grayColor}[*] Se necesita reiniciar el equipo para aplicar ciertos cambios${endColor}\n"
		pregunta=$(echo -e " ${grayColor}¿Desea reiniciar el equipo? (S / N): ${endColor}")
		read -p "$pregunta" opcion
		if [ $opcion == "s" ] || [ $opcion == "S" ]; then
			reboot
		fi
	
	else
		if [ $(service apache2 status | grep "Active\:" | awk {'print $2'}) == active ]; then
			echo -e " ${grayColor}[${greenColor}+${endColor}${grayColor}] El entorno web está montado y el servicio corriendo, puedes acceder por medio de esta url:${grayColor}\n"
			echo -e " \t${turquoiseColor}>>${endColor} ${purpleColor}http://SchoolHack.local${endColor}"
		else 
			echo -e "\n ${grayColor}[${redColor}!${endColor}${grayColor}] El entorno web está montado pero el servicio web no está corriendo, procederemos a levantarlo por ti${grayColor}\n"
			service apache2 start
			echo -e "\n ${grayColor}[${greenColor}+${endColor}${grayColor}] Servicio levantado con éxito, puedes acceder a${endColor} ${redColor}SchoolHack${endColor} ${grayColor}por medio de esta url:${grayColor}\n"
			echo -e " \t${turquoiseColor}>>${endColor} ${purpleColor}http://SchoolHack.local${endColor}"
		fi
		echo -e "\n"
	fi
	tput cnorm
else
	echo -e "\n${grayColor}[${redColor}!${endColor}${grayColor}] ${redColor}Ejecuta este script como superusuario.${endColor}\n" 
fi

