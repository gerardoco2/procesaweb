const bancosSelect = document.getElementById('bancosSelect');

async function getBancos() {

    bancos = [];
  try {

    const options = {
        method: 'POST',
        headers: {
        'Content-Type': 'application/json',
        }
    };


   const response = await fetch('https://tpmovil.bt.gob.ve/RestTesoro_C2P/com/services/bancos', options)
   .then( response => {
    return response.json();
   })
   .then( data => data);

    const bancos =  response; 

    bancos.forEach(banco => {
      const option = document.createElement('option');
      option.value = banco.codigo; 
      option.textContent = banco.nombre; 
      bancosSelect.appendChild(option);
    });

  } catch (error) {
    console.error('Error:', error);
    
  }
}



async function procesarPago(data, lineaDeCuota) {


// para prueba

//cedula_asoc_logged = document.getElementById("cedula_asoc").value.trim();
// ref = '123456';

// let dataCuota = {
//     "cedula": cedula_asoc_logged,
//     "lineaCuota" : parseInt(coutaSelected.value)-1,
//     "referencia" : ref
// };

// fetch("https://capunefm.com/index.php/procesapago", {
//     'method': 'POST',
//     'headers': {
//     "Content-Type": "application/json;  charset=uft-8",
//     },
//     "body": JSON.stringify(dataCuota)
//     });

//     const errorMessage = document.getElementById('alert'); 
//     errorMessage.style.display = 'none';

//     document.getElementById('form-container').style.display = 'none';
//     document.getElementById('success-container').style.display = 'block';

//fin prueba


    const monto = document.getElementById('monto');

   const response = await fetch("https://tpmovil.bt.gob.ve/RestTesoro_C2P/com/services/botonDePago/pago", {
    method: "POST",
    body: JSON.stringify( data ),
    headers: {
        'Content-Type': 'application/json'
    }
    }).then(response => response.json())
    .then(
        data =>{
            if(data.codres == "C2P0000") {
                console.log("transaccion aprobada",data);
               try{
                    // enviar la linea a procesa 

                    cedula_asoc_logged = document.getElementById("cedula_asoc").value.trim();
                    ref = data.referencia;

                    let dataCuota = {
                        "cedula": cedula_asoc_logged,
                        "lineaCuota" : parseInt(coutaSelected.value)-1,
                        "referencia" : ref
                    };

                    fetch("https://capunefm.com/index.php/procesapago", {
                        'method': 'POST',
                        'headers': {
                        "Content-Type": "application/json;  charset=uft-8",
                        },
                        "body": JSON.stringify(dataCuota)
                        });
                }catch (error){
                    // alert("Se ha producido un error: ", error);
                }
                 const errorMessage = document.getElementById('alert'); 
                 errorMessage.style.display = 'none';

                document.getElementById('form-container').style.display = 'none';


                document.getElementById('refpago').value = data.referencia;
                document.getElementById('fechaPago').value = data.referencia;
                document.getElementById('success-container').style.display = 'block';
                
            }else{

                const errorMessage = document.getElementById('alert'); 
                errorMessage.style.display = 'block';
                errorMessage.textContent = data.descRes; 


                setTimeout(() => {
                    const errorMessage = document.getElementById('alert'); 
                    errorMessage.style.display = 'none';

                }, "5000");
            }
            
        } 
    )
}

function validateForm() {
    let isValid = true;
    const opcionApagar = document.getElementById('cuotaSelect');
    const opcionApagarError = document.getElementById('cuotaSelectError');
    const cedula = document.getElementById('cedula');
    const telefono = document.getElementById('telefono');
    const token = document.getElementById('token');
    const cedulaError = document.getElementById('cedulaError');
    const telefonoError = document.getElementById('telefonoError');
    const tokenError = document.getElementById('tokenError');
 

    // limpia mensajes de error
    cedulaError.textContent = '';
    telefonoError.textContent = '';
    tokenError.textContent = '';

    //valida couta
    if (opcionApagar.value === '') {
        opcionApagar.style.border = "1px solid red";
        //opcionApagarError.textContent = 'Selecciona una opcion para pagar.';
        isValid = false
    }

    // validar Cedula
    if (cedula.value.trim() === '') {
      cedulaError.textContent = 'La cedula es requerida.';
      isValid = false;
    } else if (isNaN(cedula.value)) {
      cedulaError.textContent = 'La cedula debe ser un número.';
      isValid = false;
    }

    // valida Telefono
    if (telefono.value.trim() === '') {
      telefonoError.textContent = 'El telefono es requerido.';
      isValid = false;
    } else if (isNaN(telefono.value)) {
      telefonoError.textContent = 'El telefono debe ser un número.';
      isValid = false;
    }

    // calida Token
    if (token.value.trim() === '') {
      tokenError.textContent = 'El token es requerido.';
      isValid = false;
    }

    return isValid;
}

const opcionAPagar = document.getElementById("cuotaSelect");
opcionAPagar.addEventListener('change', (event) => {
document.getElementById('monto').value = opcionAPagar.value;
});

const bancoSeleccionado = document.getElementById('bancosSelect');

const coutaSelected = document.getElementById("cuota_selected");

const opcionApagar = document.getElementById('cuotaSelect');
opcionAPagar.addEventListener('change', (event) => {
        console.log("opcion a pagar", opcionAPagar.options.selectedIndex);
        coutaSelected.value = opcionAPagar.options.selectedIndex;
    });
  // Add event listener to submit button
  const submitButton = document.getElementById('submit');
  submitButton.addEventListener('click', (event) => {
    event.preventDefault(); // Prevent default form submission

    const botonRegresar = document.getElementById('regresar');
    botonRegresar.addEventListener('click',(event) => {
        window.location.reload(); 
    });

  const botonImprimir = document.getElementById('imprimir');
  botonImprimir.addEventListener('click',(event) => {
    window.print();
  });

    if (validateForm()) {
        const monto = document.getElementById('monto');
 

        let data = { 
            "canal": "06",
            "celular": telefono.value.trim(),
            "banco": bancoSeleccionado.value.trim(),
            "RIF": "J301578970",
            "cedula": "V"+cedula.value.trim(),
            "monto": monto.value,
            "token": token.value.trim(),
            "concepto": opcionAPagar.options[opcionAPagar.selectedIndex].text,
            "codAfiliado":"010768",
            "comercio":""
        };


        document.getElementById('montoPagado').value = data.monto;
        document.getElementById('decPago').value = data.concepto;
        

        cedula_asoc_logged = document.getElementById("cedula_asoc").value.trim();

        let dataCuota = {
            "cedula": cedula_asoc_logged,
            "lineaCuota" : coutaSelected.value
        };

        procesarPago(data, dataCuota);
    }
 });

getBancos();
//procesarPago();