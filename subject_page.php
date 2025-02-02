<?php
include 'header.php';
include 'Includes/Subject_handler.php';
include 'Includes/auth.php';

$userId = $_SESSION['user_id'] ?? null;
$userName = $_SESSION['username'] ?? null;
$roleId = $_SESSION['role_id'] ?? null;
$roleName = $_SESSION['role_name'] ?? null;

function userHasPermission($roleName, $action)
{
    // Define permissions
    $permissions = [
        'Admin' => ['create', 'view', 'edit', 'delete'],
        'Teacher' => ['view'],
        'Student' => ['view'],
        // Add other roles as needed
    ];

    return isset($permissions[$roleName]) && in_array($action, $permissions[$roleName]);
}

$teacher = new Subject($db);
$teacherList = $teacher->teacherList();

$subject = new Subject($db);
$subjectList = $subject->getSubjectList();


if ($roleName === 'Teacher') {
    // Get only the subjects assigned to the teacher
    $subjectList = $subject->getAssignedSubjects($userId); // Function to retrieve assigned subjects
} else {
    // Get all subjects for normal users
    $subjectList = $subject->getSubjectList();
}
?>

<script type="text/javascript" src="script.js"></script>

<div class="popup-create">
    <div class="popup-content">
        <h1>Create new Subject</h1>
        <form action="Includes/Subject_handler.php" method="POST">
            <div class="form-content">

                <p>Subject name</p>
                <input type="text" name="subject_name" required>
                <p>Description</p>
                <input type="text" name="subject_text" required>

                <label>Select Teacher(s):</label><br>
                <div class="scroll">
                    <?php foreach ($teacherList as $teacher): ?>
                        <input type="checkbox" name="assigned_to[]" value="<?= $teacher['user_id'] ?>"><?= htmlspecialchars($teacher['username']) ?><br>
                    <?php endforeach; ?>
                </div>

            </div>
            <button type="submit" class="button1" name='submitted'>Add</button>
            <button type="button" class="button4" onclick="closePopup()">cancel</button>
        </form>
    </div>
</div>

<div class="popup-update" style="display:none;">
    <div class="popup-content">
        <h1>Update Subject</h1>
        <form action="Includes/get_subject.php" method="POST" id="edit_subject_form">
            <div class="form-content">
                <p>Subject name</p>
                <input type="text" name="subject_name" id="subject_name" required>
                <p>Description</p>
                <input type="text" name="subject_text" id="subject_text" required>
                <label>Select Teacher(s):</label><br>
                <div class="scroll">
                    <?php foreach ($teacherList as $teacher): ?>
                        <input type="checkbox" name="assigned_to[]" value="<?= $teacher['user_id'] ?>"><?= htmlspecialchars($teacher['username']) ?><br>
                    <?php endforeach; ?>
                </div>
            </div>
            <input type="hidden" name="subject_id" id="subject_id"> <!-- Ensure ID is correct -->
            <button type="submit" class="button1" name='updated'>Update</button>
            <button type="button" class="button4" onclick="closePopup()">Cancel</button>
        </form>
    </div>
</div>



<div class="overlay2">
    <section class="content-head3">
        <h1>
            Subjects
        </h1>
    </section>
</div>


<div class="wrapper">
    <div class="container">

        <?php
        if (userHasPermission($roleName, 'create')) {
            echo "<div class='centering'>
            <div class='search-content'>
                <div class='sorting'>
                    <button id='add' class='button2'>Add Subejct</button>
                </div>
            </div>
        </div>";
        }
        ?>

        <section class="content-body">
            <div class="subjects">

                <?php
                if (!empty($subjectList)) {
                    foreach ($subjectList as $subject) {
                        echo "<div class='sub-subjects'>
                        <div class='randomize'>
                                <h1>" . htmlspecialchars($subject['subject_name']) . "</h1>     
                            </div>
                            <div class='card-content'>
                                <h4>" . htmlspecialchars($subject['subject_text']) . "</h4>
                                <div class='button-container'>";

                        // Button to view the subject
                        echo "<button class='button1'><a href='quizzes_page.php?subject_id=" . htmlspecialchars($subject['subject_id']) . "'>View Subject</a></button>";

                        // Button to edit the subject (only if user has permission)
                        if (userHasPermission($roleName, 'edit')) {
                            echo "<input type='hidden' name='subject_id' value='" . htmlspecialchars($subject["subject_id"]) . "' />
                            <button class ='edit-button button3' data-subject-id='" .  htmlspecialchars($subject["subject_id"]) . "' style='margin-left: 10px;'>Edit</button>";
                        }


                        // Form to delete the subject (only if user has permission)
                        if (userHasPermission($roleName, 'delete')) {
                            echo "<form action='Includes/Subject_handler.php' method='post' style='display:inline;'>
                                    <input type='hidden' name='subject_id' value='" . htmlspecialchars($subject["subject_id"]) . "' />
                                    <button type='submit' class='button5' onclick='return confirm(\"Are you sure you want to delete this subject?\");'>X</button>
                                  </form>";
                        }

                        echo "</div>
                            </div>
                        </div>";
                    }
                } else {
                    echo "There are no subjects available, create a new one!";
                }
                ?>

            </div>
        </section>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.edit-button');

        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const subjectId = this.getAttribute('data-subject-id');
                fetch(`Includes/get_subject.php?subject_id=${subjectId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data) {
                            // Populate form fields
                            document.getElementById('subject_name').value = data.subject_name;
                            document.getElementById('subject_text').value = data.subject_text;
                            document.getElementById('subject_id').value = data.subject_id;

                            // Populate assigned teachers
                            const assignedTeachers = data.assigned_to || []; // Array of assigned teacher IDs
                            const checkboxes = document.querySelectorAll('input[name="assigned_to[]"]');

                            checkboxes.forEach(checkbox => {
                                checkbox.checked = assignedTeachers.includes(checkbox.value);
                            });

                            // Show popup
                            document.querySelector('.popup-update').style.display = 'flex';
                        }
                    })
                    .catch(error => console.error('Error fetching subject details:', error));
            });
        });
    });
</script>