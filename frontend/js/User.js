const SERVERIP = 'http://localhost:8080/backend'; // Asegúrate de ajustar el IP del servidor si es necesario

export default class User {
    constructor() {
        // Aquí puedes inicializar propiedades de la clase si es necesario
    }

    getUserById(userId) {
        return new Promise((resolve, reject) => {
            try {
                const userData = {
                    id: userId
                };

                const config = {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        values: userData,
                        uri: 'getUserById'
                    }),
                };

                fetch(`${SERVERIP}/public/index.php`, config)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (typeof data === "object") {
                            resolve(data);
                        } else {
                            throw new Error(data);
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        reject(error);
                    });
            } catch (error) {
                console.error(error.message);
                reject(error);
            }
        });
    }

    // Puedes agregar más métodos relacionados con el usuario aquí
}