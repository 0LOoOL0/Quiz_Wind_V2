<?php
include 'header.php';

?>

<script type="text/javascript" src="script.js"></script>

<div class="popup-create">
    <div class="popup-content">
        <h1>Create new Subject</h1>
        <form action="subject_page.php" method="post">
            <div class="form-content">
                <p>Subject name</p>
                <input type="text" name="subject_name">
                <p>Description</p>
                <input type="text" name="subject_text">
                <p>Select Teacher</p>
                <select name="" id="">
                    <option value="">1</option>
                    <option value="">2</option>
                    <option value="">3</option>
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
                <div class="sub-subjects">
                    <h2>
                        Subject
                    </h2>
                    <p>
                        description description description description description description description description
                    </p>
                    <div class="card-subject">
                        <button class="button1"><a href="quizzes_page.php">View Subject</a></button>
                        <button class="button3" style="margin-left: 10px;">Edit</button>
                    </div>
                </div>
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