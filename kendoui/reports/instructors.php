<?php
    ini_set("display_errors", 1);
    ini_set('include_path', '/var/www/roos1/custom_lib/');
    include_once("core/dbTools.php");
    include_once("classes/locations.class.php");

    $db = new DBHandler();
    $db->connect();
    
    $locations = new Locations($db);
    
    $studios = $locations->getAllStudios();
    
    $jsStudiosArray = "[";
    
    foreach ($studios as $studio) {
        $jsStudiosArray .= "{ text: '{$studio['displayCode']}', value: '{$studio['nodeID']}' },";
    }
    $jsStudiosArray = rtrim($jsStudiosArray, ",");
    $jsStudiosArray .= "]";
    
    $db->close();
?>
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

                <div id="dropDown"></div>
            <div id="grid" style="height: 580px"></div>

            </div>
        </form>
        </div>
            <style scoped>
                #classesDB{
                    width: 900px;
                    height: 650px;
                    font-family: Tahoma, Verdana, sans-serif; font-size:12px;
                    //margin: 30px auto;
                    //padding: 51px 4px 0 4px;
                    //background: url('../grid/clientsDb.png') no-repeat 0 0;
                }
            </style>
	
	<script>

		//kendo.culture("en-US");
  


		$(document).ready(function() {
                        $('#dropDown').kendoDropDownList({
                            autoBind: true,
                            dataTextField: "text",
                            dataValueField: "value",
                            dataSource: {
                                transport: {
                                    read: "data/dataHandler.php?type=locations"
                                }
                            }
                        });

                        var locations = <?php echo $jsStudiosArray ?>;
                                                
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
                                                                mobile: { type: "text", editable: true },								
                                                                email: { type: "text", editable: true },
                                                                skills: { type: "text", editable: false },
                                                                permcov: { type: "text", editable: false },
                                                                locations: { type: "text", editable: true }
							}
						}
					},
	                             	//group: { field: "InstructorName", dir: "asc", aggregates: [
                			//	{ field: "AttendeeNumber", aggregate: "sum" },
                			//	{ field: "AttendeeTarget", aggregate: "sum"}]
    					//},
                      
				},
				columns: [
                                { field: "name", title: "Name",  width: 120 },
				{ field: "mobile", title: "Mobile", width: 80, filterable: false }, 
				{ field: "email", title: "Email", width: 180, filterable: false },
				{ field: "skills", title: "Skills", width: 140, filterable: false },     
				{ field: "permcov", title: "Perm / Cover", width: 70, filterable: true },
				{ field: "locations", title: "Locations", width: 100, values:locations} 
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
                selectable: "row"
			});
		
		});

	</script>

</body>
</html>