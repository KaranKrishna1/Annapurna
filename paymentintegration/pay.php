<?php
include 'config.php';
// Enter Your website domain url
 
$base_url="http://localhost/Annapurna/paymentintegration/";
 
 
/******************* Cashfree API Details ***************/
 
$payMode="sandbox"; // for live change it to "production"
 
if($payMode=='production'){
    
    // live api details
 
define('client_id',"");
define('secret_key',"");
 
$APIURL="https://api.cashfree.com/pg/orders";
    
}else{
    
    // test api details
define('client_id',"");
define('secret_key',"");
 
$APIURL="https://sandbox.cashfree.com/pg/orders";
    
}
//===========*********************============
 
if(isset($_POST['contact']) && $_POST['email'] !='' && $_POST['full-name'] !='' && $_POST['email'] !=''){
 
function generateOrderId($prefix = '') {
    // Use uniqid with more entropy
    $uniqid = uniqid($prefix, true);
 
    
    $randomNumber = mt_rand(100000, 999999); 
    $orderId = $uniqid . $randomNumber;
    $orderId = hash('sha256', $orderId);
    $orderId = substr($orderId, 0, 20); 
 
    return strtoupper($orderId); 
}
 
 
 $orderId = generateOrderId('ORD_');
 
 
$food = $_POST['food'];
$price = $_POST['price'];
$qty = $_POST['qty'];
$customer_id=uniqid();
$customer_name=$_POST['full-name'];
$customer_email=$_POST['email'];
$customer_phone=$_POST['contact'];
$customer_address = $_POST['address'];
$orderAmount = $price * $qty;
$order_date =date("Y-m-d h:i:sa");
$status = "Ordered";

 
$paymentSessionId='';
$curl = curl_init();
 
curl_setopt_array($curl, array(
  CURLOPT_URL => $APIURL,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
  "order_id":"'.$orderId.'",
"order_amount": '.$orderAmount.',
"order_currency": "INR",
"customer_details": {
"customer_id": "'.$customer_id.'",
"customer_name": "'.$customer_name.'",
"customer_email": "'.$customer_email.'",
"customer_phone": "'.$customer_phone.'"
},
"order_meta": { 
"return_url": "'.$base_url.'/success.php?order_id='.$orderId.'",
"notify_url":"'.$base_url.'/callback.php",
" payment_methods": "cc,dc,upi"
}
 
}',
  CURLOPT_HTTPHEADER => array(
    'X-Client-Secret: '.secret_key,
    'X-Client-Id: '.client_id,
    'Content-Type: application/json',
    'Accept: application/json',
    'x-api-version: 2023-08-01'
  ),
));
 
$response = curl_exec($curl);
 
curl_close($curl);
//echo $response;
$resData=json_decode($response);
 
 
if(isset($resData->cf_order_id) && $resData->cf_order_id !=''){
    
    $cf_order_id=$resData->cf_order_id;
$order_id=$resData->order_id;
$payment_session_id=$resData->payment_session_id;
    $paymentSessionId=$payment_session_id;
 
    $conn = new mysqli('localhost', 'root', '', 'annapurna');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Insert payment details into the database
    $sql = "INSERT INTO cashfree_payment (order_id, cf_order_id, payment_session_id, customer_id, customer_name, customer_email, customer_phone, order_amount) 
            VALUES ('$order_id', '$cf_order_id', '$payment_session_id', '$customer_id', '$customer_name', '$customer_email', '$customer_phone', '$orderAmount')";
    
    if ($conn->query($sql) === TRUE) {
                    $food = $_POST['food'];
                    $price = $_POST['price'];
                    $qty = $_POST['qty'];

                    $total = $price * $qty;

                    $order_date =date("Y-m-d h:i:sa");

                    $status = "Ordered"; 

                    $customer_name = $_POST['full-name'];
                    $customer_contact = $_POST['contact'];
                    $customer_email = $_POST['email'];
                    $customer_address = $_POST['address'];

                    //save the order in database
                    //create sql to save the data
                    $sql2 = "INSERT INTO tbl_order SET
                        food = '$food',
                        price = $price,
                        qty = $qty,
                        total = $total,
                        order_date = '$order_date',
                        status = '$status',
                        customer_name = '$customer_name',
                        customer_contact='$customer_contact',
                        customer_email='$customer_email',
                        customer_address='$customer_address'
                    ";

                    // echo $sql2; die();

                    //execute the query
                    $res2 = mysqli_query($conn, $sql2);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    // Close the database connection
    $conn->close();
 
}else{
    echo $response;
}
 
?>
 
<?php 
if(isset($paymentSessionId) && $paymentSessionId !=''){ ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <script src="https://sdk.cashfree.com/js/v3/cashfree.js"></script>
    
  </head>
  <body>
    <style>
  body {
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.infoBox {
    background-color: #ffffff;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    padding: 20px 30px;
    max-width: 400px;
    width: 100%;
}

.infoBox h5 {
    text-align: center;
    font-size: 20px;
    color: #333;
    margin-bottom: 20px;
    font-weight: bold;
    text-transform: uppercase;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 10px;
}

td {
    padding: 10px 5px;
    font-size: 14px;
    color: #555;
}

td:first-child {
    font-weight: bold;
    text-align: left;
    width: 40%;
}

td:nth-child(2) {
    text-align: center;
    width: 10%;
    color: #888;
}

td:last-child {
    text-align: right;
}

tr td[colspan="3"] {
    text-align: center;
    padding-top: 15px;
}

button#renderBtn {
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button#renderBtn:hover {
    background-color: #218838;
}

tr td:last-child[style] {
    font-weight: bold;
    color: green;
    font-size: 18px;
}
</style>
      <div class="infoBox">
          <h5>Confirm Your Details</h5>
          <table>
              <tr><td>Name</td><td>:</td><td><?php echo $customer_name;?></td></tr>
              <tr><td>Email</td><td>:</td><td><?php echo $customer_email;?></td></tr>
              <tr><td>Mobile No.</td><td>:</td><td><?php echo $customer_phone;?></td></tr>
              <tr><td>Pay Amount</td><td>:</td><td style="color:green; font-weight:bold;font-size:18px;"><?php echo "Rs. ".$orderAmount;?></td></tr>
              <tr><td colspan="3"><button type="button" id="renderBtn">
      Confirm & Pay
    </button></td></tr>
          </table>
     
    
     </div>
  </body>
  <script>
      const cashfree = Cashfree({
        mode: "<?php echo $payMode?>" //or production,
      });
      document.getElementById("renderBtn").addEventListener("click", () => {
        cashfree.checkout({
          paymentSessionId: "<?php echo $paymentSessionId?>"
        });
      });
  </script>
</html>
 
 
 
<?php } 
}else{
    echo "<h5>Payment request failed</h5>";
}  ?>