<?php 
session_start();
$_userid=$_SESSION['id']?? 0;
if(!$_userid)
{
    header("location:index.php");
    die();

}

$editid=$_GET['editid']?? 0;
require_once "function.php";
include_once 'config.php';
$connection = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
if(!$connection){
  throw new Exception("Cannot connect to database");
}

$query="SELECT * from user_table WHERE id='{$editid}'";
$EditResult=mysqli_query($connection,$query);

?>
<?php if(mysqli_num_rows($EditResult)>0){?>
	<?php while($data=mysqli_fetch_assoc($EditResult)){?>
<div class="container">
  <div class="row">

    <form action="task.php" method="POST">
    	
   <label for="name">Name</label>
    <input type="text" name="name" placeholder="name" value="<?php echo $data['name'] ?>">
    <label for="contact">Contact</label>
    <input type="number" name="contact" placeholder="contact number" value="<?php echo $data['contact'] ?>" >
     <input type="hidden" name="id" value="<?php echo $data['id'] ?>">

     <input type="hidden" name="action" value="edit">

    <button type="submit" btn btn-primary btn-danger> update </button>

</form>

  </div>
</div>
<?php }
} ?>