CREATE TABLE employees (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role TINYINT(1) NOT NULL DEFAULT 0
);

CREATE TABLE time_records (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    employee_id INT(11) NOT NULL,
    date_in DATE NOT NULL,
    time_in TIME NOT NULL,
    date_out DATE DEFAULT NULL,
    time_out TIME NOT NULL,
    FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE
);

CREATE TABLE otp (
    employee_id INT(11) NOT NULL,
    otp INT(6) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (employee_id),
    FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE
);
