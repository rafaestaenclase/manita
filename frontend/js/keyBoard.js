const spanishLetters = [
  'Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'I', 'O', 'P',
  'A', 'S', 'D', 'F', 'G', 'H', 'J', 'K', 'L', 'Ñ',
  '-', 'Z', 'X', 'C', 'V', 'B', 'N', 'M', '<-',
  ' '
];

// Variable para controlar la eliminación gradual
let deleteInterval;

// Función para agregar letras al teclado
function createKeyboard(keyboardContainer, outputField) {
  const fragment = document.createDocumentFragment();

  spanishLetters.forEach(letter => {
    const key = document.createElement('span');
    key.classList.add('key');

    const keyLetter = document.createElement('span');
    keyLetter.classList.add('keyLetter');

    if (letter === ' ') {
      key.classList.add('space');
      key.textContent = 'Espacio';
      key.addEventListener('touchend', (e) => {
        e.preventDefault(); // Prevenir comportamiento predeterminado
        addLetter(letter, outputField);
      });
    } else if (letter === '<-') {
      key.classList.add('delete');
      key.textContent = 'Borrar';

      // Eventos para eliminar gradualmente
      const startDelete = (e) => {
        e.preventDefault();
        deleteLastCharacter(outputField); // Borrar una vez al inicio
        deleteInterval = setInterval(() => deleteLastCharacter(outputField), 200); // Continuar borrando
      };

      const stopDelete = () => {
        clearInterval(deleteInterval); // Detener al soltar
      };

      key.addEventListener('touchstart', startDelete);
      key.addEventListener('touchend', stopDelete);
    } else {
      keyLetter.textContent = letter;
      key.appendChild(keyLetter); // Añadir el elemento interno para la letra
      key.addEventListener('touchend', (e) => {
        e.preventDefault();
        addLetter(letter, outputField);
      });
    }

    fragment.appendChild(key);
  });

  keyboardContainer.appendChild(fragment);
}

// Función para añadir una letra al campo de texto
function addLetter(letter, outputField) {
  outputField.value += letter;
  scrollToEnd(outputField);
}

// Función para borrar el último carácter
function deleteLastCharacter(outputField) {
  outputField.value = outputField.value.slice(0, -1);
  scrollToEnd(outputField);
}

// Función para desplazar el campo de texto al final
function scrollToEnd(outputField) {
  outputField.scrollLeft = outputField.scrollWidth;
  outputField.setSelectionRange(outputField.value.length, outputField.value.length);
}
