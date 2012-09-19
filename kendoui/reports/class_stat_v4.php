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
                    Pick Date From <input id="datefrom" name="datefrom" value="<?php echo $_GET['datefrom']; ?>" style="width:150px;" /> &nbsp;&nbsp;
                   Pick Date To <input id="dateto" name="dateto" value="<?php echo $_GET['dateto']; ?>" style="width:150px;" /> &nbsp;&nbsp;
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
	
	<script>

			var now = new Date()
		        $("#datefrom").kendoDatePicker({value: new Date(now.getFullYear(), now.getMonth(), 1) , format: "yyyy-MM-dd"});
                	$("#dateto").kendoDatePicker({value: new Date(now.getFullYear(), now.getMonth(), 30), format: "yyyy-MM-dd"});            
                	                   
                        var datepickedfrom = $("#datefrom").val();
                        var datepickedto = $("#dateto").val();                        
                                                
		
		kendo.cultures["en-US"].numberFormat.percent.decimals = 0;

		$(document).ready(function() {

		 	// create DatePicker from input HTML element
  
			$("#grid").kendoGrid({
				
				dataSource: { 
					
					transport: {
						read: "data/class_stat.php?datefrom=" + datepickedfrom + "&dateto=" + datepickedto
							
					},
					error: function(e) {
						alert(e.responseText);
					},
					pageSize: 500,
					
					schema: {
						data: "data",
						model: {
							id: "id",
							fields: {
								ClassName: { editable: false },
								StartDate: { type: "date", editable: false },
                                                                StartTime: { type: "text", editable: false },
								Minutes: { editable: false },
								Location: { editable: false },
								InstructorName: { editable: false},
								//ApprovedByManager: {type: "boolean", editable: false }, 
								AttendeeNumber: {type: "number", editable: false }, 
								AttendeeTarget: {type: "number", editable: false }, 
								Participation: {type: "number", editable: false }, 
								CostPerAttendee: {type: "number", editable: false },
								//HourlyRate: {type: "number", editable: false },
								//TotalPayable: { type: "number",editable: false },
								//Paid: { type: "boolean", editable: false },
							
							}
						},
						
					},
					//group: { 
					//	field: "InstructorName", dir: "desc", aggregates: [
                			//	{ field: "AttendeeNumber", aggregate: "sum" },
                			//	{ field: "AttendeeTarget", aggregate: "sum"}]
    					//},
   					aggregate: [ { field: "AttendeeNumber", aggregate: "average" }, 
					       	     { field: "AttendeeTarget", aggregate: "average" },
    						     { field: "Participation", aggregate: "average" } ]
					
    					
				},
   				
   				
				sortable: true,
    				scrollable: true,
    				groupable: true,
    				pageable: false,
				
				columns: [
				{ field: "ClassName" , title: "Class Name", width: "150px" }, 
				{ field: "StartDate", title: "Start Date", format: "{0:ddd dd-MMM-yyyy}",  width: 100 },
				{ field: "StartTime", title: "Start Time", width: 60 },
				{ field: "Minutes", width: "50px" },
				{ field: "Location", width: "80px"  },
				{ field: "InstructorName" , title: "Instructor Name", width: "120px" }, 
				//{ field: "ApprovedByManager", title: "Ok To Pay", template: "<input type='checkbox' #= (ApprovedByManager === true) ? checked='checked' : '' # disabled />" },
				{ field: "AttendeeNumber", title: "Attendee<br>Number", width: "60px", aggregates: "average", footerTemplate: "Average: #=average#", groupFooterTemplate: "Average: #=average#"}, 
				{ field: "AttendeeTarget", title: "Attendee<br>Target", width: "60px", aggregates: "average", footerTemplate: "Average: #=average#", groupFooterTemplate: "Average: #=average#"},
				{ field: "Participation", title: "Participation", width: "60px", format: "{0:p}", aggregates: "average", footerTemplate: "Average: #=average#", groupFooterTemplate: "Average: #=average#"},
				{ field: "CostPerAttendee", title: "Cost per<br>Attendee", width: "60px", format: "{0:C2}", aggregates: "average", footerTemplate: "Average: #=average#", groupFooterTemplate: "Average: #=average#"}]
				//{ field: "HourlyRate", title: "Hourly<br>Rate", format: "{0:C2}", width: "70" , aggregates: "average", footerTemplate: "Average: #=average#", groupFooterTemplate: "Average: #=average#"}, 
				//{ field: "TotalPayable", title: "Total<br>Payable", format: "{0:C2}", width: "70", aggregates: "sum", footerTemplate: "<div>Total: #=sum#</div>", groupFooterTemplate: "Subtotal: #=sum#"},
				//{ field: "Paid",title: "Paid", width: "70px",  template: "<input type='checkbox' #= (Paid === true) ? checked='checked' : '' # disabled />"}]
				
			});
			
			
	});
	
	</script>

</body>
</html>