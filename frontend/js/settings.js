//FONT SIZE SETTING
    fontSize = parseInt(getCookie('fontSize')) || 28;

    document.addEventListener('DOMContentLoaded', function() {

        document.querySelectorAll('*').forEach(element => {
            element.style.fontSize = fontSize + 'px';
        });

        document.getElementById('textSizeButton').style.fontSize = "32px";

        document.getElementById('textSizeButton').addEventListener('click', changeTextSize);
    });

    function changeTextSize() {
    	if (fontSize < 34) {
            fontSize += 4;
        } else {
            fontSize = 14;
        }

        document.querySelectorAll('*').forEach(element => {
            element.style.fontSize = fontSize + 'px';
        });

        document.getElementById('textSizeButton').style.fontSize = "32px";

        document.cookie = `fontSize=${fontSize}; path=/; max-age=31536000`;
    }
