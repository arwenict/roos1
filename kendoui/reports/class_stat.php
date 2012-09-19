<!doCTYpe html>
<html>
<head>
	<script src="../js/jquery.min.js"></script>
	<script src="../trial/js/kendo.all.min.js"></script>
	<link href="../styles/kendo.common.min.css" rel="stylesheet">
	<link href="../styles/kendo.silver.min.css" rel="stylesheet">
</head>
<body>

        <div id="example" class="k-content">
        <form id="target" action="class_stat.php" method="get">
            
            <div id="classesDB">
            <div style="margin-top: -6px; ">
                   Pick Date From <input id="datefrom" name="datefrom" value="<?php echo ($_GET['datefrom']=='') ? date('Y-m-d', mktime(0,0,0,date('m'),1)) : $_GET['datefrom']; ?>" style="width:150px;" /> &nbsp;&nbsp;
                   Pick Date To <input id="dateto" name="dateto" value="<?php echo ($_GET['dateto']=='') ? date('Y-m-d', mktime(0,0,0,date('m')+1,1)-1) : $_GET['dateto']; ?>" style="width:150px;" /> &nbsp;&nbsp;
                    <button id="submit" name="submit" type="submit" value="show">Show</button>
            </div>
                </br></br>


                <div id="grid" style="height: 580px"></div>

            </div>
        </form>
        </div>
            <style scoped>
                #classesDB{
                    width: 900px;
                    height: 650px;
                    font-family: Tahoma, Verdana, sans-serif; font-size:10px;
                    //margin: 30px auto;
                    //padding: 51px 4px 0 4px;
                    //background: url('../grid/clientsDb.png') no-repeat 0 0;
                }
            </style>
	
<script id="rowTemplate" type="text/x-kendo-tmpl">
   <tr>
      <td>${ ClassName } </td>
      <td>${ kendo.toString(StartDate,"ddd dd-MMM-yyyy") } </td>
      <td>${ StartTime} </td>
      <td>${ Location } </td>
      <td>${ Minutes } </td>
      <td>${ InstructorName } </td>
      <td>${ AttendeeNumber } </td>
      <td>${ AttendeeTarget } </td>
       # if (Participation < "0.3" && Participation > 0) {  #
      <td style="background-color:rgb(255,84,104)"> ${ (Participation*100).toFixed(0) } % </td>
       # } else { #
		# if (Participation < "0.7" && Participation > 0) {  #
	      	<td style="background-color:rgb(250,190,77)"> ${ (Participation*100).toFixed(0) } % </td>
		# } else { #      
			# if (Participation >= "0.7" && Participation > 0) {  #        
      	   		<td style="background-color:rgb(77,250,144)"> ${ (Participation*100).toFixed(0) } % </td>
       			# } else { #
       			<td></td>
       		 	# } #
		# } #
	# } #
         
       # if (CostPerAttendee > "10") {  #
        <td style="background-color:rgb(255,84,104)">$ ${ CostPerAttendee.toFixed(2) } </td>
       # } else { #
       		# if (CostPerAttendee >"5") {  #
        	<td style="background-color:rgb(250,190,77)">$ ${ CostPerAttendee.toFixed(2) } </td> 
         	# } else { #	
       			# if (CostPerAttendee >"0.0001") {  #
       			<td style="background-color:rgb(77,250,144)">$ ${ CostPerAttendee.toFixed(2) } </td>
       			# } else { #
       			<td></td>
       			# } #
       		# } #
       # } #
   </tr>
</script>	
	
	<script>




	


		//kendo.culture("en-US");
			var now = new Date()
		        $("#datefrom").kendoDatePicker({value: datepickedfrom , format: "yyyy-MM-dd"});
                	$("#dateto").kendoDatePicker({value: datepickedto, format: "yyyy-MM-dd"});       
                	                   
                        var datepickedfrom = $("#datefrom").val();
                        var datepickedto = $("#dateto").val();   

		kendo.cultures["en-US"].numberFormat.percent.decimals = 0;

		$(document).ready(function() {


                                                
			$("#grid").kendoGrid({
				dataSource: {
					transport: {
						read: "data/class_stat.php?datefrom=" + datepickedfrom + "&dateto=" + datepickedto ,
		
					},
					error: function(e) {
						alert(e.responseText);
					},
					schema: {
						data: "data",
						model: {
							id: "id",
							fields: {
								ClassName: { editable: false },
								StartDate: { type: "date", editable: false },
                                                                StartTime: { type: "text", editable: false },
								Location: { editable: false },
								Minutes: { editable: false },
								InstructorName: { editable: false},
								AttendeeNumber: {type: "number", editable: false }, 
								AttendeeTarget: {type: "number", editable: false }, 
								Participation: {type: "number", editable: false }, 
								CostPerAttendee: {type: "number", editable: false },
							}
						}
					},
	                             	//group: { field: "InstructorName", dir: "asc", aggregates: [
                			//	{ field: "AttendeeNumber", aggregate: "sum" },
                			//	{ field: "AttendeeTarget", aggregate: "sum"}]
    					//},
                      
				},
				
				columns: [
				{ field: "ClassName", title: "Class Name",  width: "140px" }, 
				{ field: "StartDate", title: "Start Date", format: "{0:ddd dd-MMM-yyyy}",  width: 100 },
				{ field: "StartTime", title: "Start Time", width: 60, filterable: false },
				{ field: "Location", width: "80px"}, 
				{ field: "Minutes", width: "50px", filterable: false},    //, template: formatAmount },
				{ field: "InstructorName", title: "Instructor Name", width: 100  }, 
				{ field: "AttendeeNumber", title: "Attendee<br>Number", width: "60px", aggregates: "average", footerTemplate: "Average: #=average#", groupFooterTemplate: "Average: #=average#"}, 
				{ field: "AttendeeTarget", title: "Attendee<br>Target", width: "60px", aggregates: "average", footerTemplate: "Average: #=average#", groupFooterTemplate: "Average: #=average#"},
				{ field: "Participation", title: "Participation", width: "60px", format: "{0:p}", aggregates: "average", footerTemplate: "Average: #=average#", groupFooterTemplate: "Average: #=average#"},
				{ field: "CostPerAttendee", title: "Cost per<br>Attendee", width: "60px", format: "{0:C2}", aggregates: "average", footerTemplate: "Average: #=average#", groupFooterTemplate: "Average: #=average#"}
                                ],
				

				//detailTemplate: kendo.template($("#template").html()),
				//template: "<input type='checkbox' id='ApprovedByManager' checked='${ApprovedByManager}' />"
                //detailInit: detailInit,
                editable: false,
                navigatable: true,
                groupable: false,
                filterable: true,
                pageable: false, 
                scrollable : true,
                selectable: "row",
                rowTemplate: kendo.template($("#rowTemplate").html()),
			});
		
		});


	</script>

</body>
</html>