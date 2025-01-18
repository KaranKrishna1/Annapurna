<?php include('partial/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>

        <br><br>

        <?php
             if(isset($_SESSION['add'])) //checking whether session is set or not
             {
                echo $_SESSION['add']; //display the session message if set
                unset($_SESSION['add']); //remove session message
             }

        ?>
        <form action="" method="POST">
            
             <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" name="full_name" placeholder="Enter Your Name">
                    </td>
                </tr>
                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" placeholder="Your Username">
                    </td>
                </tr>
                <tr>
                    <td>Password: </td>
                    <td>
                        <input type="password" name="password" placeholder="Your Password">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>    
    
        </form>
    </div>
</div>

<?php include('partial/footer.php'); ?>


<?php
     //Process the value from form and process it in database

     //Check whether the submit button is clicked or not

     if(isset($_POST['submit']))
     {
        //Button Clicked
        //echo "Button Clicked";

        // get the data from form
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $password = md5($_POST['password']); //we used md5 to encrypt the password

        //sql query to save data into database
        if($full_name && $username && $password != ""){
            $sql = "INSERT INTO tbl_admin SET
            full_name = '$full_name',
            username = '$username',
            password = '$password'
        "; 
        }
        else{
            echo "Empty field detected.";
        }

        // executing theory and saving data into database
        $res = mysqli_query($conn, $sql) or die(mysqli_error());

        // check whether the (query is executed) data is inserted or not and display appropriate message
        if($res==TRUE)
        {
            // data inserted
            // echo "data inserted";
            // create a session variable to display message
            $_SESSION['add'] = "<div class='success'>Admin added successfully</div>";
            // redirect page to manage admin
            header("location:".SITEURL.'admin/manage-admin.php');
        }
        else
        {
            // failed to insert data
            // echo "failed to insert data";
            // create a session variable to display message
            $_SESSION['add'] = "Failed to Add Admin";
            // redirect page to add-admin
            header("location:".SITEURL.'admin/add-admin.php');
        }
     }

?> 