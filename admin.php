<?php
require 'header.php';
if (isset($_POST['username']) && isset($_POST['password'])) {
    // check if username is submitted!
    $username = sanitizeInput($_POST['username']);
    $password = sanitizeInput($_POST['password']);
    $user = new User($username,$password); 
} else {
    // redirect to login page
    header('Location: login.php');
}

?>

<div class="row blue">
    <div class="col">
        <?php if($user->checkPassword()) {
            echo 'Password is correct';
        } else {
            echo 'Password is incorrect';
        }; ?>
    </div>
</div>

<div class="row blue">
<div class="col">
    <h1>Sightings list</h1>

    <?php 
   $result = mysqli_query($conn,"SELECT * FROM aliens");
    ?>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">Image</th>
                <th scope="col">Location</th>
                <th scope="col">Date &amp; time</th>
                <th scope="col">Description</th>
                <th scope="col">Scary</th>
                <th scope="col">Details</th>
                <th scope="col">action</th>
            </tr>
        </thead>
        <tbody>
            <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    // Construct image path
                    $imagePath = 'assets/images/' . $row['alienImg'];
                    // Check if image is not empty and exists
                    if (!empty($row['alienImg']) && file_exists($imagePath)) {
                        echo "<td><img src='$imagePath' class='img img-fluid history' width='100px'></td>";
                    } else {
                        // Display default image
                        echo "<td><img src='assets/images/default-image.jpg' class='img img-fluid history' width='100px'></td>";
                    }
                    // Display other data
                    echo '<td>' . $row['location'] . '</td>';
                    echo '<td>' . formatDate($row['date']) . ' - '. $row['time'] .'</td>';
                    echo '<td>' . $row['message'] . '</td>';
                    echo '<td>' . ($row['scary'] ? 'Yes' : 'No') . '</td>';
                    echo "<td><a href='details.php?id=".encryptId($row['id'])."' class='btn btn-primary'>Details</a></td>";
                    echo "<td><a href='approve.php?id=".encryptId($row['id'])."' class='btn btn-success'>Approve</a></td>";
                    echo '</tr>';
                }
            ?>
        </tbody>
    </table>
</div>
            </div>

<?php
require 'footer.php';
?>