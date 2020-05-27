//	Funcion para crear el objeto para realizar una peticion asincrona
function getRequestObject() {
  // Asynchronous objec created, handles browser DOM differences
  if(window.XMLHttpRequest) {
    // Mozilla, Opera, Safari, Chrome IE 7+
    return (new XMLHttpRequest());
  }
  else if (window.ActiveXObject) {
    // IE 6-
    return (new ActiveXObject("Microsoft.XMLHTTP"));
  } else {
    // Non AJAX browsers
    return(null);
  }
}


function buscar(){
	//console.log("click en buscar");
   request=getRequestObject();
   if(request!=null)
   {
   	 let marca = document.getElementById("marca").value;
   	 let tipo_producto = document.getElementById("tipo_producto").value;
   	 let estatus_producto = document.getElementById("estatus_producto").value;
     var url='controlador_buscar_producto.php?marca='+ marca +'&tipo_producto='+ tipo_producto +'&estatus_producto='+ estatus_producto;
     request.open('GET',url,true);

     request.onreadystatechange =
        	function() {
            	if((request.readyState==4)){
                	// Se recibió la respuesta asíncrona, entonces hay que actualizar el cliente.
					// A esta parte comúnmente se le conoce como la función del callback
                 	//console.log("respuesta recibida");
                 	document.getElementById("resultados_consulta_productos").innerHTML = request.responseText;
                 } 	
        	};
     // Limpiar la petición
     request.send(null);
  }
}

//Evento que detonara la peticion asincrona
document.getElementById("buscar").onclick = buscar;