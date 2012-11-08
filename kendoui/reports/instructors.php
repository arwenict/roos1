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
        $jsStudiosArray .= "{ text: '{$studio['displayCode']}', value: {$studio['nodeID']} },";
    }
    //$jsStudiosArray = rtrim($jsStudiosArray, ",");
    $jsStudiosArray .= "{text: 'No club selected', value:-1}]";
    
    $db->close();
?>
<!doCTYpe html>
<html>
<head>
	<script src="../js/jquery.min.js"></script>
        <script src="../../custom_lib/shared/jQueryMultiselect/jquery-ui.js"></script>
	<script src="../trial/js/kendo.all.min.js"></script>
        <script src="../../custom_lib/shared/jQueryMultiselect/jquery.multiselect.js"></script>
        <link href="../../custom_lib/shared/jQueryMultiselect/jquery-ui.css" rel="stylesheet">
        <link href="../../custom_lib/shared/jQueryMultiselect/jquery.multiselect.css" rel="stylesheet">
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
                
                a.instr_edit:link, a.instr_edit:hover, a.instr_edit:active, a.instr_edit:visited {height:24px; width:24px; display:block;background:url(../../templates/ifreedom-fjt/images/editLink.png)}
            </style>
	
	<script>
                 var $ = new jQuery.noConflict();
		//kendo.culture("en-US");
  


		$(document).ready(function() {

                    var location_array = <?php echo $jsStudiosArray ?>;

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
                                                            mobile: { type: "string", editable: true },								
                                                            email: { type: "string", editable: true },
                                                            skills: { type: "string", editable: false },
                                                            permcov: { type: "string", editable: false },
                                                            locations: {editable: true },
                                                            edit_link: {editable: false}
                                                    }
                                            }
                                    },
                                    //group: { field: "InstructorName", dir: "asc", aggregates: [
                                    //	{ field: "AttendeeNumber", aggregate: "sum" },
                                    //	{ field: "AttendeeTarget", aggregate: "sum"}]
                                    //},

                            },
                            columns: [
                            { field: "name", title: "Name",  width: 110 },
                            { field: "mobile", title: "Mobile", width: 80, filterable: false }, 
                            { field: "email", title: "Email", width: 160, filterable: false },
                            { field: "skills", title: "Skills", width: 140, filterable: false },     
                            { field: "permcov", title: "Perm / Cover", width: 70, filterable: true },
                            { field: "locations", title: "Locations", width: 100, editor: locationsDropDownEditor, filterable: true},
                            //{ field: "locations", title: "Locations", width: 100, values:location_array, filterable: true},
                            { field: "edit_link", title: "Edit", width: 50, template:"<a href='#=edit_link#' class='instr_edit'></a>", filterable: false}
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
                            filterable: {
				name: "FilterMenu",
				extra: false, // turns on/off the second filter option
				messages: {
					filter: "Go", // sets the text for the "Filter" button
					clear: "Clear" // sets the text for the "Clear" button
				},
				operators: {
					//filter menu for "string" type columns
					string: {
                                                contains: "Contains"
					},
					//filter menu for "number" type columns
					number: {
						contains: "Contains"
					},
					//filter menu for "date" type columns
					date: {
						contains: "Contains"
					}
				}
                            }, 
                            scrollable : true,
                            selectable: "row"
                        });
		
		});


                function locationsDropDownEditor(container, options) {
                    $('<select id="select-channel"><option>sample option</option><option>second sample option</option></select>').appendTo(container);
                    
                    $("#select-channel").multiselect({
                        selectedText: "# of # selected"
                        });
                        
                } 
	</script>   

</body>
</html>