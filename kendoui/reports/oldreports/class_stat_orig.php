<?php
// define( '_JEXEC', 1 );

//define( '_VALID_MOS', 1 );

//define('JPATH_BASE', '../../../../');

//define( 'DS', DIRECTORY_SEPARATOR );

//require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );

//require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );



/* Create the Application */

//$mainframe =& JFactory::getApplication('site');

//$mainframe->initialise();


/* Make sure we are logged in at all. */

///if (JFactory::getUser()->id == 0)

//   die("You have to be logged in.");
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
		kendo.culture("en-US");
		
		        $("#datefrom").kendoDatePicker({format: "yyyy-MM-dd"});
                	$("#dateto").kendoDatePicker({format: "yyyy-MM-dd"});     
                	                   
                        var datepickedfrom = $("#datefrom").val();
                        var datepickedto = $("#dateto").val();                        
                                                
		
		$(document).ready(function() {

		 	// create DatePicker from input HTML element
  
			$("#grid").kendoGrid({
				dataSource: {
					transport: {
						read: "data/class_stat.php?datefrom=" + datepickedfrom + "&dateto" + datepickedto
							
					},
					error: function(e) {
						alert(e.responseText);
					},
					pageSize: 20,
					schema: {
						data: "data",
						model: {
							id: "id",
							fields: {
								
								StartDate: { editable: false },
								Minutes: { editable: false },
								Location: { editable: false },
								ClassName: { editable: false },
								InstructorName: { editable: false},
								ApprovedByManager: { editable: false }, 
								AttendeeNumber: { editable: false }, 
								HourlyRate: { editable: false },
								TotalPayable: { editable: false },
								Paid: { editable: false },
							
							}
						}
					},
					aggregate: [ { field: "AttendeeNumber", aggregate: "average" }, 
					       	     { field: "HourlyRate", aggregate: "average" },
    						     { field: "TotalPayable", aggregate: "sum" } ]
				},
   				
				sortable: true,
    				scrollable: false,
    				groupable: true,
    				pageable: true,
				columns: [ { field: "StartDate" , 
				             title: "When", 
				             template: '#= kendo.toString(StartDate,"ddd d MMM yyyy hh:mm tt") #',
                                             width: 120  }, 
				{ field: "Minutes", width: "50px" },
				{ field: "Location", width: "100px"  },
				{ field: "ClassName" , title: "Class Name", width: "150px" }, 
				{ field: "InstructorName" , title: "Instructor", width: "150px" }, 
				{ field: "ApprovedByManager", title: "Approved", width: "60px" },
				{ field: "AttendeeNumber",
				  title: "Attendee Number", 
				  width: "60px",
				  aggregates: "average",  
				  footerTemplate: "<div>Average: #=average#</div>", 
				  groupFooterTemplate: "Average: #=average#"}, 
				{ field: "HourlyRate",
				  title: "Hourly Rate",
				  format: "{0:C2}", 
				  width: "100px" ,
				  aggregates: "average",  
				  footerTemplate: "<div>Average: #=average#</div>", 
				  groupFooterTemplate: "Average: #=average#"}, 
				{ field: "TotalPayable",
				  title: "Total Payable",
				  format: "{0:C2}", 
				  width: "100px",
				  aggregates: "sum",  
				  footerTemplate: "<div>Sum: #=sum#</div>", 
				  groupFooterTemplate: "Sum: #=sum#"},
				{ field: "Paid",title: "Paid", width: "70px" }]
			});
	});
	</script>

</body>
</html>