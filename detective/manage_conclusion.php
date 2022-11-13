<?php 
include('header.php');
$msg="";
$investigation="";
$invest_statement="";
$id="";



if(isset($_POST['submit'])){
	$investigation=get_safe_value($con,$_POST['investigation']);
	$invest_statement=get_safe_value($con,$_POST['invest_statement']);
	$added_on=date('Y-m-d h:i:s');
	
	if($id==''){
		$did=get_safe_value($con,$_GET['id']);
		$sql="select * from cases_invest where invest_statement='$invest_statement' and cases_id='$did' ";	
	}else{
		$did=get_safe_value($con,$_GET['id']);
		$sql="select * from cases_invest where invest_statement='$invest_statement' and cases_id='$did' and id!='$id'";	
	}
	
	if(mysqli_num_rows(mysqli_query($con,$sql))>0){
		$msg="Investigation already added";
	}else{
		if($id==''){
			$did=get_safe_value($con,$_GET['id']);
			$file=$_FILES["file"]["name"];
			$tmp_name=$_FILES["file"]["tmp_name"];
			$path=FILE_SITE_PATH.$file;
			$file1=explode(".",$file);
			$ext=$file1[1];
			$allowed=array("jpg","png","gif","pdf","wmv","pdf","zip");
			if(in_array($ext,$allowed))
			{
			move_uploaded_file($tmp_name,$path);
			mysqli_query($con,"insert into cases_invest(cases_id,invest_statement,file,status,added_on) values('$did','$invest_statement','$file',1,'$added_on')");
			mysqli_query($con,"update cases set investigation='$investigation' where id='$did'");
			}
		}else{
			$file_condition='';
			$did=get_safe_value($con,$_GET['id']);
			if($_FILES['file']['name']!=''){
                $file=$_FILES["file"]["name"];
				$tmp_name=$_FILES["file"]["tmp_name"];
				$path=FILE_SITE_PATH.$file;
				$file1=explode(".",$file);
				$ext=$file1[1];
				$allowed=array("jpg","png","gif","pdf","wmv","pdf","zip");
			    if(in_array($ext,$allowed))
				{
				move_uploaded_file($tmp_name,$path);
				$file_condition=", file='$file'";
				}
            }
			mysqli_query($con,"update cases_invest set invest_statement='$invest_statement' $file_condition  where cases_id='$did'");
		}
		
		redirect('case.php');
	}
}
?>
<div class="main-panel">
    <div class="content-wrapper">
		<div class="row">
			<h1 class="grid_title ml10 ml15">Manage Investigation</h1>
            <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <form class="forms-sample" method="post" enctype="multipart/form-data">
				  	<div class="form-group">
					  <input type="hidden" id="investigation" name="investigation" value="yes">
                    </div>
					<div class="form-group">
                      <label for="exampleInputName1" required>Statement</label>
                      <textarea name="invest_statement" id="" class="form-control" placeholder="Court Decision statement" ><?php echo $invest_statement?></textarea>
                    </div>
					<div class="form-group">
                      <label for="exampleInputName1" required>File</label>
					  <input type="file" name="file" class="form-control" placeholder="Defendent Image" >
                    </div>
                    <button type="submit" class="btn btn-primary mr-2" name="submit">Submit</button><br>
					<span class="error mt8"><?php echo $msg ?></span>
                  </form>
                </div>
              </div>
            </div>
            
		 </div>
        <style>
			.error{
				color:red;
			}
			.mt8{
				margin-top:8px;
			}
		</style>
<?php include('footer.php');?>