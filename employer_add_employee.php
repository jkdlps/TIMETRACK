<?php
// database connection code here

// check if form is submitted
if(isset($_POST['add_employee'])) {
  // retrieve form data
  $name = $_POST['name'];
  $email = $_POST['email'];
  
  // insert data into database
  $stmt = $pdo->prepare("INSERT INTO employees (name, email) VALUES (:name, :email)");
  $stmt->bindParam(':name', $name);
  $stmt->bindParam(':email', $email);
  $stmt->execute();

  // redirect back to employees page
  header("Location: employees.php");
  exit;
}
?>

<!-- Employer Dashboard Code here -->

<h1>Employees</h1>

<p>Total Employees: <?php echo $totalEmployees; ?></p>

<table>
  <thead>
    <tr>
      <th>Name</th>
      <th>Email</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($employees as $employee): ?>
      <tr>
        <td><?php echo $employee['name']; ?></td>
        <td><?php echo $employee['email']; ?></td>
        <td>
          <button>Edit</button>
          <button>Delete</button>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<button id="addEmployeeButton">Add Employee</button>

<!-- Add Employee Modal Form -->
<div id="addEmployeeModal" class="modal">
  <form method="post">
    <h2>Add Employee</h2>
    <label for="name">Name:</label>
    <input type="text" id="name" name="name">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email">
    <button type="submit" name="add_employee">Submit</button>
  </form>
</div>

<script>
// open modal when "Add Employee" button is clicked
const addEmployeeButton = document.getElementById("addEmployeeButton");
const addEmployeeModal = document.getElementById("addEmployeeModal");
addEmployeeButton.addEventListener("click", () => {
  addEmployeeModal.style.display = "block";
});

// close modal when user clicks outside of modal or on close button
window.onclick = function(event) {
  if (event.target == addEmployeeModal) {
    addEmployeeModal.style.display = "none";
  }
}
</script>
