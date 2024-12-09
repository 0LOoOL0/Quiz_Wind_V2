<?php
include 'header.php';
include 'Includes/Chapter_handler.php';
include 'Includes/Subject_handler.php';
include 'auth.php';

?>

<script type="text/javascript" src="script.js"></script>


<section>
    <div class="content-head2">
        <h1>Create New Quiz</h1>
    </div>
</section>
<div class="wrapper">
    <div class="container">
        <div class="questions">
            <div class="centering">
                <button id='add' class="button3">Create New Question</button>
                <button id='add' class="button1">Save All</button>
            </div>

            <div class="crud-rule">
                <h1>Quiz</h1>
                <table>
                    <tr>
                        <td style='width:300px;'>Add Quiz Title</td>
                        <td><input type="text" style='width:110%; height:50px; border-radius:10px; margin:10px;' required></td>
                    </tr>
                    <tr>
                        <td style='width:250px;'>Add Quiz Description (Optional): </td>
                        <td><input type="text" style='width:110%; height:50px; border-radius:10px; margin:10px;'></td>
                    </tr>
                </table>
                <h1>Add Timer</h1>
                <form action="Includes/Quiz_handler.php">
                    <table>
                        <tr>
                            <td style='width:100px;'><label for="Timer">Timer (HH:MM:SS): </label></td>
                            <td><input type=text id ='timerInput' name='timerInput' style='width:110%; height:50px; border-radius:10px;' pattern="\d{2}:\d{2}:\d{2}" placeholder="00:00:00" required>
                            </td>
                        </tr>
                    </table>
                </form>
                <h1>Select Chapter</h1>
                <table>
                    <tr>
                        <td style='width:100px;'><label for="chapter">Chapter:</label></td>
                        <td><select name='chooseChapter' id="Chapters" placeholder="Select Chapter" style='width:110%; height:50px; border-radius:10px;' required>
                                <option value="">choose chapter...</option>
                                
                                <?php
                                     $subjectId = isset($_GET['subject_id']) ? (int)$_GET['subject_id'] : 0;

                                     if ($subjectId <= 0) {
                                         echo "Invalid subject ID.";
                                         exit;
                                     }
         
                                     $chapter = new Chapter($db);
                                     $chapterList = $chapter->getChaptersBySubject($subjectId);
         
                                     if (!empty($chapterList)) {
                                         foreach ($chapterList as $chapter) {
                                             // Display chapter title
                                             echo "<li>" . htmlspecialchars($chapter['chapter_title']) . "</li>";
                                         }
                                         echo "</ul>";
                                     } else {
                                         echo "No chapters found for this subject.";
                                     }
                                ?>

                            </select>
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
                        </td>
                    </tr>
                </table>
            </div>

            <div class="popup-create">
                <form action="" method="post">
                    <div class="popup-content">
                        <h1><label for="question">Create Question</label></h1>
                        <table>
                            <tr>
                                <td style='width:40px;'><label for="questionText">Question:</label></td>
                                <td><input type="text" id="question" name="questionText" required></td>
                            </tr>
                        </table>
                        <div id="crud-option">
                            <table>
                                <?php for ($i = 0; $i < 4; $i++): ?>
                                    <tr>
                                        <td style='width:20px;'><label for="option<?php echo $i; ?>">Option:</label></td>
                                        <td>
                                            <input type="text" name="optionTexts[]" id="option<?php echo $i; ?>" required />
                                        </td>
                                    </tr>
                                <?php endfor; ?>
                                <tr>
                                    <td style='width:20px;'><label>Correct answer:</label></td>
                                    <td>
                                        <select type="" style='width:930px; height:50px; border-radius:10px; margin-left: 10px; margin-top:20px;' name="isCorrect[]">
                                            <option value="">Select correct Answer....</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <button type="submit" class="button1" name='submitted'>Add Question</button>
                        <button type="button" class="button4" onclick="closePopup()">cancel</button>
                    </div>
                </form>
            </div>

            <div class="question-card" style="width:60%">
                <h1>question</h1>
                <div class="question-card-created">
                    <label for="option1">Short</label>
                    <label for="option2">Medium Length</label>
                    <label for="option3">This is a Considerably Longer Option This is a Considerably Longer Option</label>
                    <label for="option4">Another Option</label>
                </div>
                <button class="button4" style="width: 70%; margin-top:20px;">Remove</button>
            </div>
            <div class="question-card" style="width:60%">
                <h1>question</h1>
                <div class="question-card-created">
                    <label for="option1">Short</label>
                    <label for="option2">Medium Length</label>
                    <label for="option3">This is a Considerably Longer Option This is a Considerably Longer Option</label>
                    <label for="option4">Another Option</label>
                </div>
                <button class="button4" style="width: 70%; margin-top:20px;">Remove</button>
            </div>
            <div class="question-card" style="width:60%">
                <h1>question</h1>
                <div class="question-card-created">
                    <label for="option1">Short</label>
                    <label for="option2">Medium Length</label>
                </div>
                <button class="button4" style="width: 70%; margin-top:20px;">Remove</button>
            </div>

        </div>
    </div>