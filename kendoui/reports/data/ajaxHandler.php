<?php
# Including neccessary libraries
include_once("../../../boot.php");
include_once("classes/instructors.class.php");
include_once("classes/locations.class.php");
include_once("classes/skills.class.php");

$action = getParameterString("action");

# Inititalising objects 
$instructors = new Instructors($db);
$locations = new Locations($db);
$skills = new Skills($db);

# EDIT_INSTRUCTOR START
if ($action == "edit_instructor") {
    $studios = $locations->getAllStudios();
    $skillsList = $skills->getSkillsList();
    
    $instructorID = getParameterNumber("instructorID");
    
    $details = $instructors->getDetailsByInstructorID($instructorID);
    //ar_out($details);
    
    $header = "Edit instructor details";
    
    $body = "";
    foreach ($details as $key => $value) {
        if ($key == "permOrCover") {
            $pemanentSelected = ($value == "permanent") ? "selected='selected'" : "";
            $coverSelected = ($value == "permanent") ? "selected='selected'" : "";
            $body .= "
                <div class='instructorField'> 
                    <div class='editKey'><label class='editInstructor'>Permanent or Cover: </label></div> 
                    <div class='editValue'>
                        <select name='$key' id='$key'>
                            <option>Please select: &nbsp;</option>
                            <option $pemanentSelected value='permanent'>Permanent </option>
                            <option $coverSelected value='cover'>Cover </option>
                        </select>
                    </div>
                </div>
            ";
        }
        elseif ($key == "Locations") {
            $body .= "
                <div class='instructorField'>
                    <div class='editKey'><label class='editInstructor'>$key: </label></div> 
                    <div class='editValue'>    
            ";
            $values = explode(",", $value);
            foreach ($studios as $studio) {
                if (in_array($studio['nodeID'], $values))
                    $checked = "checked='checked'";
                else
                    $checked = "";
                
                $body .= "<label class='location'><input style='margin: 0 5px 5px 0; position: relative; top:2px;' onchange='javascript:saveLocations()' type='checkbox' $checked class='field22' value='{$studio['nodeID']}' />{$studio['displayCode']}</label>";
            }
            $body .= "
                    <input type='hidden' id='locationsList' value='$value' />
                    </div>
                </div>
            ";
        }
        elseif ($key == "Skillset") {
            $body .= "
                <div class='instructorField'>
                    <div class='editKey'><label class='editInstructor'>$key: </label></div> 
                    <div class='editValue'>    
            ";
            $body .= "<select multiple='multiple' id='skills'>";
            $values = explode(",", $value);
            foreach ($skillsList as $skill) {
                if (in_array($skill['skillID'], $values))
                    $selected = "selected='selected'";
                else
                    $selected = "";
                
                $body .= "<option $selected value='{$skill['skillID']}'>{$skill['name']}</option>";
            }
            $body .= "
                        </select>
                        <input type='hidden' id='skillsList' value='$value' />
                    </div>
                </div>
            ";
        }
        else {
            $body .= "
                <div class='instructorField'> 
                    <div class='editKey'><label class='editInstructor'>$key: </label></div> 
                    <div class='editValue'><input type='text' id='$key' value='$value'  /></div>
                </div>
            ";
        }
        
        $body .= "<script type='text/javascript'>
            $('#skills').multiSelect({
                afterSelect: function(value, text) { 
                    saveSkill(value, text, 'select');
                },
                afterDeselect: function(value, text) {
                    saveSkill(value, text, 'deselect');
                }
            });
            
            function saveSkill(value, text, action) {
                var skills = $('#skillsList').val();
                
                if (action == 'select') {
                    if (skills == '')
                        skills = value;
                    else 
                        skills += ',' + value;
                }
                else {
                    if (value != skills.charAt(0))
                        skills=skills.replace(','+value,'');
                    else if (value.toString() == skills)
                        skills = '';
                    else if (value == skills.charAt(0))
                        skills = skills.replace(value+',','');
                }
                $('#skillsList').val(skills);
            }
            
            function saveLocations() {
                var locations = '';
                $('.field22:checked').each(function(index) {
                    locations += ','+$(this).val();
                });
                locations = locations.substring(1,locations.length);
                $('#locationsList').val(locations);
            }

        </script>";
    }   
    outLightBox($header, $body);
}
# EDIT_INSTRUCTOR END

$db->close();

function outLightBox($header, $body) {
    echo "
        <div id='edit_lghtbx' class='mid fixedBox' style='overflow-y:scroll;'>
        <a href='#' id='close-captions' onclick='javascript:closeEditPopUp()' class='close'>&nbsp;</a>
            <h2>$header</h2>
            <hr /><br />
            <div class='hightlight-box'>
                $body
            </div>
            
            <button onclick='javascript:submitInstructorEdit()'>Submit</button>
            <button onclick='javascript:closeEditPopUp()'>Cancel</button>
        </div>
        
        <script type='text/javascript'>
            function submitInstructorEdit() {
                alert('submitted');
            }
        </script>
    ";
}

?>
