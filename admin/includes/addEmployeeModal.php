<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Employee</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form class="" style="max-width: 500px;" action="./backend/addAdminBackend.php" method="POST">
                    <!-- Name input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" for="form1Example1">Name</label>
                        <input required type="name" name="name" id="form1Example1" class="form-control" />

                    </div>
                    <!-- Email input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" for="form1Example1">Email address</label>
                        <input required type="email" name="email" id="form1Example1" class="form-control"/>

                    </div>

                    <!-- Password input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" for="form1Example2">Password</label>
                        <input required type="password" name="password" id="form1Example2" class="form-control" />

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