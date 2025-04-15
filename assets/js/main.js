// assets/js/main.js

document.addEventListener('DOMContentLoaded', function() {
    // Variables
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    
    // Evento para agregar productos al carrito
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');
            addToCart(productId);
        });
    });
    
    // Función para agregar al carrito
    function addToCart(productId) {
        alert('Producto agregado al carrito (ID: ' + productId + ')');
        // Aquí puedes implementar la lógica para agregar al carrito
        // Por ejemplo, usando AJAX para enviar al servidor
    }
    
    // Validación de formularios
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('error');
                } else {
                    field.classList.remove('error');
                }
            });
            
            if (!isValid) {
                event.preventDefault();
                alert('Por favor, completa todos los campos requeridos.');
            }
        });
    });
    
    // Mostrar/ocultar contraseña
    const passwordFields = document.querySelectorAll('input[type="password"]');
    passwordFields.forEach(field => {
        const toggleButton = document.createElement('button');
        toggleButton.type = 'button';
        toggleButton.textContent = 'Mostrar';
        toggleButton.classList.add('toggle-password');
        
        field.parentNode.appendChild(toggleButton);
        
        toggleButton.addEventListener('click', function() {
            if (field.type === 'password') {
                field.type = 'text';
                this.textContent = 'Ocultar';
            } else {
                field.type = 'password';
                this.textContent = 'Mostrar';
            }
        });
    });
});