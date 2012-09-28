<?php
define( '_JEXEC', 1 );
define( '_VALID_MOS', 1 );
define('JPATH_BASE', '../../../../');
define( 'DS', DIRECTORY_SEPARATOR );
require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );

/* Create the Application */
$mainframe =& JFactory::getApplication('site');
$mainframe->initialise();

JPluginHelper::importPlugin('system');
$mainframe->triggerEvent('onAfterInitialise');

/* Make sure we are logged in at all. */
if (JFactory::getUser()->id == 0)
   die("You have to be logged in.");
?> 

<!doCTYpe html>
<html>
<head>
	<script src="../../../js/jquery.min.js"></script>
	<script src="../../../trial/js/kendo.all.min.js"></script>
	<link href="../../../styles/kendo.common.min.css" rel="stylesheet">
	<link href="../../../styles/kendo.silver.min.css" rel="stylesheet">
</head>
<body>
	<div id="grid" class="k-content"></div>
		<div id="classesDB">
			<div style="margin-bottom: 10px;">

    		        </div>
			<div class="subgrid"></div>
			
		</div>
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
                   #grid{
                    width: 900px;
                    height: 650px;
                    font-family: Tahoma, Verdana, sans-serif; font-size:10px;
                    //margin: 30px auto;
                    //padding: 51px 4px 0 4px;
                    //background: url('../grid/clientsDb.png') no-repeat 0 0;
                }
            </style>
     

	<script>

		$(function() {
			$("#grid").kendoGrid({
				dataSource: {
					transport: {
						read: "data/invoice_report.php",
						update: {
							url: "data/invoice_report.php",
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
								InstructorName: { editable: false},
								NumberOfClasses: { editable: false},
								ApprovedByManager: {   editable: false}, 
								TotalHours: { type: "number", editable: false},
								TotalPayable: { type: "number", editable: false}
							}
						}
					}
				},
				columns: [{ field: "InstructorName",
					    title: "Instructor Name", 
                                            width: 150   }, 
				{ field: "NumberOfClasses",
				  title: "# of Classes", 
                                  width: 110   }, 
				{ field: "ApprovedByManager",
				  title: "Approved<br>by Manager", 
                                  width: 150   }, 
				{ field: "TotalHours",
				  format:"{0:c2}" }, 
				{ field: "TotalPayable",
				  format:"{0:c2}" }],
				 //toolbar: [ "save", "cancel", "destroy"],
				//detailTemplate: kendo.template($("#template").html()),
               //detailInit: detailInit,
                //editable: true,
                //navigatable: true,
                //groupable: true,
                filterable: true,
                scrollable: false,
    		pageable: false,
			});
			
			function detailInit(e) {
				// get a reference to the current row being initialized
				var detailRow = e.detailRow;

				// create the datasource
				classesDS = new kendo.data.DataSource({
					transport: {
						read: "data/invoice_details.php?EmployeeID=" + e.data.InstructorId + "&Approved=" + e.data.ApprovedByManager
					},
					schema: {
						data: "data",
						model: {
							id: "id"
						}
					}
				});
			
				
				// create the autocomplete
				detailRow.find(".comboBox").kendoComboBox({
					dataSource: territoriesDS,
					dataTextField: "TerritoryDescription",
					dataValueField: "TerritoryID"			
				});	

				employeeTerritoriesDS = new kendo.data.DataSource({
					transport: {
						read: "data/employeeTerritories.php",
						create: {
							url: "data/employeeTerritories.php",
							type: "PUT"
						}
					},	
					schema: {
					data: "data",
					model: {
						id: "EmployeeTerritoryID",
							fields: {
								EmployeeID: { editable: false },
								TerritoryDescription: { validation: { required: true } }
							}
						}
					},
					serverFiltering: true,
					filter: { field: "EmployeeID", operator: "eq", value: e.data.EmployeeID }
				});
				
				// create a subgrid for the current detail row, getting territory data for this employee
				detailRow.find(".subgrid").kendoGrid({
					dataSource: classesDS ,
					columns: [{ title: "Class", field: "ClassName" },
    					          { title: "Location", field: "Location" },
    					          { title: "Start Date", field: "StartDate" },
    					          { title: "End Date", field: "End Date" }
					
					],
					//toolbar: [ "save" ]
				});
			}
		});

		var addTerritory = function(sender) {

			// get the employee id off the data-employee-id attribute of the button
			var employeeId = $(sender).data("employee-id");

			// get a reference to the combobox which contains the selected item 
			var comboBox = $("#territory_" + employeeId).data("kendoComboBox");
			
			// add the item to the datasource - it is thusly added to the grid
			employeeTerritoriesDS.add({ EmployeeID: employeeId, TerritoryDescription: comboBox.text(), TerritoryID: comboBox.value() });

			// remove the current item from the combobox - it's no longer a valid selection
			territoriesDS.remove(comboBox.value());

			// clear the text of the combobox
			comboBox.text("");
		}
		
	</script>
</body>
</html>