document.getElementById('formulario-registro').addEventListener('submit', function(event) {
    event.preventDefault();
    const formData = new FormData(this);
    fetch('registrar_cliente.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            alert(data.error);
        } else {
            mostrarBoleta(data);
        }
    })
    .catch(error => console.error('Error:', error));
});

function mostrarBoleta(data) {
    const ticketContent = `
        <p><strong>Nombre del Negocio:</strong> ${data.nombre_negocio}</p>
        <p><strong>Número de Ticket:</strong> ${data.numero_ticket}</p>
        <p><strong>Nombre:</strong> ${data.nombre}</p>
        <p><strong>DPI:</strong> ${data.dpi}</p>
        <p><strong>Fecha de Creación:</strong> ${data.fecha_creacion}</p>
        <p><strong>Encuesta:</strong> <br><img src="${data.qr_ruta}" alt="Código QR para encuesta"></p>
    `;
    document.getElementById('ticketContent').innerHTML = ticketContent;
    const ticketModal = new bootstrap.Modal(document.getElementById('ticketModal'));
    ticketModal.show();
}

function imprimirBoleta() {
    const printContent = document.getElementById('ticketContent').innerHTML;
    const originalContent = document.body.innerHTML;
    document.body.innerHTML = printContent;
    window.print();
    document.body.innerHTML = originalContent;
    location.reload();  // Recargar la página después de imprimir
}


//script para obtener los clientes 
function actualizarClientes() {
    fetch('obtener_clientes.php')
    .then(response => response.text())
    .then(data => {
        document.getElementById('clientes').innerHTML = data;
    })
    .catch(error => console.error('Error:', error));
}

function atenderCliente(id) {
    fetch('atender_cliente.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'id=' + id
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            actualizarClientes();
        } else {
            alert('Error al atender al cliente: ' + data.error);
        }
    })
    .catch(error => console.error('Error:', error));
}

// Actualizar la lista de clientes automáticamente al cargar la página
document.addEventListener('DOMContentLoaded', (event) => {
    actualizarClientes();
});
