	function getAllCities() {
	    callDatabase("getAllCities", {})
	        .then(response => {
	            console.log(response);
	            const container = document.getElementById('cityContainer');

	            if (response.length > 0) {
	                response.forEach(city => {
	                    // Creamos el div del post
	                    const cityDiv = document.createElement('div');
	                    cityDiv.classList.add('post', 'city');

	                    const cityNameSpan = document.createElement('span');
	                    cityNameSpan.textContent = city.name.toUpperCase();
	                    cityDiv.appendChild(cityNameSpan);

	                    // Agregamos el evento onclick
	                    cityDiv.onclick = function() {
	                        // Reseteamos el fondo de todos los elementos
	                        const allCities = container.querySelectorAll('.city');
	                        allCities.forEach(c => c.style.background = "white");

	                        // Cambiamos el fondo del elemento clicado
	                        this.style.background = "green";
	                    };

	                    container.appendChild(cityDiv);
	                });
	            }
	        });
	}

	getAllCities();