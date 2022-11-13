<?php 
include('header.php');
$msg="";
$cases_status_id="";
$statement="";
$id="";


if(isset($_POST['submit'])){
	$cases_status_id=get_safe_value($con,$_POST['cases_status_id']);
	$statement=get_safe_value($con,$_POST['statement']);
	$added_on=date('Y-m-d h:i:s');
	
	if($id==''){
		$sql="select * from cases_result where cases_status_id='$cases_status_id' and statement='$statement'";	
	}else{
		$sql="select * from cases_result where cases_status_id='$cases_status_id' and id!='$id'";	
	}
	
	if(mysqli_num_rows(mysqli_query($con,$sql))>0){
		$msg="Decision already added";
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
			mysqli_query($con,"insert into cases_result(cases_id,cases_status_id,statement,status,added_on) values('$did','$cases_status_id','$statement',1,'$added_on')");
			}
		}else{
			$did=get_safe_value($con,$_GET['id']);$did=get_safe_value($con,$_GET['id']);
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
$res_decision=mysqli_query($con,"select * from cases_status order by cases_status desc");
?>
<div class="main-panel">
    <div class="content-wrapper">
		<div class="row">
			<h1 class="grid_title ml10 ml15">Manage Decision</h1>
            <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <form class="forms-sample" method="post">
                    <div class="form-group">
                      <label for="exampleInputName1">Court Decision Types</label>
                      <select name="cases_status_id" id="" class="form-control" required>
						<option value="">Select Court Decision Types</option>
						<?php
							while($row_decision=mysqli_fetch_assoc($res_decision)){
								if($row_decision['id']==$cases_status_id){
									echo "<option value='".$row_decision['id']."' selected>".$row_decision['cases_status']."</option>";
								}else{
									echo "<option value='".$row_decision['id']."'>".$row_decision['cases_status']."</option>";
								}
							}
						?>

					  </select>
                    </div>
					<div class="form-group">
                      <label for="exampleInputName1" required>Statement</label>
                      <textarea name="statement" id="" class="form-control" placeholder="Court Decision statement" ><?php echo $statement?></textarea>
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