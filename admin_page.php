<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
error_reporting(E_ALL ^ E_WARNING);
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit;
}
?>

<?php

@include 'config.php';

if(isset($_POST['add_product'])){

    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_FILES['product_image']['name'];
    $product_image_tmp_name = $_FILEs['product_image']['tmp_name'];
    $product_image_folder = 'img/'.$product_image;

    if(empty($product_name) || empty($product_price) ||empty($product_image)){
        $message[] = 'please fill all the fields';
    }else{
        $insert = "INSERT INTO products(name, price, image) VALUES('$product_name', '$product_price','$product_image')";
        $upload = mysqli_query($conn,$insert);
        if($upload){
            move_uploaded_file($product_image_tmp_name, $product_image_folder);
            $message[] = 'product added successfully';
        }else{
            $message[] = 'product not added';
        }
    }
};

if(isset($_GET['delete'])){
    $id= $_GET['delete'];
    mysqli_query($conn, "DELETE FROM products WHERE id = $id");
    header('location:admin_page.php');
};
    
 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>admin page</title>

    <!-- Font Awesome cdn link-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- custom css file link-->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php

if(isset($message)){
    foreach($message as $message){
        echo '<span class="message">'.$message.'</span>';
    }

}
?>

<?php
    include 'header.php';
?>

    <div class="container" style="margin-top:100px;background:yellowgreen;padding:30px;">
        <div class="admin-product-form-container">
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                <h3>add a new kitkat flavor</h3>
                <input type="text" required placeholder="enter kitkat flavor" name="product_name" class="box">
                <input type="number" required placeholder="enter kitkat price" name="product_price" class="box">
                <input type="file" required accept="image/png, image/jpeg, image/jpg" name="product_image" class="box">
                <input type="submit" class="btn" name="add_product" value="add kitkat">
            </form> 
        </div>
    </div>
        <?php

            $select = mysqli_query($conn, "SELECT * FROM products");
        ?>

        <div class="product-display">
            <table class="product-display-table">
                <thead>
                    <tr>
                        <th>kitkat image</th>
                        <th>kitkat flavor</th>
                        <th>kitkat price</th>
                        <th>action</th>
                    </tr>
                </thead>

                <?php

                    while($row = mysqli_fetch_assoc($select)){   
                
                ?>

                <tr>
                    <td><img src="img/<?php echo $row['image']; ?>" height="100" alt=""></td>
                    <td><?php echo $row['name']; ?></td>
                    <td>$<?php echo $row['price']; ?></td>
                    <td>
                        <a href="admin_update.php?edit=<?php echo $row['id']; ?>" class="btn"> <i class="fas fa-edit"></i> edit </a>
                        <a href="admin_page.php?delete=<?php echo $row['id']; ?>" class="btn"> <i class="fas fa-trash"></i> delete </a>      
                </tr>

                <?php  };  ?>
            </table>
         </div>

    </div>

        <?php
            include("footer.php");
        ?>
</body>
</html>

