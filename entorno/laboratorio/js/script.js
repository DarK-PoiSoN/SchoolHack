window.onload = () => {
	var sUsrAg = navigator.userAgent;

	if (sUsrAg.indexOf("Firefox") > -1) {
		document.getElementById("table").style.gridRowGap = "45px";
		document.getElementsByTagName("body")[0].style.overflow = "hidden"
		for(let x = 0; x < 5 ; x++){
		    document.getElementsByClassName("sub-table")[x].style.gridTemplateColumns = "25% repeat(6,11%) 20%";

		}
	} 

} 


function accion(x, y)
		{
			document.getElementById("cargando").style.display = "block";
			$.ajax({
				type:'POST', //aqui puede ser igual get
				url: 'http://schoolhack.local/laboratorio/docker/docker.php',//aqui va tu direccion donde esta tu funcion php
				data: {vuln:x,accion:y},//aqui tus datos
				success:function(data){
					//lfi
					if (x == "lfi") {
						if(y == "descargar") {
							
							document.getElementsByClassName("enlace")[0].innerText = "http://schoolhack.local:8000";
							document.getElementsByClassName("enlace")[0].setAttribute("href","http://schoolhack.local:8000");
							swal("Descargado", "La máquina se ha descargado correctamente", "success");
							document.getElementsByClassName('boton1')[0].value = "Descargado";
							document.getElementsByClassName('boton1')[0].disabled = true;
							
						}
						else if(y == "apagar") {
							document.getElementsByClassName("boton4")[0].disabled = true
							if(document.getElementsByClassName("boton2")[0].disabled == true){
								document.getElementsByClassName("boton2")[0].disabled = false
							}
							
							document.getElementsByClassName("enlace")[0].innerText = " ";
							document.getElementsByClassName("enlace")[0].removeAttribute("href");
							swal("Apagado", "La máquina se ha apagado", "success");
							
							
						}
						else if (y == "encender"){
							document.getElementsByClassName("boton2")[0].disabled = true
							if(document.getElementsByClassName("boton4")[0].disabled == true){
								document.getElementsByClassName("boton4")[0].disabled = false
							}

							
							document.getElementsByClassName("enlace")[0].innerText = "http://schoolhack.local:8000";
							document.getElementsByClassName("enlace")[0].setAttribute("href","http://schoolhack.local:8000");
							swal("Encendido", "La máquina se ha encendido", "success");
							

							
						
						}
						else{
							document.getElementsByClassName("boton2")[0].disabled = true
							document.getElementsByClassName("enlace")[0].innerText = "http://schoolhack.local:8000";
							document.getElementsByClassName("enlace")[0].setAttribute("href","http://schoolhack.local:8000");
							swal("Reinicio completado", "La máquina se ha reiniciado", "success");
							
						}
					}
					//Log poisoning
					else if (x == "lp") {
						if(y == "descargar") {
							
							document.getElementsByClassName("enlace")[1].innerText = "http://schoolhack.local:8001";
							document.getElementsByClassName("enlace")[1].setAttribute("href","http://schoolhack.local:8001");
							swal("Descargado", "La máquina se ha descargado correctamente", "success");
							document.getElementsByClassName('boton1')[1].value = "Descargado";
							document.getElementsByClassName('boton1')[1].disabled = true;
						}
						else if( y == "apagar") {
							document.getElementsByClassName("boton4")[1].disabled = true
							if(document.getElementsByClassName("boton2")[1].disabled == true){
								document.getElementsByClassName("boton2")[1].disabled = false
							}
							
							document.getElementsByClassName("enlace")[1].innerText = " ";
							document.getElementsByClassName("enlace")[1].removeAttribute("href");
							swal("Apagado", "La máquina se ha apagado", "success");
							
							
						}
						else if (y == "encender"){
							document.getElementsByClassName("boton2")[1].disabled = true
							if(document.getElementsByClassName("boton4")[1].disabled == true){
								document.getElementsByClassName("boton4")[1].disabled = false
							}

							
							document.getElementsByClassName("enlace")[1].innerText = "http://schoolhack.local:8001";
							document.getElementsByClassName("enlace")[1].setAttribute("href","http://schoolhack.local:8001");
							swal("Encendido", "La máquina se ha encendido", "success");
							

							
						
						}
						else{
							document.getElementsByClassName("boton2")[1].disabled = true
							document.getElementsByClassName("enlace")[1].innerText = "http://schoolhack.local:8001";
							document.getElementsByClassName("enlace")[1].setAttribute("href","http://schoolhack.local:8001");
							swal("Reinicio completado", "La máquina se ha reiniciado", "success");
							
						}
					}
					
					//Remote file inclusion
					else if (x == "rfi") {
						if(y == "descargar") {
							
							document.getElementsByClassName("enlace")[2].innerText = "http://schoolhack.local:8002";
							document.getElementsByClassName("enlace")[2].setAttribute("href","http://schoolhack.local:8002");
							swal("Descargado", "La máquina se ha descargado correctamente", "success");
							document.getElementsByClassName('boton1')[2].value = "Descargado";
							document.getElementsByClassName('boton1')[2].disabled = true;
						}
						else if(y == "apagar") {
							document.getElementsByClassName("boton4")[2].disabled = true
							if(document.getElementsByClassName("boton2")[2].disabled == true){
								document.getElementsByClassName("boton2")[2].disabled = false
							}
							
							document.getElementsByClassName("enlace")[2].innerText = " ";
							document.getElementsByClassName("enlace")[2].removeAttribute("href");
							swal("Apagado", "La máquina se ha apagado", "success");
						}
						else if (y == "encender"){
							document.getElementsByClassName("boton2")[2].disabled = true
							if(document.getElementsByClassName("boton4")[2].disabled == true){
								document.getElementsByClassName("boton4")[2].disabled = false
							}

							
							document.getElementsByClassName("enlace")[2].innerText = "http://schoolhack.local:8002";
							document.getElementsByClassName("enlace")[2].setAttribute("href","http://schoolhack.local:8002");
							swal("Encendido", "La máquina se ha encendido", "success");
						}
						else{
							document.getElementsByClassName("boton2")[2].disabled = true
							document.getElementsByClassName("enlace")[2].innerText = "http://schoolhack.local:8002";
							document.getElementsByClassName("enlace")[2].setAttribute("href","http://schoolhack.local:8002");
							swal("Reinicio completado", "La máquina se ha reiniciado", "success");
							
						}
					}
					//SQL Injection
					else if (x == "isql") {
						if(y == "descargar") {
							
							document.getElementsByClassName("enlace")[3].innerText = "http://schoolhack.local:8003";
							document.getElementsByClassName("enlace")[3].setAttribute("href","http://schoolhack.local:8003");
							swal("Descargado", "La máquina se ha descargado correctamente", "success");
							document.getElementsByClassName('boton1')[3].value = "Descargado";
							document.getElementsByClassName('boton1')[3].disabled = true;
						}
						else if(y == "apagar") {
							document.getElementsByClassName("boton4")[3].disabled = true
							if(document.getElementsByClassName("boton2")[3].disabled == true){
								document.getElementsByClassName("boton2")[3].disabled = false
							}
							
							document.getElementsByClassName("enlace")[3].innerText = " ";
							document.getElementsByClassName("enlace")[3].removeAttribute("href");
							swal("Apagado", "La máquina se ha apagado", "success");
						}
						else if (y == "encender"){
							document.getElementsByClassName("boton2")[3].disabled = true
							if(document.getElementsByClassName("boton4")[3].disabled == true){
								document.getElementsByClassName("boton4")[3].disabled = false
							}

							
							document.getElementsByClassName("enlace")[3].innerText = "http://schoolhack.local:8003";
							document.getElementsByClassName("enlace")[3].setAttribute("href","http://schoolhack.local:8003");
							swal("Encendido", "La máquina se ha encendido", "success");
						}
						else {
							document.getElementsByClassName("boton2")[3].disabled = true
							document.getElementsByClassName("enlace")[3].innerText = "http://schoolhack.local:8003";
							document.getElementsByClassName("enlace")[3].setAttribute("href","http://schoolhack.local:8003");
							swal("Reinicio completado", "La máquina se ha reiniciado", "success");
							
						}
					}
					
					//Fuerza bruta
					else if (x == "bf") {
						if(y == "descargar") {
							document.getElementsByClassName("enlace")[4].innerText = "http://schoolhack.local:8004";
							document.getElementsByClassName("enlace")[4].setAttribute("href","http://schoolhack.local:8004");
							swal("Descargado", "La máquina se ha descargado correctamente", "success");
							document.getElementsByClassName('boton1')[4].value = "Descargado";
							document.getElementsByClassName('boton1')[4].disabled = true;
							
						}
						else if(y == "apagar") {
							document.getElementsByClassName("boton4")[4].disabled = true
							if(document.getElementsByClassName("boton2")[4].disabled == true){
								document.getElementsByClassName("boton2")[4].disabled = false
							}
							
							document.getElementsByClassName("enlace")[4].innerText = " ";
							document.getElementsByClassName("enlace")[4].removeAttribute("href");
							swal("Apagado", "La máquina se ha apagado", "success");
						}
						else if (y == "encender"){
							document.getElementsByClassName("boton2")[4].disabled = true
							if(document.getElementsByClassName("boton4")[4].disabled == true){
								document.getElementsByClassName("boton4")[4].disabled = false
							}

							
							document.getElementsByClassName("enlace")[4].innerText = "http://schoolhack.local:8004";
							document.getElementsByClassName("enlace")[4].setAttribute("href","http://schoolhack.local:8004");
							swal("Encendido", "La máquina se ha encendido", "success");
						}
						else {
							document.getElementsByClassName("boton2")[4].disabled = true
							document.getElementsByClassName("enlace")[4].innerText = "http://schoolhack.local:8004";
							document.getElementsByClassName("enlace")[4].setAttribute("href","http://schoolhack.local:8004");
							swal("Reinicio completado", "La máquina se ha reiniciado", "success");
							
						}
					}
					document.getElementById("cargando").style.display = "none";
					
			},
				error:function(data){
					//lo que devuelve si falla docker.php
			}
			});
		}
