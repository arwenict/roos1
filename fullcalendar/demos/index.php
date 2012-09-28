<?php
define( '_JEXEC', 1 );
define( '_VALID_MOS', 1 );
define('JPATH_BASE', '../../../');
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


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<link rel='stylesheet' type='text/css' href='../fullcalendar/fullcalendar.css' />
<link rel='stylesheet' type='text/css' href='../fullcalendar/fullcalendar.print.css' media='print' />

 <style>
#simplemodal-overlay {background-color:#000;}
#simplemodal-container {background-color:#333; border:8px solid #444; padding:12px;}
</style>

<script type='text/javascript' src='../jquery/jquery-1.7.1.min.js'></script>
<script type='text/javascript' src='../jquery/jquery-ui-1.8.17.custom.min.js'></script>
<script type='text/javascript' src='../fullcalendar/fullcalendar.min.js'></script>

<script type='text/javascript' src='../basic/js/jquery.simplemodal.js'></script>   
<script type="text/javascript" src="../basic/js/jquery.qtip-1.0.0-rc3.min.js"></script> 

<script  type='text/javascript'  src="../../kendoui/trial/js/kendo.all.min.js"></script>
<link href="../../kendoui/styles/kendo.common.min.css" rel="stylesheet">
<link href="../../kendoui/styles/kendo.silver.min.css" rel="stylesheet">

<script type='text/javascript'>


	$(document).ready(function() {
	          
	          //$("#submit").button();
	          
	          var locationPicked= $("#location").val();
	          
	          if (locationPicked=="")
	              {locationPicked="9";}
	          
	           var data = [
                           // { text: "CBD - Hero", value: "1" },
                           // { text: "CBD - Mountain", value: "2" },
                           // { text: "CBD - Reformer", value: "3" },
                           // { text: "CBD - Firefly", value: "4" },
 			   // { text: "CBD - Cobra", value: "5" },
                           // { text: "CBD - Warrior", value: "6" },
                           // { text: "CBD - Rooftop", value: "7" },
                            { text: "Chatswood", value: "8" }, 
                            { text: "Liverpool", value: "9" }      ];                        
/*Hero	1
Mountain	2
Reformer	3
Firefly	4
Cobra	5
Warrior	6
Rooftop	7
Chatswood	8
Liverpool	9
*/
                  

                    // create DropDownList from input HTML element
                    $("#locationID").kendoDropDownList({
                        dataTextField: "text",
                        dataValueField: "value",
                        dataSource: data, 
                        value: locationPicked
                        ///change: onChange
                    });
                    
                   
                    
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
		
		var calendar = $('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
                         
			},
			titleFormat: {
			        month: 'MMMM yyyy',
			        week: "d MMM [ yyyy]{ '&#8212;'d [ MMM] yyyy}",
			        day: 'dd/MM'
    			},
    			columnFormat: {
			    month: 'ddd',    // Mon
			    week: 'ddd d/M', // Mon 9/7
			    day: 'dddd d/M'  // Monday 9/7
			},
			
 
  
              
//                   eventClick: function(calEvent, jsEvent, view) {
//  $(this).qtip( 
//  { 
//     content: '<a href="http://www.arwen.com.au/b5/index.php/jomsocial/events/edit?eventid='+calEvent.id+'" target="_parent">Edit</a>', 
//           hide: {
//                    delay: 100
//           },
//           style: { 
//             name: 'dark',
//             width: 200,
//             background: '#A2D959',
//             color: 'black',
//
//             style: { 
//                 border: 1, 
//                 cursor: 'pointer', 
//                 padding: '5px 8px', 
//                 name: 'blue' 
//             }, 
//             border: {},  
//             tip: true // Apply a tip at the default tooltip corner 
//           } 
//  }); 


  //                 },

                      height: 800,
                      firstHour: 6,
                      minTime: 6,
                      maxTime: 21,
			defaultView: 'agendaWeek',
                      firstDay: 1,
			selectable: true,
			selectHelper: true,
						
   			eventRender: function(event, element) {
                        element.qtip({
                                        hide: {
                                           fixed: true,
                                           delay:100
                                        },

 

                                  
content : event.description+'<br><a href="http://www.arwen.com.au/b5/index.php/jomsocial/events/viewevent/'+event.id+'" target="_parent">View</a>'+'   <a href="http://www.arwen.com.au/b5/index.php/jomsocial/events/edit?eventid='+event.id+'" target="_parent">Edit</a>'+'   <a href="http://www.arwen.com.au/b5/index.php/jomsocial/events/create?eventid='+event.id+'" target="_parent">Duplicate</a>',
                                        position: {corner: {target: 'mouse'}},
                                        style   : {
                                                    width: 200,
                                                    padding: 2,
                                                    background: '#eeeeee',
                                                    color: 'black',
                                                    textAlign: 'center',
                                                    border: {
                                                        width: 1,
                                                        radius: 10,
                                                        color: '#333333'
                                                    },
                                                    name: 'dark', // Inherit the rest of the attributes from the preset dark style
 
                                        }
                                     });
                    },
                    
                    
			
			editable: true,
  

			eventSources: [
			        'feed1.php?location='+locationPicked 
                                   
			            ]


		});
		
	});

</script>
<style type='text/css'>

	body{
		font-size: 12px;
		font-family: Verdana, "Lucida Grande",Helvetica,Arial,sans-serif;	
		}

	#calendar {
	        //margin-top: 40px;
		//text-align: center;

		width: 850px;
		margin: 0 auto;
		}

</style>
</head>
<body>
</br>
</br>
        <form id="target" action="index.php"  method="get">
            
            <div id="classesDB">
            <div style="margin-top: -6px; ">
            Please select location
            <select id="locationID" name="locationID" >
              
            </select>
             &nbsp;&nbsp;
                    <button id="submit" name="submit" type="submit" value="show">Show</button>
             <input type="hidden" id="location"  name="location" value="<?php echo $_GET['locationID']; ?>" />       
        </form>
</br>
</br>
 </br>
</br>       
<div id='calendar' class="fullcalendar"></div>
</body>
</html>