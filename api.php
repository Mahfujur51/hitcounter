<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "api_db";

// Create connection
$conn= mysqli_connect($servername,$username,$password,$dbname);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}else{
    $company=$_GET['company'];
    switch ($company) {
        case "read":
          $sql= "SELECT * FROM tbl_visit";
          $result=mysqli_query($conn,$sql);
          if(mysqli_num_rows($result)>0){
            while( $row = mysqli_fetch_assoc($result)){
                 
                   
            }
            
          }
          break;
    
        default:
        $sql = "SELECT * FROM tbl_visit WHERE company='$company'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
                 $company = $row['company'];
                 $count   = $row['count'];
                 $url     = $row['url'];
                 $usql ="UPDATE tbl_visit SET count=$count+1 WHERE company='$company'";
                 $up_result=mysqli_query($conn,$usql);
                 if($up_result){
                     $company_url="$url";
                    header("Location: $company_url");  
                 }
            }
          } else {
            echo "0 results";
          }
      }


    

}

?>