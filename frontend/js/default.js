
const inputContainers = document.querySelectorAll('.inputContainer');
const inputs = document.querySelectorAll('input, textarea');
const header = document.getElementById('header');
const container = document.getElementById('container');



//FADEOUT NAVEGATION
// Hacer que el cuerpo aparezca gradualmente al cargar la página
window.addEventListener('load', function() {
    document.body.classList.add('fade-in');  // Añadir la clase para desvanecer al cargar
});

// Capturar clics en enlaces o botones para hacer la transición al salir
document.querySelectorAll('a, button').forEach(function(element) {
    element.addEventListener('click', function(event) {
        event.preventDefault();  // Prevenir la acción inmediata

        // Obtener el valor del href o de la función onclick, si existe
        let href = this.getAttribute('href');
        if (!href) {
            let onclickAttr = this.getAttribute('onclick');
            if (onclickAttr) {
                href = onclickAttr.replace("location.href=", "").replace(/'/g, "").replace(";", "").trim();
            }
        }

        if (!href) {
            return;  // Salir si no es un enlace de navegación
        }

        document.body.classList.remove('fade-in');
        document.body.classList.add('fade-out');  

        // Redirigir después de la animación
        setTimeout(function() {
            window.location.href = href;
        }, 500);  // Ajustar al tiempo de la animación
    });
});


function setCookie(name, value) {
    const date = new Date();
    
    // Establecer la fecha de expiración muy lejana (por ejemplo, 100 años en el futuro)
    date.setFullYear(date.getFullYear() + 100); 

    document.cookie = name + "=" + (value || "") 
                    + "; expires=" + date.toUTCString() // Fecha de expiración
                    + "; path=/"  // La cookie estará disponible en todo el sitio web
                    + "; Secure"  // Solo permitir en conexiones HTTPS
                    //+ "; HttpOnly"  // Bloquear acceso desde JS (protegido contra XSS)
                    + "; SameSite=Strict";  // Prevenir ataques CSRF
}


//GET COOKIE FUNCTION
function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}

