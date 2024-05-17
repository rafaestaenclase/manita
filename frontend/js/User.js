class User {

    //EJEMPLOS NO FUNCIONALES
    login(userName, password) {
		return new Promise((resolve, reject) => {
            try {
            	if (userName.length < 4 || userName.length > 20) {
				    throw new Error('Username must be between 4 and 20 characters in length.');
				}

				if (password.length < 4 || password.length > 20) {
				    throw new Error('Password must be between 4 and 20 characters in length.');
				}

                const userData = {
                    name: userName,
                    password: password
                };

                const config = {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        userData: userData,
                        uri: 'loginUser'
                    }),
                };

                fetch(SERVERIP + "/public/index.php", config)
                    .then(response => response.json())
                    .then(data => {
                        if (typeof data === "object") {
                        	document.cookie = "userId=" + data.UserID + ";expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/;";
                        	document.cookie = "loginToken=" + data.LoginToken + ";expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/;";
                    		resolve("successful");
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

    isLogged() {
		return new Promise((resolve, reject) => {
            try {
                const config = {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        loginCookies: getLoginCookies(),
                        uri: 'isLogged'
                    }),
                };

                fetch(SERVERIP + "/public/index.php", config)
                    .then(response => response.json())
                    .then(data => {
                        if (data == "successful") {
                        	resolve(data);
                        } else {
                        	resolve("notLogged");
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
}