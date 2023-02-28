<?php 
include "header.php";
include "conn.php";
?>
    <h1>Log in to TIMETRACK</h1>
    <form method="post" action="authenticate.php">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    <br><br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <br><br>
    <label for="usertype">I am a:</label>
    <select id="usertype" name="usertype" required>
        <option value="">Select user type</option>
        <option value="employee">Employee</option>
        <option value="employer">Employer</option>
    </select>
    <br><br>
    <input type="submit" value="Log in">
    </form>
    <br>
    <button onclick="location.href='forgot_password.php'">Forgot Password</button>
    <br><br>
    <button onclick="location.href='request_account.php'">Request to Add Me as Employee</button>

    <div>
    <form action="index.php" method="post">
        <input type="submit" value="Back to Homepage">
    </form>
    </div>