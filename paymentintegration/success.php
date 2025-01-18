<?php
include 'config.php';
?>
 
 
<!DOCTYPE html>
<html lang="en">
 
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Payment Status | Annapurna</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
 
    
</head>

<style>
    .order{
        margin-left: 200px;
    }

    .first{
        margin-left: 200px;
    }
    
    .message{
        text-align: center;
    }

    .more{
        display: flex;
        margin-left: 200px;
        font-size: 20px;
    }

    .more a{
        margin-left: 50px;
        font-size: 20px;
    }

    .thankyou{
        height: 400px;
        margin-left: 640px;
        margin-top: 100px;
    }
</style>
<body>
     <main class="checkout-page">
        <div class="header" style="text-align:center">
           <h5>Payment Status</h5>
        </div>
        <div class="text-wrap">
            
            <div class="box-wrap">
                <div class="row justify-content-center">
                    <div class="col">
                        
                        <div class="summary-div checkout-page">
                        
     <?php 
     
           
   if(isset($_GET['order_id']) && $_GET['order_id'] !=''){
$order_id=$_GET['order_id'];
// write your fetch query to fetch order details by id and customise the layout and information
if($order_id !=''){
    ?>
    
        <p class="text-center text-success" style="font-size: 18px;">
         Payment Successfull!
            </p>
            
           <div class="row item-row sub-total-row">
            <div class="col-md-6 col-sm-6 col first"> Order Id   </div>
            
            <strong class="order"><?php echo $order_id;?></strong>
                                    </div> 
             <div class="orderDetails row item-row sub-total-row">
              <div class="col-md-12 col-sm-12 col">
                <br>
                <div class="more">
                <p> Order More </p>
                <a href="http://localhost/Annapurna/index.php"> Visit Annapurna </a>
                </div>
                <img src="../../images/184444-oxc6gz-103.jpg" class="thankyou">
                <br><br><br><br>
                <p class="message">Visit Us Again.  </p>
</div>
</div>
 
                            </div>
            
            <?php  }else{
 
      
    
    ?>
    
        <p class="text-center text-red">
          Payment is failed.
          <br>
          <i class="fa fa-times" aria-hidden="true"></i>
            </p>
           
            <?php  }
  ?>
                            </div>
    
    
                        </div>
                    
                    </div>
                </div>
            </div>
          
          </div>
         
    </main>
   </body>
 
</html>
<?php
}else{
    echo "{'error':'Record not found'}";
}