const citySelect = document.getElementById('bancosSelect');

async function getBancos() {
  try {
    const response = await fetch('http://190.202.9.207:8080/RestTesoro_C2P/com/services/bancos');

    if (!response.ok) {
      throw new Error(`API Error: ${response.statusText}`);
    }

    const data = await response.json();
    const bancos = data.bancos || data; // Adjust based on your API response structure

    bancos.forEach(banco => {
      const option = document.createElement('option');
      option.value = banco.codigo; // Set option value to banco ID
      option.textContent = banco.nombre; // Set option text content to city name
      citySelect.appendChild(option);
    });

  } catch (error) {
    console.error('Error:', error);
    // Handle errors by displaying an error message or disabling the select element
  }
}

getBancos();