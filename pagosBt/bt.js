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


  /* const response = await fetch('http://190.202.9.207:8080/RestTesoro_C2P/com/services/bancos', options)
   .then( data => {
    return data.json();
   })
   .then( bancosApi => {
     bancos = bancosApi;
   }
   );
*/
   /* if (!response.ok) {
      throw new Error(`API Error: ${response.statusText}`);
    }

    const data = await response.json();
    */
   // const bancos = data.bancos || data; // Adjust based on your API response structure
    const bancos = [
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


    bancos.forEach(banco => {
      const option = document.createElement('option');
      option.value = banco.codigo; // Set option value to banco ID
      option.textContent = banco.nombre; // Set option text content to city name
      bancosSelect.appendChild(option);
    });

  } catch (error) {
    console.error('Error:', error);
    // Handle errors by displaying an error message or disabling the select element
  }
}

getBancos();