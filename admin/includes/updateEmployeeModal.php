<?php
if(isset($_POST['update'])):
    ?>

<form action="updateusers.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    <div class="mb-3">
        <label for="firstName" class="form-label">First Name</label>
        <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo $row['firstName']; ?>" required>
    </div>
    <div class="mb-3">
        <label for="lastName" class="form-label">Last Name</label>
        <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo $row['lastName']; ?>" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['email']; ?>" required>
</div>
<div class="mb-3">
<label for="role" class="form-label">Role</label>
<input type="text" class="form-control" id="role" name="role" value="<?php echo $row['role']; ?>" required>
</div>
<div class="mb-3">
<label for="designation" class="form-label">Designation</label>
<input type="text" class="form-control" id="designation" name="designation" value="<?php echo $row['designation']; ?>" required>
</div>
<button type="submit" class="btn btn-primary">Update</button>

</form>

<?php endif; ?>