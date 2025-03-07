<?php include('partial/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>

        <br><br>

        <?php
            // Check whether id is set or not
            if(isset($_GET['id'])) {
                // Get the id and all other details
                $id = $_GET['id'];

                // Create SQL query to get all other details
                $sql = "SELECT * FROM tbl_category WHERE id=$id";

                // Execute the query
                $res = mysqli_query($conn, $sql);

                // Count the rows to check whether id is valid or not
                $count = mysqli_num_rows($res);

                if($count == 1) {
                    // Get all the data
                    $row = mysqli_fetch_assoc($res);
                    $title = $row['title'];
                    $current_image = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
                } else {
                    // Redirect to manage category with session message
                    $_SESSION['no-category-found'] = "<div class='error'>Category not Found.</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
            } else {
                // Redirect to manage category
                header('location:'.SITEURL.'admin/manage-category.php');
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
                        <?php
                            if($current_image != "") {
                                // Display the image
                                ?>
                                <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" width="150px">
                                <?php
                            } else {
                                // Display message
                                echo "<div class='error'>Image not Added.</div>";
                            }
                        ?>
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
                        <input <?php if($featured == "Yes") {echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes
                        <input <?php if($featured == "No") {echo "checked";} ?> type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if($active == "Yes") {echo "checked";} ?> type="radio" name="active" value="Yes"> Yes
                        <input <?php if($active == "No") {echo "checked";} ?> type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="original_title" value="<?php echo $title; ?>">
                        <input type="hidden" name="original_featured" value="<?php echo $featured; ?>">
                        <input type="hidden" name="original_active" value="<?php echo $active; ?>">
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
            if(isset($_POST['submit'])) {
                // Get all values from form
                $id = $_POST['id'];
                $title = $_POST['title'];
                $current_image = $_POST['current_image'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];

                // Original values
                $original_title = $_POST['original_title'];
                $original_featured = $_POST['original_featured'];
                $original_active = $_POST['original_active'];

                // Check if no changes are detected
                if($title == $original_title && $featured == $original_featured && $active == $original_active && empty($_FILES['image']['name'])) {
                    $_SESSION['update'] = "<div class='error'>No changes detected.</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                } else {
                    // Update image if a new one is selected
                    if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
                        $image_name = $_FILES['image']['name'];
                        $ext = end(explode('.', $image_name));
                        $image_name = "Food_Category_".rand(000, 999).'.'.$ext;
                        $source_path = $_FILES['image']['tmp_name'];
                        $destination_path = "../images/category/".$image_name;

                        $upload = move_uploaded_file($source_path, $destination_path);

                        if($upload == false) {
                            $_SESSION['upload'] = "<div class='error'>Failed to upload Image.</div>";
                            header('location:'.SITEURL.'admin/manage-category.php');
                            die();
                        }

                        if($current_image != "") {
                            $remove_path = "../images/category/".$current_image;
                            $remove = unlink($remove_path);

                            if($remove == false) {
                                $_SESSION['failed-remove'] = "<div class='error'>Failed to remove current image.</div>";
                                header('location:'.SITEURL.'admin/manage-category.php');
                                die();
                            }
                        }
                    } else {
                        $image_name = $current_image;
                    }

                    // Update the database
                    $sql2 = "UPDATE tbl_category SET
                        title = '$title',
                        image_name = '$image_name',
                        featured = '$featured',
                        active = '$active'
                        WHERE id=$id
                    ";

                    $res2 = mysqli_query($conn, $sql2);

                    if($res2 == true) {
                        $_SESSION['update'] = "<div class='success'>Category Updated Successfully.</div>";
                        header('location:'.SITEURL.'admin/manage-category.php');
                    } else {
                        $_SESSION['update'] = "<div class='error'>Failed to Update Category.</div>";
                        header('location:'.SITEURL.'admin/manage-category.php');
                    }
                }
            }
        ?>

    </div>
</div>

<?php include('partial/footer.php'); ?>
