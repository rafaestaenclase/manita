const SERVERIP = 'http://localhost:8080/backend';

function getFormData(form) {
    event.preventDefault();
    const formData = new FormData(form);
    const postData = {};
    formData.forEach((value, key) => {
        postData[key] = value;
    });
    
    return postData;
}

function callDatabase(uri, values) {
    return new Promise((resolve, reject) => {
        try {

            if (!values) {
                values = {};
            }

            values["loggedUserId"] = getCookie("userId");
            values["loggedHash"] = getCookie("loginHash");

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

                    if (response.status === 403) { //forbiden, Not logged
                        window.location.href = './register.html';
                        return;
                    }

                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    resolve(data);
                })
                .catch(error => {
                    //window.location.href = './register.html';
                    console.error(error);
                    reject(error);
                });
        } catch (error) {
            window.location.href = './register.html';
            console.error(error.message);
            reject(error);
        }
    });
}