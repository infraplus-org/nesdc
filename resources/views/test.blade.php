
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>DateTime Picker · Bootstrap - Demo page</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Bootstrap DateTime Picker is a bootstrap twitter component. However it can be implemented on every html form to help datetime typing">
	<meta name="author" content="Sebastien MALOT">

	<link rel="stylesheet" href="{{ asset('Content/Assets/plugins/bootstrap-4.5.3-dist/css/bootstrap.min.css') }}">

	<link rel="stylesheet" href="{{ asset('Content/Assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}">
	<!-- <link rel="stylesheet" href="{{ asset('Content/Assets/plugins/datetimepicker/css/jquery.datetimepicker.min.css') }}"> -->
	<link rel="stylesheet" href="{{ asset('Content/Assets/plugins/bootstrap-datepicker/css/datepicker.css') }}">

	<link rel="stylesheet" href="{{ asset('Content/Assets/css/main.css') }}">
	<link rel="stylesheet" href="{{ asset('Content/Assets/css/hm-style.css') }}">
	<link rel="stylesheet" href="{{ asset('Content/Assets/css/color_skins.css') }}">
	<link rel="stylesheet" href="{{ asset('Content/Assets/css/custom.css') }}">
</head>

<body>


<section>

	Default
	<div class="input-append date form_datetime2">
		<input size="16" type="text" value="" class="form-control">
		<span class="add-on"><i class="icon-th"></i></span>
	</div>

	Show Month-Year
	<div class="input-append date form_datetime3">
		<input size="16" type="text" value="" class="form-control" readonly>
		<span class="add-on"><i class="icon-th"></i></span>
	</div>

	<!-- Show Month-Year
	<input type="text" name="testdate4" id="testdate4" value="" style="width:200px;"> 
	<br/>
	<br/>

	Default
	<input type="text" name="testdate5" id="testdate5" value="" style="width:200px;">   -->

	<input type="text" name="datepicker1" id="datepicker1" value="" style="width:200px;"> 

</section>


<script src="{{ asset('Content/Assets/bundles/jquery-3.5.1.min.js') }}"></script>
<script src="{{ asset('Content/Assets/plugins/bootstrap-4.5.3-dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('Content/Assets/bundles/vendorscripts.bundle.js') }}"></script> <!-- Lib Scripts Plugin Js -->

<script src="{{ asset('Content/Assets/plugins/momentjs/moment.js') }}"></script>
<script src="{{ asset('Content/Assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js?t=20130302') }}"></script>
<script src="{{ asset('Content/Assets/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.th.js?t=20130302') }}" charset="UTF-8"></script>
<!-- <script src="{{ asset('Content/Assets/plugins/datetimepicker/js/jquery.datetimepicker.full.js?t=20130302') }}"></script> -->
<script src="{{ asset('Content/Assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js?t=20130302') }}"></script>
<script src="{{ asset('Content/Assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker-thai.js?t=20130302') }}"></script>
<script src="{{ asset('Content/Assets/plugins/bootstrap-datepicker/js/locales/bootstrap-datepicker.th.js?t=20130302') }}"></script>

<script src="{{ asset('Content/Assets/bundles/mainscripts.bundle.js') }}"></script>
<script src="{{ asset('Content/Assets/bundles/mainscript.page.js') }}"></script>

<script type="text/javascript">
    $(".form_datetime1").datetimepicker({format: 'yyyy-mm-dd hh:ii', forceParse: true});
    var m = moment().add(543, 'year').format('YYYY-MM-DD');
	console.log(m);
    $(".form_datetime2").datetimepicker({
      	format: "yyyy-mm-dd hh:ii",
		language: 'th',
  		autoclose: true,
		todayHighlight: true,
		initialDate: '2564-06-10',
    });
    $(".form_datetime3").datetimepicker({
		format: "MM yyyy",
		autoclose: true,
		startView: 3,
		minView: 3,
		language: 'th',
    });

	$(function(){
		$("#datepicker1").datepicker('show');
		console.log('test');
	});

	// $(function(){
	// 	$("#testdate4").datetimepicker({
	// 		timepicker:false,
	// 		format:'Y-m',  // กำหนดรูปแบบวันที่			
	// 		lang:'th',  // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
	// 		onSelectDate:function(dp,$input){
	// 			var yearT=new Date(dp).getFullYear()-0;  
	// 			var yearTH=yearT+543;
	// 			var fulldate=$input.val();
	// 			var fulldateTH=fulldate.replace(yearT,yearTH);
	// 			$input.val(fulldateTH);
	// 		},
	// 	// กรณีใช้กับ input ต้องกำหนดส่วนนี้ด้วยเสมอ เพื่อปรับปีให้เป็น ค.ศ. ก่อนแสดงปฏิทิน
	// 	}).on("mouseenter mouseleave",function(e){
	// 		var dateValue=$(this).val();
	// 		if(dateValue!=""){
	// 			var arr_date=dateValue.split("-"); // ถ้าใช้ตัวแบ่งรูปแบบอื่น ให้เปลี่ยนเป็นตามรูปแบบนั้น
	// 			// ในที่นี้อยู่ในรูปแบบ 0000-00-00 เป็น Y-m-d  แบ่งด่วย - ดังนั้น ตัวแปรที่เป็นปี จะอยู่ใน array
	// 			// ตัวแรก arr_date[0]
	// 			if(e.type=="mouseenter"){
	// 				var yearT=arr_date[0]-543;
	// 			}		
	// 			if(e.type=="mouseleave"){
	// 				var yearT=parseInt(arr_date[0])+543;
	// 			}	
	// 			dateValue=dateValue.replace(arr_date[0],yearT);
	// 			$(this).val(dateValue);													
	// 		}		
	// 	});

	// 	$("#testdate5").datetimepicker({
	// 		timepicker:false,
	// 		format:'Y-m-d',  // กำหนดรูปแบบวันที่			
	// 		lang:'th',  // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
	// 		onSelectDate:function(dp,$input){
	// 			var yearT=new Date(dp).getFullYear()-0;  
	// 			var yearTH=yearT+543;
	// 			var fulldate=$input.val();
	// 			var fulldateTH=fulldate.replace(yearT,yearTH);
	// 			$input.val(fulldateTH);
	// 		},
	// 	// กรณีใช้กับ input ต้องกำหนดส่วนนี้ด้วยเสมอ เพื่อปรับปีให้เป็น ค.ศ. ก่อนแสดงปฏิทิน
	// 	}).on("mouseenter mouseleave",function(e){
	// 		var dateValue=$(this).val();
	// 		if(dateValue!=""){
	// 			var arr_date=dateValue.split("-"); // ถ้าใช้ตัวแบ่งรูปแบบอื่น ให้เปลี่ยนเป็นตามรูปแบบนั้น
	// 			// ในที่นี้อยู่ในรูปแบบ 0000-00-00 เป็น Y-m-d  แบ่งด่วย - ดังนั้น ตัวแปรที่เป็นปี จะอยู่ใน array
	// 			// ตัวแรก arr_date[0]
	// 			if(e.type=="mouseenter"){
	// 				var yearT=arr_date[0]-543;
	// 			}		
	// 			if(e.type=="mouseleave"){
	// 				var yearT=parseInt(arr_date[0])+543;
	// 			}	
	// 			dateValue=dateValue.replace(arr_date[0],yearT);
	// 			$(this).val(dateValue);													
	// 		}		
	// 	});
	// });
  </script>
</body>
</html>
