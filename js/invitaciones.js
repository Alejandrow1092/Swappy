function responderA(idsol, idamigo, resp){
	$.ajax({
	    type:"POST", // la variable type guarda el tipo de la peticion GET,POST,..
	    url:"responderSolicitud.php", //url guarda la ruta hacia donde se hace la peticion
	    data:{id_sol: idsol, id_amigo: idamigo, respuesta: resp}, // data recive un objeto con la informacion que se enviara al servidor
	    success: function(datos){ //success es una funcion que se utiliza si el servidor retorna informacion
	        if(datos !== ""){
		        let obj = JSON.parse(datos);
		        if(obj[0].estado === "aceptado"){
		        	document.getElementById("A"+idsol).style.display = "none";
		        } else if(obj[0].estado === "ok"){
		        	document.getElementById("A"+idsol).style.display = "none";
		        } else{
		        	console.log(obj[0].estado);
		        }
			} else{
				console.log(obj[0].estado + "no devolvio");
			}
	    }
	});
}

function responderI(idsol, codigo, resp){
	$.ajax({
	    type:"POST", // la variable type guarda el tipo de la peticion GET,POST,..
	    url:"responderSolicitudInt.php", //url guarda la ruta hacia donde se hace la peticion
	    data:{id_sol: idsol, codigo_int: codigo, respuesta: resp}, // data recive un objeto con la informacion que se enviara al servidor
	    success: function(datos){ //success es una funcion que se utiliza si el servidor retorna informacion
	        if(datos !== ""){
	        	console.log(datos)
		        let obj = JSON.parse(datos);
		        if(obj[0].estado === "aceptado"){
		        	document.getElementById("I"+idsol).style.display = "none";
		        } else if(obj[0].estado === "ok"){
		        	document.getElementById("I"+idsol).style.display = "none";
		        } else{
		        	console.log(obj[0].estado);
		        }
			} else{
				console.log(obj[0].estado + "no devolvio");
			}
	    }
	});
}