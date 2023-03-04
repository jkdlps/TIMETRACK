CREATE TABLE employees (
  id INT(11) NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  work_location VARCHAR(255) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE timesheets (
  id INT(11) NOT NULL AUTO_INCREMENT,
  employee_id INT(11) NOT NULL,
  date DATE NOT NULL,
  checkin_time TIME,
  checkout_time TIME,
  hours_worked DECIMAL(4,2),
  approved TINYINT(1) DEFAULT 0,
  PRIMARY KEY (id),
  FOREIGN KEY (employee_id) REFERENCES employees(id)
);