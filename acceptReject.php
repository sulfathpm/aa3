<?php
    
    if($_SERVER["REQUEST_METHOD"] == "GET"){
        $conn = mysqli_connect("localhost", "root", "", "fashion");
        //error_reporting(0);

        $key=$_GET['key'];
        $comment_id=$_GET['id'];
        if($key=='accept'){
            $sql="UPDATE comments SET READ1='ACCEPTED' WHERE COMMENT_ID='$comment_id'";
            $data=mysqli_query($conn,$sql);
            if($data){
                header("location:communications.php");
            }
        }

        if($key=='reject'){
            $sql="UPDATE comments SET READ1='REJECTED' WHERE COMMENT_ID='$comment_id'";
            $data=mysqli_query($conn,$sql);
            if($data){
                header("location:communications.php");
            }
        }
    
        
    
    }
    

?>