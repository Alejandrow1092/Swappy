function invitarInt(id){
	$.ajax({
	    type:"POST", // la variable type guarda el tipo de la peticion GET,POST,..
	    url:"invitarInt.php", //url guarda la ruta hacia donde se hace la peticion
	    data:{codigo: document.getElementById("codigo").value, id_usuario: id}, // data recive un objeto con la informacion que se enviara al servidor
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

function enviarInv(){
	let radios = document.getElementsByName("genero");
	let gen = (radios[0].checked) ? radios[0].value : radios[1].value;
	$.ajax({
	    type:"POST", // la variable type guarda el tipo de la peticion GET,POST,..
	    url:"invitarOPersona.php", //url guarda la ruta hacia donde se hace la peticion
	    data:{correo: document.getElementById("correo").value, nombre: document.getElementById("nombre").value, app: document.getElementById("app").value, genero: gen, codigo: document.getElementById("codigo").value},
	    success: function(datos){ //success es una funcion que se utiliza si el servidor retorna informacion
	    	console.log(datos);
	        let obj = JSON.parse(datos);
	        document.getElementById("estado").value = obj[0].estado;
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

function mostrarCuadro(cuadroVisible){
	let	objeto = document.getElementById("invitarAmigo");
	
	if(cuadroVisible === 1){
		objeto.style.display = "none";
	} else{
		objeto.style.display = "flex";
	}
}