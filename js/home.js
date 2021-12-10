function mostrarCuadro(cuadroVisible, tipoCuadro){
	let	objeto = (tipoCuadro===1) ? document.getElementById("invitarAmigo") : document.getElementById("agregarCodigo");
	
	if(cuadroVisible === 1){
		objeto.style.display = "none";
	} else{
		objeto.style.display = "flex";
	}
}

function invitar(){
	$.ajax({
	    type:"POST", // la variable type guarda el tipo de la peticion GET,POST,..
	    url:"invitarAmigo.php", //url guarda la ruta hacia donde se hace la peticion
	    data:{correo: document.getElementById("correo").value}, // data recive un objeto con la informacion que se enviara al servidor
	    success: function(datos){ //success es una funcion que se utiliza si el servidor retorna informacion
	        if(datos !== ""){
		        let obj = JSON.parse(datos);
		        document.getElementById("estado").value = obj[0].estado;
			} else{
				document.getElementById("estado").value = "error";
			}
	    }
	});
}

let sw=0;

function mostrar(){
	if(sw===0){
		document.getElementById("agregarAmigos").style.visibility="visible";
		document.getElementById("unirseIntercambio").style.visibility="visible";
		document.getElementById("crearIntercambio").style.visibility="visible";
		sw=1;
	}
	else{
		document.getElementById("agregarAmigos").style.visibility="hidden";
		document.getElementById("unirseIntercambio").style.visibility="hidden";
		document.getElementById("crearIntercambio").style.visibility="hidden";
		sw=0;
	}
}

function unirse(){
	$.ajax({
	    type:"POST", // la variable type guarda el tipo de la peticion GET,POST,..
	    url:"unirseIntercambio.php", //url guarda la ruta hacia donde se hace la peticion
	    data:{codigo: document.getElementById("codigo").value}, // data recive un objeto con la informacion que se enviara al servidor
	    success: function(datos){ //success es una funcion que se utiliza si el servidor retorna informacion
	        if(datos !== ""){
	        	console.log(datos);
		        let obj = JSON.parse(datos);
		        document.getElementById("resultado").value = obj[0].estado;
			} else{
				document.getElementById("resultado").value = "error";
			}
	    }
	});
}