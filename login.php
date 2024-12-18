<?php

include 'header.php';

include 'Includes/User_handler.php';
?>

<script type="text/javascript" src="script.js"></script>

<body class="page11">
<div class="spaceup">
        <div class="container">
            <div class="content-login">
                <form action="Includes/login_handler.php" method="post">
                    <table>
                        <tr>
                            <td>
                                <h1>Account Login</h1>
                            </td>
                        </tr>
                        <tr>
                            <td><input type="text" name="username" id='username' placeholder="Username" required></td>
                        </tr>
                        <tr>
                            <td><input type="password" name="password" id='password' placeholder="Password" required></td>
                        </tr>
                        <tr>
                            <td>
                                <p>Forgot password? <a href="login.php">Click Here!</a></p>
                            </td>
                        </tr>
                        <tr>
                            <td><button class="button1" type="submit" name="loginin">Login</button></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</body>
<div class="wrapper">
</div>