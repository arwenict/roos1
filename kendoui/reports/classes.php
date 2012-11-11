<?php
    ini_set("display_errors", 1);
    ini_set('include_path', '/var/www/roos1/custom_lib/');
    include_once("core/dbTools.php");
    include_once("classes/instructors.class.php");

    $db = new DBHandler();
    $db->connect();
    
    $instructors = new Instructors($db);
    
    $instructorsList = $instructors->getListOfInstructors();
    
    $jsArray = "[";
    foreach ($instructorsList as $instructor) {
        $jsArray .= "{ 'text': '{$instructor['name']}', 'value': '{$instructor['id']}' },";
    }
    
    $jsArray = rtrim($jsArray, ",");
    $jsArray .= "]";
    
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

                   Pick Date From <input id="datefrom" name="datefrom" value="<?php if (!empty($_GET['datefrom'])) echo $_GET['datefrom']; else echo date('Y-m-d', mktime(0,0,0,date('m')-1,1)-1); ?>" style="width:150px;" /> &nbsp;&nbsp;
                   Pick Date To <input id="dateto" name="dateto" value="<?php if (!empty($_GET['dateto'])) echo $_GET['dateto']; else echo date('Y-m-d', mktime(0,0,0,date('m')+1,1)-1); ?>" style="width:150px;" /> &nbsp;&nbsp;
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
            var instructors = <?php echo $jsArray ?> 

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
								ClassName: { type: "string", editable: false },
								StartDate: { type: "date", editable: false },
                                                                StartTime: { type: "date", editable: false },
								Location: { editable: false },
								InstructorName: { editable: true },
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
				{ field: "InstructorID", title: "Instructor", width: 100, values: instructors,editor: instructorsDropDownEditor  }, 
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
                                filterable: {
                                    name: "FilterMenu",
                                    extra: false, // turns on/off the second filter option
                                    messages: {
                                        info: "Select items with value that:", // sets the text on top of the filter menu
                                        filter: "Go", // sets the text for the "Filter" button
                                        clear: "Clear" // sets the text for the "Clear" button
                                    },
                                    operators: {
                                        //filter menu for "string" type columns
                                        string: {
                                                contains: "Contains"
                                        }
                                    }
                                },
                                scrollable : true,
                                selectable: "row",
                                dataBound: function(e) {
                                   changeDefaults();
                                }
                        });
		
		});

                function instructorsDropDownEditor(container, options) {
                
                    var data = <?php echo $jsArray ?>

                    $('<input name="' + options.field + '" />')
                        .appendTo(container)
                        .kendoComboBox({
                            dataTextField: "text",
                            dataValueField: "value",
                            dataSource: data,
                            filter: "contains",
                            suggest: true
                        });
                        
                    $("input[type=text]").focus(function(){
                        this.select();
                    }); 
               } 


                function changeDefaults() {
                    setTimeout(function() {
                        var header;
                        $('.k-header').each(function(i) {
                        if($(this).data('kendoColumnMenu')) {
                            header = $(this).data('kendoColumnMenu');
                            if(header.filterMenu) {
                            header.menu.bind('open', function(e) {
                                if($(e.item).is('.k-filter-item')) {
                                header = $('.k-header:eq(' + i +')').data('kendoColumnMenu');
                                var popup = header.filterMenu.popup;
                                if(!$(popup.element).data('alreadyOpened')) {
                                    var select = this.element.find('select:first');
                                    var option = select.children('option:contains("Contains")');
                                    if(option.length > 0) {
                                    select.data('kendoDropDownList').select(option.index());
                                    header.filterMenu.filterModel.set("filters[0].operator", "contains");
                                    }
                                    $(popup.element).data('alreadyOpened', true);
                                }
                                }
                            });
                            header.filterMenu.form.bind('reset', function() {     
                                alert('here');
                                $('.k-header').each(function(i) {
                                    $(this).data('kendoFilterMenu').popup.element.data('alreadyOpened', false);
                                });
                            });
                            }
                        } else if($(this).data('kendoFilterMenu')) {
                        header = $(this).data('kendoFilterMenu');
                        header.popup.bind('open', function() {
                            if(!$(this.element).data('alreadyOpened')) {
                            header = $('.k-header:eq(' + i + ')').data('kendoFilterMenu');
                            var select = this.element.find('select:first');
                            var option = select.children('option:contains("Contains")');
                            if(option.length > 0) {
                                select.data('kendoDropDownList').select(option.index());    
                                header.filterModel.set("filters[0].operator", "contains");
                            }
                            $(this.element).data('alreadyOpened', true);
                            }
                        });
                        header.form.bind('reset', function() {
                            $(this).data('kendoFilterMenu').popup.element.data('alreadyOpened', false);
                        });
                        }
                    });
                    }, 1);
                }

	</script>

</body>
</html>