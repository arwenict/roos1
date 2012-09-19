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
        <form id="target" action="billing.php" method="get">
            
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
						read: "data/billing.php?datefrom=" + datepickedfrom + "&dateto=" + datepickedto ,
						update: {
							url: "data/billing.php",
							type: "POST"
						}		
					},
					error: function(e) {
						alert(e.responseText);
					},
					schema: {
						data: "data",
						group: { field: "InstructorName" },
						model: {
							id: "id",
							fields: {
								ClassName: { editable: false },
								StartDate: { type: "date", editable: false },
                                                                StartTime: { type: "text", editable: false },
								Minutes: { editable: false },
								Location: { editable: false},
								InstructorName: { editable: false},
								TotalPayable: { type: "number",editable: false},
								Paid:  {type: "boolean", editable: true }, 
								BankTransactionID:  { type: "text", editable: true }
								
							}						
						}
					},
					group: { field: "InstructorName", dir: "asc", aggregates: [
                				{ field: "TotalPayable", aggregate: "sum" },
                				{ field: "Paid", aggregate: "count"}]
    					},

					aggregate: [ { field: "Paid", aggregate: "count" },
    						     { field: "TotalPayable", aggregate: "sum" } ],

				},
				
				columns: [{ field: "ClassName", title: "Class Name" }, 
				{ field: "StartDate", title: "Start Date", format: "{0:ddd dd-MMM-yyyy}",  width: 100 },
				{ field: "StartTime", title: "Start Time", width: 60 },
				{ field: "Minutes", width: 60 },
				{ field: "Location" }, 
				{ field: "InstructorName", title: "Instructor Name" }, 
				{ field: "TotalPayable", title: "Total Payable", format:"{0:c2}", filterable: false, width: 100, aggregates: "sum", footerTemplate: "Total: #=sum#", groupFooterTemplate: "Subtotal: #=sum#" },
				{ field: "Paid", title: "Paid", width: 60, template: "<input type='checkbox' #= (Paid === true) ? checked='checked' : '' # disabled />" }, 
				{ field: "BankTransactionID", title: "Bank Transaction<br>Number" }
				],
				toolbar: [ "save", "cancel"],
				//detailTemplate: kendo.template($("#template").html()),
                //detailInit: detailInit,
                		sortable: true,
    				scrollable: true,
    				groupable: false,
    				pageable: false,
		                editable: true,
		                filterable: false
			});
		
		});
	</script>
</body>
</html>