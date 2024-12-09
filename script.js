//pop up create content
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("add").addEventListener("click", function () {
        document.querySelector(".popup-create").style.display = "flex";
    });
});

//pop up update content
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".update").forEach(function(button) {
        button.addEventListener("click", function() {
            const username = this.closest('tr').querySelector('td:nth-child(2)').textContent;

            // Populate the edit fields
            document.getElementById('edit_username_hidden').value = username; // Store the username
            document.getElementById('edit_username').value = username; // Populate the input field for editing
            document.getElementById('edit_password').value = ''; // Clear the password field

            // Show the edit popup
            document.querySelector(".popup-update").style.display = "flex"; 
        });
    });
});

function closePopup() {
    const popup = document.querySelector(".popup-create");
    setTimeout(() => {
        popup.style.display = "none"; // Hide the popup after animation
    }, 300); // Match the duration of the fade-out effect
}
//pop up delete content
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("delete").addEventListener("click", function () {
        document.querySelector(".popup-delete").style.display = "flex";
    });
});

// function to close the popup
function closePopup() {
    document.querySelector(".popup-create").style.display = "none";
    document.querySelector(".popup-update").style.display = "none";
    document.querySelector(".popup-delete").style.display = "none";
}

//function for adding more options into the questions
//no more needed because its advance level
// function addOption() {
//     const optionsContainer = document.getElementById("crud-option");
//     const newOptionDiv = document.createElement("div");
//     newOptionDiv.className = "option";
//     newOptionDiv.innerHTML = `
//     <table>
//         <tr>
//             <td style='width:20px'><label for="option1">Option:</label></td>
//             <td><input type="text" style='width:620px;' name="optionText[]" /></td>
//             <td style='width:50;'><label for="isCorrect1">Correct Answer?</label></td>
//             <td><input type="checkbox" name="isCorrect[]" value="1"></td>
//             <td><button style='width:100px; margin-left: 20px;'>Remove</button></td>
//         </tr>
//     </table>
// `;
//     optionsContainer.appendChild(newOptionDiv);
// }

//for 
function questionOption() {
    
    document.getElementById('questionForm').addEventListener('submit', function(event) {
        const options = document.querySelectorAll('input[name="optionTexts[]"]');
        const filledOptions = Array.from(options).filter(option => option.value.trim() !== '');
        
        if (filledOptions.length < 2) {
            event.preventDefault(); // Prevent form submission
            document.getElementById('error').textContent = "Error: You must provide at least two options.";
            document.getElementById('error').style.display = "block";
        } else {
            document.getElementById('error').style.display = "none"; // Hide error message if valid
        }
    });
}
