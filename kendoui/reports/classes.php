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
        <form id="target" action="classes.php" method="get">
            
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
	
	<script>


		//kendo.culture("en-US");
			var now = new Date()
		        $("#datefrom").kendoDatePicker({value: datepickedfrom , format: "yyyy-MM-dd"});
                	$("#dateto").kendoDatePicker({value: datepickedto , format: "yyyy-MM-dd"});             
                        var datepickedfrom = $("#datefrom").val();
                        var datepickedto = $("#dateto").val();




		$(document).ready(function() {


                                                
			$("#grid").kendoGrid({
				dataSource: {
					transport: {
						read: "data/classes.php?datefrom=" + datepickedfrom + "&dateto=" + datepickedto ,
						update: {
							url: "data/classes.php",
							type: "POST"
						}		
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
								InstructorName: { editable: false},
								Minutes: { editable: false},
								HourlyRate: { type: "number", validation: { required: true, min: 0} },
								AttendeeNumber: { type: "number", validation: { required: true, min: 0} },
								AttendeeTarget: { type: "number", validation: { required: true, min: 0} }, 
								ApprovedByManager:  { type: "boolean" }
							}
						}
					},
	                             	//group: { field: "InstructorName", dir: "asc", aggregates: [
                			//	{ field: "AttendeeNumber", aggregate: "sum" },
                			//	{ field: "AttendeeTarget", aggregate: "sum"}]
    					//},
                      
				},
				columns: [{ field: "ClassName", title: "Class Name",  width: 140 }, 
				{ field: "StartDate", title: "Start Date", format: "{0:ddd dd-MMM-yyyy}",  width: 100 },
				{ field: "StartTime", title: "Start Time", width: 60, filterable: false },
				{ field: "Location" }, 
				{ field: "InstructorName", title: "Instructor Name", width: 100  }, 
				{ field: "Minutes", width: 60 },
				{ field: "HourlyRate" , title: "Hourly Rate", format:"{0:c2}", filterable: false},
				{ field: "AttendeeNumber" , title: "Attendees" },
				{ field: "AttendeeTarget" , title: "Target" },
				{ field: "ApprovedByManager", title: "Ok To Pay", template: "<input type='checkbox' #= (ApprovedByManager === true) ? checked='checked' : '' # disabled />" }
                                ],
				toolbar: [ 
				
				        { name: "save", text: "Save changes" },
         				{ name: "cancel", text: "Cancel changes" }
     				],
				

				//detailTemplate: kendo.template($("#template").html()),
				//template: "<input type='checkbox' id='ApprovedByManager' checked='${ApprovedByManager}' />"
                //detailInit: detailInit,
                editable: true,
                navigatable: true,
                groupable: false,
                filterable: true, 
                scrollable : true,
                selectable: "row",
			});
		
		});


	</script>

</body>
</html>