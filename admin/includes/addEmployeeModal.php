<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Employee</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form style="max-width: 500px;" action="./backend/addEmployeeBackend.php" method="POST">
                    <!-- Name input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" for="firstname">First Name: </label>
                        <input required type="text" name="firstname" id="firstname" class="form-control" />
                    </div>

                    <div class="form-outline mb-4">
                        <label class="form-label" for="lastname">Last Name: </label>
                        <input required type="text" name="lastname" id="lastname" class="form-control" />
                    </div>
                    <!-- Email input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" for="email">Email: </label>
                        <input required type="email" name="email" id="email" class="form-control" />
                    </div>

                    <!-- Password input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" for="password">Password</label>
                        <input required type="password" name="password" id="password" class="form-control" />
                    </div>

                    <!-- Role input -->
                    <div class="form-outline mb-4">
                        <p>Role:</p>
                        <label for="admin" class="form-label">Admin</label>
                        <input type="radio" id="admin" name="role" value="admin">
                        <label for="employee" class="form-label">Employee</label>
                        <input type="radio" id="employee" name="role" value="employee">
                    </div>

                    <!-- Designation input -->
                    <div class="form-outline mb-4">
                        <p>Designation:</p>
                        <label for="remote" class="form-label">Remote</label>
                        <input type="radio" id="remote" name="designation" value="remote">
                        <label for="onsite" class="form-label">Onsite</label>
                        <input type="radio" id="onsite" name="designation" value="onsite">
                    </div>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <!-- Submit button -->
                <button type="submit" name="submit" value="submit" class="btn btn-primary btn-block">
                    Add Employee
                </button>

                </form>
            </div>
        </div>
    </div>
</div>