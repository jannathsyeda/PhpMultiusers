<?php 
session_start();
$_userid=$_SESSION['id']?? 0;
if(!$_userid)
{
    header("location:index.php");
    die();

}

$sessionid=$_SESSION['id']?? 0;
require_once "function.php";
include_once 'config.php';
$connection = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
if(!$connection){
  throw new Exception("Cannot connect to database");
}

$query="SELECT * from user_table ";
$result=mysqli_query($connection,$query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <link rel="stylesheet" href="//cdn.rawgit.com/necolas/normalize.css/master/normalize.css">
    <link rel="stylesheet" href="//cdn.rawgit.com/milligram/milligram/master/dist/milligram.min.css">
    <style>
        body {
            margin-top: 30px;
        }

        #main {
            padding: 0px 150px 0px 150px;;
        }

        #action {
            width: 150px;
        }
    </style>
</head>
<body>
<h1 style="text-align: center;"></h1>


<?php if(mysqli_num_rows($result)>0){?>
<div class="container">
  <div class="row">
      <form>
            <table>
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Contact</th>
                    <th>Status</th>
                   <?php
                   $status=getStatusIdForAction($sessionid) ;
                   if('1'==$status || '3'==$status){

                   ?>
                  <th>Action</th>
                   
            <?php }?>
          

                 
                </tr>
              </thead>
              <tbody>

                  <?php while($data=mysqli_fetch_assoc($result)) {?>

                <tr>
                   <td>
                    <?php echo $data['id'] ;?>
                  </td>
                  <td>
                    <?php echo $data['name'] ;?>
                  </td>
                  <td>
                     <?php echo $data['contact'] ;?>

                  </td>

                    <?php 
                  $id=$data['id'];
                    $id = getStatusIdForStatusField($id);
                    if('1'== $id || '2' == $id){
                ?>
                <td style="background-color: #ff2929;">Admin</td>

              <?php } if('3' ==$id){?>

                    <td style="background-color: #47cd39;">member</td>


              <?php }?>


               
                  <?php 
                  $status=getStatusIdForAction($sessionid) ;
                   if('1'==$status ){


                  ?>
                 <td>
                    <a onclick="return confirm('Are you sure?')" href="delete.php?id=<?php echo $data['id']?>">DELETE</a>

                    |<a href="edit.php?editid=<?php echo $data['id']?>">Edit</a>

                      <?php if($data['status'] == '2' ){ ?>
                        |<a href="#" onclick="return confirm('Are you sure to make him as Member?')" class="btn btn-success member" data-taskid="<?php echo $data['id'] ?>">Make as member</a><?php }
                        elseif($data['status'] == '1'){?>
                          |<a href="#" onclick="alert('He is SUPER ADMIN. He can\'t move to member.');" class="btn btn-success" >Make as member</a>
                        <?php }
                        else{?>

                          |<a href="#" onclick="return confirm('Are you sure to make him as Admin?')" class="btn btn-success admin" data-taskid="<?php echo $data['id'] ?>">Make as admin</a>

                        <?php } ?>
                  </td>
                <?php } ?>


              
                  

              



                       



                </tr>
              <?php }?>
           
              </tbody>
            </table>
      </form>
  </div>
</div>
<?php } ?>
<hr>

<?php
$added=$_GET['added']??0;
if($added)
{
  echo "added successfully!";

}
?>
<div class="container">
  <div class="row">
    <form action="task.php" method="POST">
   <label for="name">Name</label>
    <input type="text" name="name" placeholder="name" >
    <label for="contact">Contact</label>
    <input type="number" name="contact" placeholder="contact number" >
     <input type="hidden" name="action" value="insert">
    <button type="submit" btn btn-primary btn-danger> add </button>

</form>

  </div>
</div>


<h1><a href="logout.php">Logout</a></h1>

   <form  method="POST" id="makeAdminForm" action="task.php">
      <input type="hidden" name="action" value="adminRequest">
      <input type="hidden" id="adminReqId" name="taskid">
  </form>

  <form  method="POST" id="makeMemberForm" action="task.php">
      <input type="hidden" name="action" value="memberRequest">
      <input type="hidden" id="memberReqId" name="taskid">
  </form> 


<script src="//code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<!---<script src="assets/js/script.js"></script>-->

</body>
<script>
  ;(function ($) {
    $(document).ready(function () {
        $("#login").on('click', function () {
            $("#form01 h3").html("Login");
            $("#action").val("login");
        });

        $("#Registretion").on('click', function () {
            $("#form01 h3").html("Register");
            $("#action").val("Registretion");
        });

        $(".admin").on('click',function(){
           
                var id = $(this).data("taskid");
                $("#adminReqId").val(id);
                $("#makeAdminForm").submit();
          });


        $(".member").on('click',function(){
                var id = $(this).data("taskid");
                $("#memberReqId").val(id);
                $("#makeMemberForm").submit();
          });


        
        })
    })
(jQuery);
</script>

</html>
