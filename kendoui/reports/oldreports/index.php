

<!doCTYpe html>
<html>
<head>
	<link href="css/kendo.default.min.css" rel="stylesheet">
	<link href="css/kendo.common.min.css" rel="stylesheet">

	<script src="js/jquery.min.js"></script>
	<script src="js/kendo.all.min.js"></script>
</head>
<body>
	<div id="grid"></div>
	<script type="text/x-kendo-template" id="template">
		<div>
			<div style="margin-bottom: 10px;">
				<input id="pr_community_events_#= data.InstructorID #"  class="comboBox" />
				<button class="k-button add-territory" data-employee-id="#= data.id #"
						onclick="addTerritory(this)" >Add</button>
    		</div>
			<div class="subgrid"></div>
			
		</div>
    </script>
	<script>

		$(function() {
			$("#grid").kendoGrid({
				dataSource: {
					transport: {
						read: "data/events.php",
						update: {
							url: "data/events.php",
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
								StartDate: { editable: false },
								EndDate: { editable: false },
								Location: { editable: true },
								InstructorName: { editable: false},
								HourlyRate: { editable: true },
								Hours: { editable: true },
								TotalPayable: { editable: true },
								ApprovedByManager: { editable: true }, 
								AtendeeNumber: { editable: true }, 
								Paid: { editable: true }, 
								BankTransactionID: { editable: true }
							}
						}
					}
				},
				columns: [{ field: "ClassName" }, { field: "StartDate" },{ field: "EndDate" },{ field: "Location" }, { field: "InstructorName" }, 
				{ field: "HourlyRate" }, { field: "Hours" }, { field: "TotalPayable" },
				{ field: "ApprovedByManager" },{ field: "AtendeeNumber" },{ field: "Paid" }, { field: "BankTransactionID" }],
				toolbar: [ "save", "cancel", "destroy"],
				//detailTemplate: kendo.template($("#template").html()),
                //detailInit: detailInit,
                editable: true,
                navigatable: true,
                groupable: true,
                filterable: true
			});
			
			function detailInit(e) {
				// get a reference to the current row being initialized
				var detailRow = e.detailRow;

				// create the datasource
				territoriesDS = new kendo.data.DataSource({
					transport: {
						read: "data/territories.php?EmployeeID=" + e.data.EmployeeID
					},
					schema: {
						data: "data",
						model: {
							id: "TerritoryID"
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
					dataSource: employeeTerritoriesDS,
					columns: [{ title: "Territories", field: "TerritoryDescription" }, { command: "destroy" }],
					toolbar: [ "save" ]
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