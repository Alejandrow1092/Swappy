function mostrarCuadro(bandera){
	if (bandera === 1) {
		document.getElementById("window-notice").style.display = "none";
	} else{
		document.getElementById("window-notice").style.display = "flex";
	}
}

function eliminar(codigo){
	$.ajax({
	    type:"POST", // la variable type guarda el tipo de la peticion GET,POST,..
	    url:"eliminarInt.php", //url guarda la ruta hacia donde se hace la peticion
	    data:{codigo_int: codigo}, // data recive un objeto con la informacion que se enviara al servidor
	    success: function(datos){ //success es una funcion que se utiliza si el servidor retorna informacion
	        if(datos !== ""){
	        	console.log(datos);
		        location.href = 'home.php';
			}
	    }
	});
}

function salir(codigo, id){
	$.ajax({
	    type:"POST", // la variable type guarda el tipo de la peticion GET,POST,..
	    url:"salirInt.php", //url guarda la ruta hacia donde se hace la peticion
	    data:{codigo_int: document.getElementById("codigo_int").value, id_usuario: id}, // data recive un objeto con la informacion que se enviara al servidor
	    success: function(datos){ //success es una funcion que se utiliza si el servidor retorna informacion
	        if(datos !== ""){
	        	console.log(datos)
		        location.href = 'home.php';
			}
	    }
	});
}

function obtenerAmigos(bandera){
	$.ajax({
	    type:"POST", // la variable type guarda el tipo de la peticion GET,POST,..
	    url:"obtenerAmigos.php", //url guarda la ruta hacia donde se hace la peticion
	    data:{codigo_int: document.getElementById("codigo_int").value}, // data recive un objeto con la informacion que se enviara al servidor
	    success: function(datos){ //success es una funcion que se utiliza si el servidor retorna informacion
	        if(datos !== ""){
		        let obj = JSON.parse(datos);
		        let ul = document.getElementById("lista_amigos");
		        for (let i = 0; i < obj.length; i++) {

		        	let li = document.createElement("li");
		        	li.id = "A"+obj[i].id;
		        	let label = document.createElement("label");
		        	let nodo = document.createTextNode(obj[i].nombre + " " + obj[i].apellidos);
		        	label.appendChild(nodo);
		        	li.appendChild(label);
		        	if(bandera === 1){
		        		let buttonA = document.createElement("button");
			        	buttonA.className = "botonInvitar";
			        	buttonA.addEventListener("click", function(){invitarInt(obj[i].id);}, false);
			        	let nodoBotonA = document.createTextNode("Invitar");
			        	buttonA.appendChild(nodoBotonA);
			        	li.appendChild(buttonA);
		        	}
		        	ul.appendChild(li);
		        }
			}
	    }
	});
}

function obtenerParticipantes(codigo, bandera){
	$.ajax({
	    type:"POST", // la variable type guarda el tipo de la peticion GET,POST,..
	    url:"obtenerParticipantes.php", //url guarda la ruta hacia donde se hace la peticion
	    data:{codigo_int: codigo}, // data recive un objeto con la informacion que se enviara al servidor
	    success: function(datos){ //success es una funcion que se utiliza si el servidor retorna informacion
	        if(datos !== ""){
		        let obj = JSON.parse(datos);
		        let ul = document.getElementById("lista_participantes");
		        for (let i = 0; i < obj.length; i++) {
		        	let li = document.createElement("li");
		        	li.id = "P"+obj[i].id;
		        	let label = document.createElement("label");
		        	let nodo = document.createTextNode(obj[i].nombre + " " + obj[i].apellidos);
		        	label.appendChild(nodo);
					li.appendChild(label);
		        	if(bandera){
		        		let buttonA = document.createElement("button");
			        	buttonA.className = "botonInvitar";
			        	buttonA.addEventListener("click", function(){eliminarP(obj[i].id);}, false);
			        	let nodoBotonA = document.createTextNode("Eliminar");
		        		buttonA.appendChild(nodoBotonA);
		        		li.appendChild(buttonA);
		        	}
		        	ul.appendChild(li);
		        }
			}
	    }
	});
}

function invitarInt(id){
	$.ajax({
	    type:"POST", // la variable type guarda el tipo de la peticion GET,POST,..
	    url:"invitarInt.php", //url guarda la ruta hacia donde se hace la peticion
	    data:{codigo: document.getElementById("codigo_int").value, id_usuario: id}, // data recive un objeto con la informacion que se enviara al servidor
	    success: function(datos){ //success es una funcion que se utiliza si el servidor retorna informacion
	    	console.log(datos);
	        let obj = JSON.parse(datos);
	        document.getElementById("A"+id).style.display = "none";
	        /*if(datos !== ""){
		        let obj = JSON.parse(datos);
		        document.getElementById("estado").value = obj[0].estado;
			} else{
				document.getElementById("estado").value = "error";
			}*/
			console.log(obj[0].estado);
	    }
	});
}

function obtenerInvitados(){
	$.ajax({
	    type:"POST", // la variable type guarda el tipo de la peticion GET,POST,..
	    url:"obtenerInvitados.php", //url guarda la ruta hacia donde se hace la peticion
	    data:{codigo_int: document.getElementById("codigo_int").value}, // data recive un objeto con la informacion que se enviara al servidor
	    success: function(datos){ //success es una funcion que se utiliza si el servidor retorna informacion
	        if(datos !== ""){
		        let obj = JSON.parse(datos);
		        let ul = document.getElementById("lista_invitados");
		        for (let i = 0; i < obj.length; i++) {

		        	let li = document.createElement("li");
		        	li.id = "I"+obj[i].id;
		        	let label = document.createElement("label");
		        	let nodo = document.createTextNode(obj[i].nombre + " " + obj[i].apellidos);
		        	label.appendChild(nodo);
					li.appendChild(label);
		        	ul.appendChild(li);
		        }
			}
	    }
	});
}

function eliminarP(id){
	$.ajax({
	    type:"POST", // la variable type guarda el tipo de la peticion GET,POST,..
	    url:"eliminarPart.php", //url guarda la ruta hacia donde se hace la peticion
	    data:{codigo: document.getElementById("codigo_int").value, id_usuario: id}, // data recive un objeto con la informacion que se enviara al servidor
	    success: function(datos){ //success es una funcion que se utiliza si el servidor retorna informacion
	    	console.log(datos);
	        let obj = JSON.parse(datos);
	        document.getElementById("P"+id).style.display = "none";
	        /*if(datos !== ""){
		        let obj = JSON.parse(datos);
		        document.getElementById("estado").value = obj[0].estado;
			} else{
				document.getElementById("estado").value = "error";
			}*/
			console.log(obj[0].estado);
	    }
	});
}

function seleccionar(id){
	let radio = document.getElementById("radio"+(id-1));
	radio.value = id;
}

function seleccionarR(id){
	let input = document.getElementById("valorRegalo");
	input.value = id;
}