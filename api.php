<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "elit_hitcount";

// Create connection
$conn= mysqli_connect($servername,$username,$password,$dbname);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}else{
    $companies=array();
    $response=["error"=>false];
    $company=$_GET['company'];
    switch ($company) {
        //read Database data
        case "read":
          $sql= "SELECT * FROM tbl_visit";
          $result=mysqli_query($conn,$sql);
          if(mysqli_num_rows($result)>0){
            while( $row = mysqli_fetch_assoc($result)){
                array_push($companies,$row);
            }
          }
          $response['companies']=$companies;
          break;
          //end read database data

        //start insert data
        case "insert":
            $company     = $_POST['company'];
            $company_url = $_POST['company_url'];
            $sql="INSERT INTO tbl_visit(company,company_url) VALUES('$company','$company_url')";
            $result =mysqli_query($conn,$sql);
            if ($result){
                $response["messsage"]="Data Save Successfully!!";
            }else{
                $response["messsage"]="Data Not save successfully!!!";
            }
            break;

        case "delete":
            $id     = $_POST['id'];
            $sql="DELETE  FROM tbl_visit WHERE id='$id'";
            $result =mysqli_query($conn,$sql);
            if ($result){
                $response["messsage"]="Data Deleted  Successfully!!";
            }else{
                $response["messsage"]="Data Not Deleted successfully!!!";
            }
            break;
        case "update":
            $id     = $_POST['id'];
            $company= $_POST['company'];
            $company_url= $_POST['company_url'];
            $sql = "UPDATE tbl_visit  SET company='$company',company_url='$company_url' WHERE id='$id'";
            $result =mysqli_query($conn,$sql);
            if ($result){
                $response["messsage"]="Data updated  Successfully!!";
            }else{
                $response["messsage"]="Data Not Updated successfully!!!";
            }
            break;
        //end insert data
        default:
        $sql = "SELECT * FROM tbl_visit WHERE company='$company'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
                 $company  =  $row['company'];
                 $count    =  $row['visit_count'];
                 $company_url     =  $row['company_url'];
                 $usql     = "UPDATE tbl_visit SET visit_count=$count+1 WHERE company='$company'";
                 $up_result=mysqli_query($conn,$usql);
                 if($up_result){
                     $url="$company_url";
                    header("Location: $url");
                 }
            }
          } else {
             header("Location:index.html");
          }
      }
}
header('Content-Type: application/json');
echo json_encode($response);

?>