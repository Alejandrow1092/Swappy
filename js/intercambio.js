let numTemas = 2;

function agregar(){
	let div = document.getElementById("listaTemas");
	let btnAgregar = document.getElementById("agregarTema");

	if(numTemas <= 3){
		let input = document.createElement("input");
		input.type = "text";
		input.name = "tema[]";
		input.id = "tema" + numTemas;
		input.placeholder = "tema " + numTemas;
		input.required = true;

		let radioButton = document.createElement("input");
		radioButton.type = "radio";
		radioButton.name = "eleccion";
		radioButton.id = "eleccion" + numTemas;
		let variable = numTemas;
		radioButton.addEventListener("click", function(){seleccionar(variable);}, false);

		div.appendChild(radioButton);
		div.appendChild(input);
		numTemas++;
	} else{
		document.getElementById("agregarTema").disabled = true;
	}
}

function seleccionar(id){
	let radioButton = document.getElementById("eleccion" + id);
	radioButton.value = id;
}