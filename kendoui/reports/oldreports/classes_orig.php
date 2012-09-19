<!doCTYpe html>
<html>
<head>
	<link href="css/kendo.default.min.css" rel="stylesheet">
	<link href="css/kendo.common.min.css" rel="stylesheet">

	<script src="js/jquery.min.js"></script>
	<script src="js/kendo.all.min.js"></script>

	<script>

		$(document).ready(function() {
			$("#grid").kendoGrid({
				dataSource: {
					transport: {
						read: "data/classes.php",
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
								StartDate: { editable: false },
								Location: { editable: false },
								InstructorName: { editable: false},
								Minutes: { editable: false},
								HourlyRate: { type: "number", validation: { required: true, min: 1} },
								AtendeeNumber: { type: "number", validation: { required: true, min: 1} }, 
								ApprovedByManager:  { type: "boolean" }
							}
						}
					}
				},
				columns: [{ field: "ClassName" }, { field: "StartDate" },{ field: "Location" }, { field: "InstructorName" }, 
				{ field: "Minutes" },
				{ field: "HourlyRate" , title: "Hourly Rate", format: "{0:c}", width: "150px" },
				{ field: "AtendeeNumber" , title: "Attendee", width: "100px" },
				{ field: "ApprovedByManager"}],
				toolbar: [ "save", "cancel", "destroy"],
				//detailTemplate: kendo.template($("#template").html()),
				//template: "<input type='checkbox' id='ApprovedByManager' checked='${ApprovedByManager}' />"
                //detailInit: detailInit,
                editable: true,
                navigatable: true,
                groupable: false,
                filterable: true, scrollable : true
			});
		
		});

		
	</script>

</head>
<body>
         <div id="example" class="k-content">
	<div id="grid"></div>


	</div>
</body>
</html>