<script>
    $(document).ready(function() {
    // common validation
    document.addEventListener('keydown', function(event) {
        restrictCharacterLength(event, 'char-length-3', 3); // probability
        restrictCharacterLength(event, 'char-length-5', 5); // Employee range
        restrictCharacterLength(event, 'char-length-6', 6); // pincode
        restrictCharacterLength(event, 'char-length-7', 7); // order amount
        restrictCharacterLength(event, 'char-length-8', 8); // prefix
        restrictCharacterLength(event, 'char-length-10', 10); // prefix
        restrictCharacterLength(event, 'char-length-16', 16); // Tax GST no
        restrictCharacterLength(event, 'char-length-20', 20);
        restrictCharacterLength(event, 'char-length-30', 30);
        restrictCharacterLength(event, 'char-length-40', 40);
        restrictCharacterLength(event, 'char-length-50', 50);
        restrictCharacterLength(event, 'char-length-100', 100);
        restrictCharacterLength(event, 'char-length-120', 120);
        restrictCharacterLength(event, 'char-length-200', 200);
        restrictCharacterLength(event, 'char-length-1000', 1000);
        restrictCharacterLength(event, 'char-length-255', 255);
    });

    function restrictCharacterLength(event, className, maxLength) {
        if (event.target.classList.contains(className)) {
            if (event.target.value.length >= maxLength && event.key !== 'Backspace' && event.key !== 'Delete') {
                event.preventDefault();
            }
        }
    }


    function validateInput(event, regex) {
        if (!regex.test(event.key) && event.key !== 'Backspace' && event.key !== 'Delete') {
            event.preventDefault();
        }
    }


    document.addEventListener('keydown', function(event) {
        if (event.target.classList.contains('char-string')) {
            validateInput(event, /^[a-zA-Z\s]*$/);
        }

        if (event.target.classList.contains('number-input')) {
            validateInput(event, /^[0-9]+$/);
        }

        if (event.target.classList.contains('char-alphanumeric')) {
            validateInput(event, /^[a-zA-Z0-9\s]*$/);
        }
    });


    // enter alphbets , numbers and one special charecter
    document.addEventListener('keydown', function(event) {
        if (event.target.classList.contains('char-alphanumeric-spl')) {
            var alphanumericRegex = /^(?=.*[A-Za-z])(?!.*[!@#$%^&*(),.?":{}<>]{2})[^\r\n]+$/;
            var inputValue = event.target.value + event.key;

            if (!alphanumericRegex.test(inputValue) && event.key !== 'Backspace' && event.key !== 'Delete') {
                event.preventDefault();
            }
        }
    });

  // enter special charecter and string
    document.addEventListener('keydown', function (event) {
        if (event.target.classList.contains('char-special')) {
            var alphanumericRegex = /^[a-zA-Z0-9\s@#$%^&*()-_+=!?]+$/;
            if (!alphanumericRegex.test(event.key) && event.key !== 'Backspace' && event.key !== 'Delete') {
                event.preventDefault();
            }
        }
    });


// Get the textarea element
var alertContent = document.getElementById('adminalertContent');

// Add event listener for paste event
alertContent.addEventListener('paste', function(event) {
    var maxLength = 1000; // Maximum allowed characters
    var clipboardData = (event.clipboardData || window.clipboardData);
    var pastedData = clipboardData.getData('text/plain');
    var currentInput = event.target;
    var currentLength = currentInput.value.length;

    // Calculate remaining characters after paste
    var remainingLength = maxLength - currentLength;

    // If pasted content exceeds remaining length, truncate it
    if (pastedData.length > remainingLength) {
        var truncatedPastedData = pastedData.substring(0, remainingLength);
        document.execCommand('insertText', false, truncatedPastedData);
        event.preventDefault();
    }
});

// Add event listener for input event to handle manual input and trim if exceeds max length
alertContent.addEventListener('input', function(event) {
    var maxLength = 1000; // Maximum allowed characters
    var currentInput = event.target;
    var inputValue = currentInput.value;

    // Check if the input value exceeds the maximum length
    if (inputValue.length > maxLength) {
        // Trim the input value to fit within the limit
        currentInput.value = inputValue.substring(0, maxLength);
    }
});



});

</script>
