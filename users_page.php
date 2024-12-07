<?php
include 'header.php';

?>


<section class="content-head">
    <h1>
        Select subject of your choosing
    </h1>

</section>
<div class="wrapper">
    <div class="container">
        <div class="participants">
            <div class="search-content">
                <input type="search" id="search" placeholder="Search">
                <button class="button3">Search</button>
                <button class="button3" id="add">Rest All</button>
                <div class="sorting">
                    <button class="button1">Add User</button>
                </div>
            </div>
            <div class="users-table">
                <table>
                    <tr>
                        <th>User ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Joined date</th>
                        <th>Action</th>
                    </tr>
                    <tr>
                        <td>User ID</td>
                        <td>Username</td>
                        <td>Email</td>
                        <td>Joined date</td>
                        <td>
                            <button class="button3">Edit</button>
                            <button class="button4">Delete</button>
                        </td>
                    </tr>
                    <?php
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>