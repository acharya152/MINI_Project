<?php 
	session_start();
	if(!isset($_SESSION['logged'])){
 		header("Location:./loginform.php");

 	}
	// include("barcodegenerateforbook.php");
 	
$host="localhost";
$user="root";
$password="";
$db="libraryms";
						

$con=mysqli_connect($host,$user,$password,$db);
		if(!$con){
		echo "Not connected".mysqli_connect_error();
				}
						
		else{			
					// echo"hello";
					$sid=$_SESSION['passstudentid'];
					$sname=$_POST['bname'];
					$contact=$_POST['contact'];
					$_SESSION['Ccontact']=$contact;
					$depart=$_POST['dept'];
					$year=$_POST['year'];
					

					$filename=$sname."_".$contact."_".$sid;
					include("validatephone.php");



	if(isset($_SESSION['dberror'])){
		header("location:".$_SERVER['HTTP_REFERER']);
	}else{


				$sql="insert into student_data values('$sid','$sname','$contact','$year','$depart',0)"; 
				try{
				$checkindb=mysqli_query($con,$sql);
					if(!$checkindb){
						$_SESSION['errorMsg']="true";
						throw new Exception(mysqli_error($con));
					
					}else{

						$_SESSION['issueSucess']="true";
					}
				}
				catch(Exception $e){
					$_SESSION['dberror']= $e->getMessage();
					header("location:".$_SERVER['HTTP_REFERER']);
					
				}	
			
							



					
			 }
			}




?> 		

<html>
	<head>
		<title>Insert A Student</title>
	<script src="barcodescript.js"></script>
	<link rel="stylesheet" type="text/css" href="displaybarcode.css">
	<style type="text/css">
      @media print {
   p{
   	display: none;
   }

   
    
  }
</style>
	</head>
	<script>

	function downloadSVGAsText() {

const svg = document.querySelector('svg');
// const b = btoa(decodeURI(encodeURIComponent(svg.outerHTML)));
const b = btoa(svg.outerHTML);

const a = document.createElement('a');
const e = new MouseEvent('click');
a.download = 'yunil.svg';
a.href = 'data:image/svg+xml;base64,' + b;
a.dispatchEvent(e);
}
</script>

	<body>
	<div class="print-area">
	 <svg id="barcode"  onclick="downloadSVGAsText();window.print()"></svg>
		<script type="text/javascript">
				JsBarcode("#barcode","<?php echo("$sid") ?>");
		</script>

		<p><b>CLICK ON THE BARCODE TO PRINT IT!!</b></p>							

								   
								      

	</div>

	</body>
</html>

<!--  -->