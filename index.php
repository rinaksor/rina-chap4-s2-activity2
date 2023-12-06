<?php require_once 'templates/header.php';?>
<?php
$host     = 'localhost'; // Because MySQL is running on the same computer as the web server
$database = 'PHP_connect'; // Name of the database you use (you need first to CREATE DATABASE in MySQL)
$user     = 'root'; // Default username to connect to MySQL is root
$password = ''; // Default password to connect to MySQL is empty

// b1 tạo connect đến DB
try {
    $conn = new PDO("mysql:host=$host;dbname=$database", $user, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
  } catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['username']) && !empty($_POST['message'])) :
    $username = $_POST['username'];
    $message = $_POST['message'];

    //b2 ghi câu lệnh truy vấn dữ liệu
    $query = "INSERT INTO posts (name, message) VALUES ('$username','$message');";
    // INSERT NEW POST IN DATABASE
    $stmt = $conn->prepare($query);
    // Thực thi câu truy vấn
    $stmt->execute();

endif;
?>
<?php
// TO DO: SELECT ALL POSTS FROM DATABASE

$query1= "SELECT * FROM posts";
$stmt_select = $conn->query($query1);
$result = $stmt_select->fetchAll(PDO::FETCH_ASSOC);

foreach ($result as $value) :
?>
    <div class="card">
        <div class="card-header">
            <!-- todo -->
            <span><?php echo $value['name']?></span>
        </div>
        <div class="card-body">
            <!-- todo -->
            <p class="card-text"><?php echo $value['message'] ?></p>
        </div>
    </div>
    <hr>
<?php
endforeach;
?>
<form action="#" method="post">
    <div class="row mb-3 mt-3">
        <div class="col">
            <input type="text" class="form-control" placeholder="Enter Name" name="username">
        </div>
    </div>
    <div class="mb-3">
        <textarea name="message" placeholder="Enter message" class="form-control"></textarea>
    </div>
    <div class="d-grid">
        <button type="submit" class="btn btn-primary">Add new post</button>
    </div>
</form>
<?php
require_once 'templates/footer.php';
?>
