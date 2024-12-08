<?php
include 'header.php';
include 'Includes/Subject_handler.php';

if (isset($_SESSION['message'])) {
    echo "<p style='color: green;'>" . htmlspecialchars($_SESSION['message']) . "</p>";
    unset($_SESSION['message']); // Clear the message after displaying it
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

                <select name="assigned_to" id="Teachers" placeholder="Select Teacher">
                    <option value="">Select Teacher....</option>

                    <!--This code will list all the roles from the database into options-->
                    <?php

                    $teacher = new Subject($db);
                    $teacherList = $teacher->teacherList();  // Ensure the method is accurately called
                    foreach ($teacherList as $teacher) {
                        echo "<option value='" . $teacher['user_id'] . "'>" . htmlspecialchars($teacher['username']) . "</option>";  // Escape output
                    }

                    ?>

                </select>
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
                        echo "<tr>
                            <div class='sub-subjects'>
                            <h1>
                                " . $subject['subject_name'] . "
                            </h1>
                            <h3>
                                " . $subject['subject_text'] . "
                            </h3>
                            <div class='card-subject'>
                                <button class='button1'><a href='quizzes_page.php'>View Subject</a></button>
                                <button class='button3' style='margin-left: 10px;'>Edit</button>
                                
                                <form action='Includes/Subject_handler.php' method='post' style='display:inline;'>
                                    <input type='hidden' name='subject_id' value='" . htmlspecialchars($subject["subject_id"]) . "' />
                                    <button type='submit' class='button5' onclick='return confirm(\"Are you sure you want to delete this user?\");'>X</button>
                                </form>
                            </div>
                            </div>";
                    }
                    echo "</table>";
                } else {
                    echo " 0 Results";
                }
                ?>

                <div class="sub-subjects">
                    <h2>
                        Subject
                    </h2>
                    <p>
                        description description description description description description description description
                    </p>
                    <div class="card-subject">
                        <table>
                            <tr>
                                <td><button class="button2">View Subject</button></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>