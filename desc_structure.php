<?php
include "header.php";
?>

<div>
    <form action="index.php" method="get">
        <button type="submit">Back to Homepage</button>
    </form>
</div>

<div>
    <h1>System Structure</h1>
</div>

<div>
    <h2>Outline of Pages</h2>
    <div>
        <p>The system has a landing page with a description of the system and a login button directing users to the login page. The login page has a login form for both employees and employers and a button to request the employer to add the employee's account. There is also a change password button on this page.</p>
    </div>
    <div>
        <p>The registration form for employees is on the request_account.php page, which asks for employee ID, name, email, and password. The form also requires a one-time passcode for validation, and approval is needed from the employer.</p>
    </div>
    <div>
        <p>The employee dashboard page has a take attendance button that records the time and location of the employee, displaying time out if they have already timed in for the day. There are tabs for viewing attendance, leaves, and remaining leave credits.</p>
    </div>
    <div>
        <p>The employee_attendance.php page displays the employee's time records in a daily time record format, allowing filtering for specific months and the ability to request an employer to make changes to specific rows.</p>
    </div>
    <div>
        <p>The employee_leaves.php page displays the employee's leave credits and has a button to request the employer's approval for leaves, which directs the employee to a request leave form that asks for reason, leave start date, and leave end date.</p>
    </div>
    <div>
        <p>The employer dashboard displays a report of absent, late, and on-leave employees for the day. There are tabs for viewing daily time records, employee requests for leave, employee requests for time record changes, employees, and employee requests for accounts. The employer can also access their own employee dashboard using a button.</p>
    </div>
    <div>
        <p>The employer_view_leaves_requests.php page displays employee leave requests, allowing employers to approve or deny them with comments or reasons for the decision.</p>
    </div>
    <div>
        <p>The employer_view_dtr_changes.php page displays employee time record requests, allowing employers to approve or deny them with comments or reasons for the decision, with approved changes automatically updating the relevant row in the daily time record.</p>
    </div>
    <div>
        <p>The employer_view_leaves.php page displays a table format of employees' leave credits and employees on leave.</p>
    </div>
    <div>
        <p>The employer_view_dtr.php page displays a table format of employees and their daily time records, with a view DTR button that opens a modal displaying the employee's daily time record for the month. Filtering options are available for the displayed date.</p>
    </div>
    <div>
        <p>The employer_employees.php page displays a table format of employees and has buttons for updating or deleting employees on the same row. There is also a button to add an employee.</p>
    </div>
    <div>
        <p>The employer_view_account_requests.php page displays a table format of employees requesting account requests, allowing employers to approve or deny them with comments or reasons for the decision, with approved requests automatically adding the employee.</p>
    </div>
    <div>
        <p>The change_password.php page allows users to change their passwords by entering their new password and confirming it.</p>
    </div>
    <div>
        <p>The forgot_password.php page displays a form for employees to enter their ID, name, and email, sending an email containing a link to change the password.</p>
    </div>
    <div>
        <p>Finally, the logout.php page logs out users and directs them back to the login page.</p>
    </div>
</div>

<div>
    <form action="index.php" method="get">
        <button type="submit">Back to Homepage</button>
    </form>
</div>