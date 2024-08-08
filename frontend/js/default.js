
const greetings = document.querySelectorAll('.greeting');
const registers = document.querySelectorAll('.register');
var registerStep = 0;
const inputContainers = document.querySelectorAll('.inputContainer');
const inputs = document.querySelectorAll('input');
const header = document.getElementById('header');
const container = document.getElementById('container');
const backButton = document.getElementById('backButton');
const nextButton = document.getElementById('nextButton');
const finishButton = document.getElementById('finishButton');

//FOCUS

inputs.forEach(input => {
	input.addEventListener('focus', (event) => {
		inputContainers.forEach(inputContainer => {
			if (!inputContainer.contains(event.target)) {
				inputContainer.classList.add('hidden');
			} else {
				event.target.classList.remove('error');
			}
		});
		header.classList.add('hidden');
			container.style.flexGrow = 0;
	});

	input.addEventListener('blur', () => {
        inputContainers.forEach(inputContainer => {
            inputContainer.classList.remove('hidden');
        });
        header.classList.remove('hidden');
        container.style.flexGrow = 1;
	});

});



//PAGINATION
if (finishButton != null) {
	finishButton.addEventListener('click', (event) => {
		if (checkAllInputs()) {
			console.log("finish");
		}
	});
}

if (nextButton != null) {
	nextButton.addEventListener('click', (event) => {
		if (checkInputs()) {
			updateStep("next");
		}
		
	});
}

if (backButton != null) {
	backButton.addEventListener('click', (event) => {
		updateStep("back");
	});
}


function updateStep(action) {
	greetings[registerStep].classList.add('hidden');
	registers[registerStep].classList.add('hidden');

	if (action == "next") {
		if (registerStep + 1 < registers.length) {
			registerStep++;
			backButton.classList.remove('invisible');
		} else {
			console.log("yaaa");
		}
	} else {
		if (registerStep > 0) {
			registerStep--;
			if (registerStep == 0) {
				backButton.classList.add('invisible');
			}
		}
	}

	greetings[registerStep].classList.remove('hidden');
	registers[registerStep].classList.remove('hidden');



	//DECORATION

	header.classList.remove('backgroundGreen');
	header.classList.remove('backgroundBlue');
	header.classList.remove('backgroundYellow');
	header.classList.remove('backgroundRed');

	switch (registerStep) {
		case 0:
			header.classList.add('backgroundGreen');
		break;
		case 1:
			header.classList.add('backgroundBlue');
		break;
		case 2:
			header.classList.add('backgroundYellow');
		break;
		case 3:
			header.classList.add('backgroundRed');
		break;
	}

}


function checkInputs() {
    const visibleRegister = document.querySelector('.register:not(.hidden)');
    if (!visibleRegister) {
        console.log('No visible register found.');
        return false;
    }

    const inputs = visibleRegister.querySelectorAll('input');
    let allInputsFilled = true;

    inputs.forEach(input => {
    	input.classList.remove('error');
    	void input.offsetWidth;
        if (!input.value.trim()) {
            input.classList.add('error');
            allInputsFilled = false;
        }
    });

    console.log(allInputsFilled ? 'All inputs are filled.' : 'Some inputs are empty.');
    return allInputsFilled;
}

function checkAllInputs() {
    const inputs = document.querySelectorAll('input');
    let allInputsFilled = true;

    inputs.forEach(input => {
    	input.classList.remove('error');
    	void input.offsetWidth;
        if (!input.value.trim()) {
            input.classList.add('error');
            allInputsFilled = false;
        }
    });

    console.log(allInputsFilled ? 'All inputs are filled.' : 'Some inputs are empty.');
    return allInputsFilled;
}
