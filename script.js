//pop up create content
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("add").addEventListener("click", function () {
        document.querySelector(".popup-create").style.display = "flex";
    });
});

document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("update").addEventListener("click", function () {
        document.querySelector(".popup-update").style.display = "flex";
    });
});




//pop up update content
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll("update").forEach(function(button) {
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
function closePopup() {
    const popup = document.querySelector(".popup-update");
    setTimeout(() => {
        popup.style.display = "none"; // Hide the popup after animation
    }, 300); // Match the duration of the fade-out effect
}
//pop up delete content
// document.addEventListener("DOMContentLoaded", function () {
//     document.getElementById("delete").addEventListener("click", function () {
//         document.querySelector(".popup-delete").style.display = "flex";
//     });
// });

// function to close the popup
function closePopup() {
    document.querySelector(".popup-create").style.display = "none";
    document.querySelector(".popup-update").style.display = "none";
    //document.querySelector(".popup-delete").style.display = "none";
}

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




function showUpdatePopup() {
    // Show the update popup
    document.querySelector('.popup-update').style.display = 'block';
}

function closePopup() {
    // Hide the create popup
    document.querySelector('.popup-create').style.display = 'none';
    document.querySelector('.popup-update').style.display = 'none';

}

// Optional: Hide the popup when clicking outside of it
window.onclick = function(event) {
    const popup = document.querySelector('.popup-update');
    if (event.target === popup) {
        closePopup();
    }
};


//for edit user new
document.addEventListener("DOMContentLoaded", function () {
    // Select all edit buttons
    const editButtons = document.querySelectorAll(".edit-button");

    // Attach click event handler to each button
    editButtons.forEach(button => {
        button.addEventListener("click", function () {
            const userId = this.getAttribute("data-user-id");
            // Show the popup for editing
            document.querySelector(".popup-update").style.display = "flex";

            // Optionally, load user data into the popup here
            loadUserData(userId);
        });
    });
});

//edit subject
function loadSubjectData(userId) {
    // Implement logic to fetch user data by userId
    // For example, you might want to send an AJAX request to get user details
    alert("Load data for user ID: " + userId);
}


document.addEventListener('DOMContentLoaded', function() {
    // Select all edit buttons
    const editButtons = document.querySelectorAll('.edit-button');

    // Attach click event handler to each button
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            //const userId = this.getAttribute('data-subject-id');
            // Open your edit popup/modal here
            // For example:
            openEditPopup(subjectId);
        });
    });
});

// Example function to open the edit popup
function openEditPopup(subjectId) {
    // Logic to open the popup and load user data
    alert('Edit user with ID: ' + subjectId);
    // You can implement a modal or populate a form with user data here
}