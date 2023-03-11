<?php
include("edit_reservations.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update</title>

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-beta1/css/bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />



    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100&display=swap" rel="stylesheet">
</head>

<body>

    <div class='container m-5'>
        <form class="form card" id="loginform" style="max-width:500px ; margin:auto"
            action="../backend/updateBackend_reservations.php" method="POST">

            <div class="card-header">
                <h3 class="fw-normal">Update Reservations</h3>
            </div>
            <div class='card-body'>



                <!-- Input fields -->
                <label for="exampleInputEmail1" class="form-label">Id</label>
                <input type="text" id="id" value="<?php echo $row['id'];?>" name="id" class="form-control mb-4"
                    placeholder="Id">

                <label for="exampleInputEmail1" class="form-label">Name</label>
                <input type="text" id="firstname" value="<?php echo $row['name']; ?>" name="name"
                    class="form-control mb-4" placeholder="Firstname">

                    <label for="exampleInputEmail1" class="form-label">Email</label>
                <input type="text" id="email" value="<?php echo $row['email']; ?>" name="email"
                    class="form-control mb-4" placeholder="Email">

                    <label for="exampleInputEmail1" class="form-label">Events</label>
                <input type="text" id="contact" value="<?php echo $row['events'];?>" name="events"
                    class="form-control mb-4" placeholder="Events">

                <label for="exampleInputEmail1" class="form-label">Date</label>
                <input type="text" id="contact" value="<?php echo $row['date'];?>" name="date"
                    class="form-control mb-4" placeholder="Date">

                    <label for="exampleInputEmail1" class="form-label">Time</label>
                <input type="text" id="contact" value="<?php echo $row['time'];?>" name="time"
                    class="form-control mb-4" placeholder="Time">

                <label for="exampleInputEmail1" class="form-label">Contact</label>
                <input type="text" id="address" value="<?php echo $row['contact'];?>" name="contact"
                    class="form-control mb-4" placeholder="contact">

                <label for="exampleInputEmail1" class="form-label">Message</label>
                <input type="text" id="gender" value="<?php echo $row['message'];?>" name="message"
                    class="form-control mb-4" placeholder="message">


                <button class="btn btn-dark form-control" name="update"
                    href="../backend/updateBackend_reservations.php">Update</button>

            </div>

        </form>
    </div>



    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>

</body>

</html>