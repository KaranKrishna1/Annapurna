<?php include('partial/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>

        <br><br>

        <?php
            // Check if the id is set
            if(isset($_GET['id'])) {
                $id = $_GET['id'];
                
                // Fetch the current food details
                $sql = "SELECT * FROM tbl_food WHERE id=$id";
                $res = mysqli_query($conn, $sql);

                if(mysqli_num_rows($res) == 1) {
                    $row = mysqli_fetch_assoc($res);
                    $title = $row['title'];
                    $current_image = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
                } else {
                    $_SESSION['no-food-found'] = "<div class='error'>Food not Found.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
            } else {
                header('location:'.SITEURL.'admin/manage-food.php');
            }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php if($current_image != "") { ?>
                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="150px">
                        <?php } else { ?>
                            <div class='error'>Image not Added.</div>
                        <?php } ?>
                    </td>
                </tr>

                <tr>
                    <td>New Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if($featured == "Yes") echo "checked"; ?> type="radio" name="featured" value="Yes"> Yes
                        <input <?php if($featured == "No") echo "checked"; ?> type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if($active == "Yes") echo "checked"; ?> type="radio" name="active" value="Yes"> Yes
                        <input <?php if($active == "No") echo "checked"; ?> type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="original_title" value="<?php echo $title; ?>">
                        <input type="hidden" name="original_featured" value="<?php echo $featured; ?>">
                        <input type="hidden" name="original_active" value="<?php echo $active; ?>">
                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
            if(isset($_POST['submit'])) {
                $id = $_POST['id'];
                $title = $_POST['title'];
                $current_image = $_POST['current_image'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];

                // Fetch original values
                $original_title = $_POST['original_title'];
                $original_featured = $_POST['original_featured'];
                $original_active = $_POST['original_active'];

                // Check for changes
                if($title == $original_title && $featured == $original_featured && $active == $original_active && empty($_FILES['image']['name'])) {
                    $_SESSION['update'] = "<div class='error'>No changes detected.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                    exit;
                }

                // Handle image upload
                if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
                    $image_name = $_FILES['image']['name'];
                    $ext = pathinfo($image_name, PATHINFO_EXTENSION);
                    $image_name = "Food_".rand(000, 999).".".$ext;
                    $source_path = $_FILES['image']['tmp_name'];
                    $destination_path = "../images/food/".$image_name;

                    $upload = move_uploaded_file($source_path, $destination_path);

                    if($upload == false) {
                        $_SESSION['upload'] = "<div class='error'>Failed to upload Image.</div>";
                        header('location:'.SITEURL.'admin/manage-food.php');
                        exit;
                    }

                    if($current_image != "") {
                        $remove_path = "../images/food/".$current_image;
                        $remove = unlink($remove_path);
                        if($remove == false) {
                            $_SESSION['failed-remove'] = "<div class='error'>Failed to remove current image.</div>";
                            header('location:'.SITEURL.'admin/manage-food.php');
                            exit;
                        }
                    }
                } else {
                    $image_name = $current_image;
                }

                // Update the database
                $sql2 = "UPDATE tbl_food SET
                    title = '$title',
                    image_name = '$image_name',
                    featured = '$featured',
                    active = '$active'
                    WHERE id=$id";

                $res2 = mysqli_query($conn, $sql2);

                if($res2 == true) {
                    $_SESSION['update'] = "<div class='success'>Food Updated Successfully.</div>";
                } else {
                    $_SESSION['update'] = "<div class='error'>Failed to Update Food.</div>";
                }
                header('location:'.SITEURL.'admin/manage-food.php');
            }
        ?>
    </div>
</div>

<?php include('partial/footer.php'); ?>
