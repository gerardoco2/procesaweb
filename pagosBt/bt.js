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

   /* if (!response.ok) {
      throw new Error(`API Error: ${response.statusText}`);
    }

    const data = await response.json();
    */
    //const data = await response.json();

    const bancos =  response; 


    /*const bancos = [
        {
            "codigo": "0163",
            "nombre": "BANCO DEL TESORO,C.A BANCO U"
        },
        {
            "codigo": "0172",
            "nombre": "BANCAMIGA BANCO MICROFINANCIE"
        },
        {
            "codigo": "0171",
            "nombre": "BANCO ACTIVO"
        },
        {
            "codigo": "0166",
            "nombre": "BANCO AGRICOLA DE VENEZUELA C"
        },
        {
            "codigo": "0128",
            "nombre": "BANCO CARONI, C.A BANCO UNIVE"
        },
        {
            "codigo": "0102",
            "nombre": "BANCO DE VENEZUELA, SACA BANC"
        },
        {
            "codigo": "0114",
            "nombre": "BANCO DEL CARIBE, C.A. BANCO"
        },
        {
            "codigo": "0115",
            "nombre": "BANCO EXTERIOR, C.A. BANCO UN"
        },
        {
            "codigo": "0105",
            "nombre": "BANCO MERCANTIL,C.A SACA BANC"
        },
        {
            "codigo": "0191",
            "nombre": "BANCO NACIONAL DE CREDITO C.A"
        },
        {
            "codigo": "0116",
            "nombre": "BANCO OCCIDENTAL DE DESCUENTO"
        },
        {
            "codigo": "0138",
            "nombre": "BANCO PLAZA, C.A"
        },
        {
            "codigo": "0108",
            "nombre": "BANCO PROVINCIAL,S.A BANCO UN"
        },
        {
            "codigo": "0137",
            "nombre": "BANCO SOFITASA BANCO UNIVERSA"
        },
        {
            "codigo": "0104",
            "nombre": "BANCO VENEZOLANO DE CREDITO,S"
        },
        {
            "codigo": "0168",
            "nombre": "BANCRECER SA BANCO DE DESARRO"
        },
        {
            "codigo": "0134",
            "nombre": "BANESCO BANCO UNIVERSAL, C.A"
        },
        {
            "codigo": "0177",
            "nombre": "BANFANB"
        },
        {
            "codigo": "0174",
            "nombre": "BANPLUS ENTIDAD DE AHORRO Y P"
        },
        {
            "codigo": "0157",
            "nombre": "DEL SUR BANCO UNIVERSAL C.A."
        },
        {
            "codigo": "0151",
            "nombre": "FONDO COMUN BANCO UNIVERSAL,C"
        },
        {
            "codigo": "0169",
            "nombre": "MI BANCO"
        },
        {
            "codigo": "0178",
            "nombre": "N58 BANCO DIGITAL"
        },
        {
            "codigo": "0156",
            "nombre": "100 % BANCO, BANCO COMERCIAL"
        }
    ] ;
*/

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

cedula_asoc_logged = document.getElementById("cedula_asoc").value.trim();
ref = '123456';

let dataCuota = {
    "cedula": cedula_asoc_logged,
    "lineaCuota" : pareseInt(coutaSelected.value)-1,
    "referencia" : ref
};

fetch("https://capunefm.com/index.php/procesapago", {
    'method': 'POST',
    'headers': {
    "Content-Type": "application/json;  charset=uft-8",
    },
    "body": JSON.stringify(dataCuota)
    });

//fin prueba


    const monto = document.getElementById('monto');

//    const response = await fetch("http://190.202.9.207:8080/RestTesoro_C2P/com/services/botonDePago/pago", {
//     method: "POST",
//     body: JSON.stringify( data ),
//     headers: {
//         'Content-Type': 'application/json'
//     }
//     }).then(response => response.json())
//     .then(
//         data =>{
//         //eliminar el !==
//             if(data.codres == "C2P0000") {
//                 console.log("transaccion aprobada",data);
//                try{
//                     // enviar la linea a mariano 
//                     fetch("pagoExitoso.php", {
//                     'method': 'POST',
//                     'headers': {
//                     "Content-Type": "application/json;  charset=uft-8",
//                     },
//                     "body": JSON.stringify(lineaDeCuota)
//                     });
//                 }catch (error){
//                     // alert("Se ha producido un error: ", error);
//                 }
//                  const errorMessage = document.getElementById('alert'); 
//                  errorMessage.style.display = 'none';

//                 document.getElementById('form-container').style.display = 'none';
//                 document.getElementById('success-container').style.display = 'block';
                
//             }else{

//                 const errorMessage = document.getElementById('alert'); 
//                 errorMessage.style.display = 'block';
//                 errorMessage.textContent = data.descRes; 


//                 setTimeout(() => {
//                     const errorMessage = document.getElementById('alert'); 
//                     errorMessage.style.display = 'none';

//                 }, "5000");
//             }
            
//         } 
//     )
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
            "codAfiliado":"104663",
            "comercio":""
        };

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