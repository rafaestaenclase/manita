const SERVERIP = 'http://localhost:8080/backend';

function getFormData(form) {
    event.preventDefault();
    const formData = new FormData(form);
    const postData = {};
    formData.forEach((value, key) => {
        postData[key] = value;
    });

    if (localStorage.getItem('logged_user_id') !== null && localStorage.getItem('logged_hash') !== null) {
        postData["loggedUserId"] = localStorage.getItem('logged_user_id');
        postData["loggedHash"] = localStorage.getItem('logged_hash');
    }

    return postData;
}

function callDatabase(uri, values) {
    return new Promise((resolve, reject) => {
        try {
            const config = {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    values: values,
                    uri: uri
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
                	console.log(data);
                    resolve(data);
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