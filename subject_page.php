<?php
include 'header.php';
include 'Includes/Subject_handler.php';
include 'Includes/auth.php';

$userId = $_SESSION['user_id'] ?? null;
$userName = $_SESSION['user_id'] ?? null;
$roleId = $_SESSION['role_id'] ?? null;
$roleName = $_SESSION['role_name'] ?? null;

echo "User ID: " . htmlspecialchars($_SESSION['user_id']) . "<br>";
echo "Username: " . htmlspecialchars($_SESSION['username']) . "<br>";
echo "Role ID: " . htmlspecialchars($_SESSION['role_id']) . "<br>";
echo "Role: " . htmlspecialchars($_SESSION['role_name']) . "<br>";
//     echo "Username: " . htmlspecialchars($_SESSION['username']) . "<br>";

// if (isset($_SESSION['message'])) {
//     echo "<p style='color: green;'>" . htmlspecialchars($_SESSION['message']) . "</p>";
//     unset($_SESSION['message']); // Clear the message after displaying it
// }

// if (isset($_SESSION['user_id'])) {
//     echo "User ID: " . htmlspecialchars($_SESSION['user_id']) . "<br>";
//     echo "Username: " . htmlspecialchars($_SESSION['username']) . "<br>";

//     // Check for role_id
//     if (isset($_SESSION['role_id'])) {
//         echo "Role ID: " . htmlspecialchars($_SESSION['role_id']) . "<br>";
//     } else {
//         echo "Role ID is not set.<br>";
//     }

//     // Check for role_name
//     if (isset($_SESSION['role_name'])) {
//         echo "Role: " . htmlspecialchars($_SESSION['role_name']) . "<br>";
//     } else {
//         echo "Role name is not set.<br>";
//     }
// } else {
//     echo "Session variable not set.";
// }

// function userHasPermission($roleName, $action) {
//     // Define permissions
//     $permissions = [
//         'admin' => ['delete'],
//         'teacher' => ['delete'],
//         // Add other roles and their permissions as needed
//     ];

//     return isset($permissions[$roleName]) && in_array($action, $permissions[$roleName]);
// }

function userHasPermission($roleName, $action)
{
    // Define permissions
    $permissions = [
        'Admin' => ['view', 'edit', 'delete'],
        'Teacher' => ['view', 'edit'],
        'Student' => ['view'],
        // Add other roles as needed
    ];

    return isset($permissions[$roleName]) && in_array($action, $permissions[$roleName]);
}
$teacher = new Subject($db);
$teacherList = $teacher->teacherList();
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
                <label for="Teachers">Choose a Teacher:</label>

                <label>Select Teacher(s):</label><br>
                <?php foreach ($teacherList as $teacher): ?>
                    <input type="checkbox" name="assigned_to[]" value="<?= $teacher['user_id'] ?>"><?= htmlspecialchars($teacher['username']) ?><br>
                <?php endforeach; ?>
                
            </div>
            <button type="submit" class="button1" name='submitted'>Add</button>
            <button type="button" class="button4" onclick="closePopup()">cancel</button>
        </form>
    </div>
</div>

<section class="content-head">
    <h1>
        Select subject of your choosing
    </h1>
</section>

<div class="wrapper">
    <div class="container">

        <div class="centering">
            <div class="search-content">
                <input type="search" id="search" placeholder="Search">
                <button class="button3">Search</button>
                <button class="button3">Rest All</button>
                <div class="sorting">
                    <button id='add' class="button1">Add Subejct</button>
                </div>
            </div>
        </div>



        <section class="content-body">
            <div class="subjects">

                <?php


                $subject = new Subject($db);
                $subjectList = $subject->getSubjectList();

                if (!empty($subjectList)) {
                    foreach ($subjectList as $subject) {
                        echo "<div class='sub-subjects'>
                <h1>" . htmlspecialchars($subject['subject_name']) . "</h1>
                <h3>" . htmlspecialchars($subject['subject_text']) . "</h3>
                <div class='card-subject'>";

                        // Button to view the subject
                        echo "<button class='button1'><a href='quizzes_page.php?subject_id=" . htmlspecialchars($subject['subject_id']) . "'>View Subject</a></button>";

                        // Button to edit the subject (only if user has permission)
                        if (userHasPermission($roleName, 'edit')) {
                            echo "<button class='button3' style='margin-left: 10px;'><a href='edit_subject.php?subject_id=" . htmlspecialchars($subject['subject_id']) . "'>Edit</a></button>";
                        }

                        // Form to delete the subject (only if user has permission)
                        if (userHasPermission($roleName, 'delete')) {
                            echo "<form action='Includes/Subject_handler.php' method='post' style='display:inline;'>
                    <input type='hidden' name='subject_id' value='" . htmlspecialchars($subject["subject_id"]) . "' />
                    <button type='submit' class='button5' onclick='return confirm(\"Are you sure you want to delete this subject?\");'>X</button>
                  </form>";
                        }

                        echo "</div></div>";
                    }
                } else {
                    echo "There are no subjects available, create a new one!";
                }
                ?>
            </div>
        </section>
    </div>
</div>