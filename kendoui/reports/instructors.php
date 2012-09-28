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
  


		$(document).ready(function() {


                                                
			$("#grid").kendoGrid({
				dataSource: {
					transport: {
						read: "data/instructors.php" ,
						update: {
							url: "data/instructors.php",
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
								name: { editable: true },
								username: { type: "text", editable: false },
                                                                email: { type: "text", editable: false },
                                                                fieldvalue: { type: "text", editable: false }
							}
						}
					},
	                             	//group: { field: "InstructorName", dir: "asc", aggregates: [
                			//	{ field: "AttendeeNumber", aggregate: "sum" },
                			//	{ field: "AttendeeTarget", aggregate: "sum"}]
    					//},
                      
				},
				columns: [
                                { field: "name", title: "Name",  width: 140 }, 
				{ field: "username", title: "Username", width: 100 },
				{ field: "email", title: "Email", width: 140, filterable: false },
				{ field: "fieldvalue", title: "Value", width: 140, filterable: false }                            
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