<?php
include "header.php";
?>

<div>
    <form action="index.php" method="get">
        <button type="submit">Back to Homepage</button>
    </form>
</div>

<div>
    <h1>System Schema</h1>
</div>

<div>
    <h2>Employees</h2>
    <ul>
        <li>id INT(11) NOT NULL AUTO_INCREMENT</li>
        <li>name VARCHAR(255) NOT NULL</li>
        <li>email VARCHAR(255) NOT NULL</li>
        <li>password VARCHAR(255) NOT NULL</li>
        <li>leave_credits INT(11) NOT NULL DEFAULT 12</li>
        <li>is_employer TINYINT(1) NOT NULL DEFAULT 0</li>
        <li>created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP</li>
        <li>updated_at TIMESTAMP DEFAULT</li>
        <li>CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP</li>
        <li>PRIMARY KEY (id)</li>
        <li>UNIQUE KEY (email)</li>
    </ul>
    <p>employees: stores information about employees, including their name, email, password, leave credits, and whether or not they are an employer. Each employee has a unique email address.</p>
    <hr>
</div>

<div>
    <h2>Attendance</h2>
    <ul>
        <li>id INT(11) NOT NULL AUTO_INCREMENT</li>
        <li>employee_id INT(11) NOT NULL</li>
        <li>time_in DATETIME NOT NULL</li>
        <li>time_out DATETIME DEFAULT NULL</li>
        <li>in_office TINYINT(1) NOT NULL DEFAULT 0</li>
        <li>created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP</li>
        <li>updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP</li>
        <li>PRIMARY KEY (id)</li>
        <li>FOREIGN KEY (employee_id) REFERENCES employees(id)</li>
    </ul>
    <p>attendance: stores information about employee attendance, including their time in, time out, and location (if work from home or in office).</p>
    <hr>
</div>

<div>
    <h2>Leaves</h2>
    <ul>
        <li>id INT(11) NOT NULL AUTO_INCREMENT</li>
        <li>employee_id INT(11) NOT NULL</li>
        <li>reason VARCHAR(255) NOT NULL</li>
        <li>start_date DATE NOT NULL</li>
        <li>end_date DATE NOT NULL</li>
        <li>status ENUM('pending', 'approved', 'denied') NOT NULL DEFAULT 'pending'</li>
        <li>comment VARCHAR(255) DEFAULT NULL</li>
        <li>created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP</li>
        <li>updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP</li>
        <li>PRIMARY KEY (id)</li>
        <li>FOREIGN KEY (employee_id) REFERENCES employees(id)</li>
    </ul>
    <p>leaves: stores information about employee leave requests, including the reason, start date, end date, status (pending, approved, or denied), and any comments from the employer.</p>
    <hr>
</div>

<div>
    <h2>Daily Time Record Changes</h2>
    <ul>
        <li>id INT(11) NOT NULL AUTO_INCREMENT</li>
        <li>employee_id INT(11) NOT NULL</li>
        <li>date DATE NOT NULL</li>
        <li>time_in DATETIME NOT NULL</li>
        <li>time_out DATETIME DEFAULT NULL</li>
        <li>status ENUM('pending', 'approved', 'denied') NOT NULL DEFAULT 'pending'</li>
        <li>comment VARCHAR(255) DEFAULT NULL</li>
        <li>created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP</li>
        <li>updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP</li>
        <li>PRIMARY KEY (id)</li>
        <li>FOREIGN KEY (employee_id) REFERENCES employees(id)</li>
    </ul>
    <p>dtr_changes: stores information about employee requests to change their daily time record, including the date, time in, time out, status, and any comments from the employer.</p>
    <hr>
</div>

<div>
    <h2>Passcodes</h2>
    <ul>
        <li>id INT(11) NOT NULL AUTO_INCREMENT</li>
        <li>passcode VARCHAR(255) NOT NULL</li>
        <li>used TINYINT(1) NOT NULL DEFAULT 0</li>
        <li>created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP</li>
        <li>updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP</li>
        <li>PRIMARY KEY (id)</li>
    </ul>
    <p>passcodes: stores one-time passcodes that employees can use to register for an account. Once a passcode has been used, it is marked as used and cannot be used again.</p>
    <hr>
</div>

<div>
    <form action="index.php" method="get">
        <button type="submit">Back to Homepage</button>
    </form>
</div>