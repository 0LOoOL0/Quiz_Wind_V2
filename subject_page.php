<?php
include 'header.php';
include 'Includes/Subject_handler.php';
include 'Includes/auth.php';

$userId = $_SESSION['user_id'] ?? null;
$userName = $_SESSION['username'] ?? null;
$roleId = $_SESSION['role_id'] ?? null;
$roleName = $_SESSION['role_name'] ?? null;

// echo "User ID: " . htmlspecialchars($_SESSION['user_id']) . "<br>";
// echo "Username: " . htmlspecialchars($_SESSION['username']) . "<br>";
// echo "Role ID: " . htmlspecialchars($_SESSION['role_id']) . "<br>";
// echo "Role: " . htmlspecialchars($_SESSION['role_name']) . "<br>";

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

<div class="popup-update">
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
            <button type="submit" class="button1" name='update'>update</button>
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

        <!-- <div class="centering">
            <div class="search-content">
                <input type="search" id="search" placeholder="Search">
                <button class="button3">Search</button>
                <button class="button3">Rest All</button>
                <div class="sorting">
                    <button id='add' class="button2">Add Subejct</button>
                </div>
            </div>
        </div> -->

        

        <section class="content-body">
        <div class="sorting">
                <button id='add' class="button1">Add Subejct</button>
            </div>

            <div class="subjects">

                <?php

                if (!empty($subjectList)) {
                    foreach ($subjectList as $subject) {
                        echo "<div class='sub-subjects'>
                                <h1>" . htmlspecialchars($subject['subject_name']) . "</h1>     
                                <h3>" . htmlspecialchars($subject['subject_text']) . "</h3>
                                <div class='card-subject'>";

                        // Button to view the subject
                        echo "<button class='button2'><a href='quizzes_page.php?subject_id=" . htmlspecialchars($subject['subject_id']) . "'>View Subject</a></button>";

                        // Button to edit the subject (only if user has permission)
                        if (userHasPermission($roleName, 'edit')) {
                            echo "<button id = 'update' class='button3' style='margin-left: 10px;'>Edit</button>";
                        }

                        // Form to delete the subject (only if user has permission)
                        if (userHasPermission($roleName, 'delete')) {
                            echo "<form action='Includes/Subject_handler.php' method='post' style='display:inline;'>
                                    <input type='hidden' name='subject_id' value='" . htmlspecialchars($subject["subject_id"]) . "' />
                                    <button type='submit' class='button5' onclick='return confirm(\"Are you sure you want to delete this subject?\");'>X</button>
                                  </form>";
                        }

                        echo "</div>
                        </div>";
                    }
                } else {
                    echo "There are no subjects available, create a new one!";
                }
                ?>
                <div class="sub-subjects">
                    <div class='randomize'>
                        <h2>title</h2>
                    </div>
                    <div class="subject-items">
                        <h3>description description description</h3>
                        <div class="card-subject">
                            <button class="button1">view</button>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
</div>