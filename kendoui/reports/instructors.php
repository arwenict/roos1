<!doCTYpe html> 
<html>
<head>
    <script src="../js/jquery.min.js"></script>
    <script src="../trial/js/kendo.all.min.js"></script>
 
    <link href="../styles/kendo.common.min.css" rel="stylesheet">
    <link href="../styles/kendo.silver.min.css" rel="stylesheet">
    <link href="../styles/kendo.silver.min.css" rel="stylesheet">
    <link href="../../templates/ifreedom-fjt/css/styles.css" rel="stylesheet">

</head>
<body>
    <div id="example" class="k-content">
        <form id="target" action="classes.php" method="get">
            
            <div id="classesDB">
                <div style="margin-top: -6px; "></div>
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
        
        div.instructorField {float:left; clear:both; margin-bottom:10px;}
        .editKey{width: 150px; float:left;}
        .editValue{width: 500px; float:left}
        label.editInstructor {font-size: 13px; font-weight:700; margin-right:10px;}
        label.location {float:left; clear:both; font-size:12px;}
        
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
                                                            name: { type: "string"},
                                                            mobile: { type: "string"},								
                                                            email: { type: "string"},
                                                            skills: { type: "string"},
                                                            permcov: { type: "string"},
                                                            locations: {type: "string"},
                                                            edit_link: {}
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
                            { field: "skills", title: "Skills", width: 140, filterable: true },     
                            { field: "permcov", title: "Perm / Cover", width: 70, filterable: true },
                            { field: "locations", title: "Locations", width: 100, filterable: true},
                            { field: "edit_link", title: "Edit", width: 50, template:"<a href='' onclick=\"parent.openEditPopUp('#=edit_link#'); return false;\" class='instr_edit'></a>", filterable: false}
                            ],
                            /*
                            toolbar: [ 

                                    { name: "save", text: "Save changes" },
                                    { name: "cancel", text: "Cancel changes" }
                            ],
                            */
                            //detailTemplate: kendo.template($("#template").html()),
                            //template: "<input type='checkbox' id='ApprovedByManager' checked='${ApprovedByManager}' />"
                            //detailInit: detailInit,
                            editable: false,
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
                                            contains: "Contains",
                                            startswith: "Starts with"
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
                                $(this).parent().data('kendoFilterMenu').popup.element.data('alreadyOpened', false);
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
                            $('.k-header').each(function(i) {
                                $(this).data('kendoFilterMenu').popup.element.data('alreadyOpened', false);
                            });
                        });
                        }
                    });
                    }, 1);
                }
	</script>    

</body>
</html>
