<?php
/** 
 * @package	JomSocial
 * @subpackage Core 
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die();
$validPassword = JText::sprintf( JText::_( 'VALID_AZ09', true ), JText::_( 'Password', true ), 4 );

/* Including neccessary libraries */
include_once("boot.php");
include_once("classes/locations.class.php");
include_once("classes/skills.class.php");

/* Inititalising objects */
$locations = new Locations($db);
$skills = new Skills($db);

$studios = $locations->getAllLocations();
$skillsList = $skills->getSkillsList();

$db->close();
?>
<?php if( $showProfileType ){ ?>
<div class="com-notice">
		<?php if( $multiprofile->id != COMMUNITY_DEFAULT_PROFILE ){ ?>
			<?php echo JText::sprintf('COM_COMMUNITY_CURRENT_PROFILE_TYPE' , $multiprofile->name );?>
		<?php } else { ?>
			<?php echo JText::_('COM_COMMUNITY_CURRENT_DEFAULT_PROFILE_TYPE');?>
		<?php } ?>
		[ <a href="<?php echo CRoute::_('index.php?option=com_community&view=multiprofile&task=changeprofile');?>"><?php echo JText::_('COM_COMMUNITY_CHANGE');?></a> ]
</div>
<?php } ?>
<a href="#" style="position:absolute; right:0px; top:5px;" id='open-help' onclick="javascript:openPopUp();"class="help-link"> </a>
<div id="overlay" class="popup-wrapper" >
    <div class="popup resizable">
        <div id='cpt_lghtbx' class="mid fixedBox" style='overflow-y:scroll;'>
            <a href="#" id="close-captions" onclick="javascript:closePopUp()" class="close">&nbsp;</a>
            <h2>Help</h2>

            <div class="hightlight-box">
                <h3>Sub heading 1</h3>
                <p>HTML formatted text goes here</p>
            </div>


        </div>
    </div>
</div>
<div class="cEdit">
<form name="jsform-profile-edit" id="frmSaveProfile" action="<?php echo CRoute::getURI(); ?>" method="POST" class="community-form-validate">

<div class="cProfile-ProfileNav">
	<ul>
		<li><a href="#basicSet"><?php echo JText::_('COM_COMMUNITY_PROFILE_SETTING_INFO');?></a></li>
		<li><a href="#detailSet"><?php echo JText::_('COM_COMMUNITY_PROFILE_SETTING_INFO_DETAILS');?></a></li>
	</ul>
	<div class="saveButton" ><input style='color:white; padding-bottom:20px;' type="submit" name="frmSubmit" onclick="submitbutton(); return false;" class="button" value="<?php echo JText::_('COM_COMMUNITY_SAVE_BUTTON'); ?>" /></div>
</div>

<div class="cProfile-ProfContainer">

<div id="basicSet" class="section"> <!-- Profile Basic Setting -->
<?php
//print_r($studios);
//print_r($fields);
foreach ( $fields as $name => $fieldGroup )
{
		if ($name != 'ungrouped')
		{
?>
		<div class="ctitle">
			<h2><?php echo JText::_( $name );?></h2>
		</div>
<?php
		} 
?>
    <script type='text/javascript'>
        function saveLocations() {
            var locations = "";
            joms.jQuery('.field22:checked').each(function(index) {
                locations += ","+joms.jQuery(this).val();
            });
            locations = locations.substring(1,locations.length);
            joms.jQuery('#field22').val(locations);
        }
    </script>
		<table class="formtable" cellspacing="1" cellpadding="0" style="width: 98%;">
		<tbody>
			<?php
				foreach ( $fieldGroup as $f )
				{
					$f = JArrayHelper::toObject ( $f );
                                        $fieldRequired = "";
                                        if ($f->required)
                                            $fieldRequired = "*";
                                        
                                        if ($f->name == "Locations") {
                                            $values = explode(",", $f->value);
                                            $options = "";
                                            foreach($studios as $studio) {
                                                $checked = "";
                                                if (in_array($studio['nodeID'], $values))
                                                    $checked = "checked='checked'";
                                                
                                                $options .= "<label class='lblradio-block'><input style='margin: 0 5px 5px 0;' onchange='javascript:saveLocations()' type='checkbox' $checked class='field22' value='{$studio['nodeID']}' />{$studio['displayCode']}</label>";
                                            }
                                            echo "
                                                <tr> 
                                                    <td class='key'>
                                                        <label id=\"lblfield{$f->id}\" for=\"field{$f->id}\" class='label'>$fieldRequired {$f->name}</label>
                                                    </td>
                                                    <td class='value'>
                                                        <div style='width:200px;' class='jomNameTips tipRight' original-title='{$f->tips}'>
                                                            $options
                                                            <input type='hidden' id='field22' name='field22' value='{$f->value}' />
                                                        </div>
                                                    </td>    
                                                </tr>
                                            ";
                                        }
                                        elseif ($f->name == "Skillset") {
                                            $skillString = "<select multiple='multiple' id='skills'>";
                                            
                                            $values = explode(",", $f->value);
                                            
                                            foreach($skillsList as $skill) {
                                                $selected = "";
                                                if (in_array($skill['skillID'], $values))
                                                    $selected = "selected='selected'";
                                                
                                                $skillString .= "<option $selected value='{$skill['skillID']}'>{$skill['name']}</option>";
                                            }
                                            
                                            $skillString .= "
                                                </select>
                                                <input type='hidden' id='field19' name='field19' value='{$f->value}' />    
                                            ";
                                            
                                            echo "
                                                <tr>
                                                    <td class='key'>
                                                        <label id=\"lblfield{$f->id}\" for=\"field{$f->id}\" class='label'>$fieldRequired {$f->name}</label>
                                                    </td>
                                                    <td class='value'>
                                                        $skillString
                                                    </td>
                                                </tr>
                                            ";
                                        }
                                        else{
                                            $value = CProfileLibrary::getFieldHTML( $f , '' );
                                            // DO not escape 'SELECT' values. Otherwise, comparison for
                                            // selected values won't work
                                            if($f->type != 'select'){
                                                    $f->value	= $this->escape( $f->value );
                                            }
                        ?>
                                            <tr>
                                                    <td class="key"><label id="lblfield<?php echo $f->id;?>" for="field<?php echo $f->id;?>" class="label"><?php echo $fieldRequired; echo JText::_( $f->name );?></label></td>	 					
                                                    <td class="value"><?php echo $value ?></td>
                                                    <!-- Hidden Lock
                                                    <td class="privacy">
                                                            <?php echo CPrivacy::getHTML( 'privacy' . $f->id , $f->access ); ?>
                                                    </td>
                                                    -->
                                            </tr>
	 		<?php
                                        }
                        
                                }
			?>
		</tbody>
		</table>
    <script type='text/javascript'>
            joms.jQuery('#skills').multiSelect({
                afterSelect: function(value, text) { 
                    saveSkill(value, text, "select");
                },
                afterDeselect: function(value, text) {
                    saveSkill(value, text, "deselect");
                }
            });
            
            function saveSkill(value, text, action) {
                var skills = joms.jQuery("#field19").val();
                
                if (action == "select") {
                    if (skills == "")
                        skills = value;
                    else 
                        skills += "," + value;
                }
                else {
                    
                    if (value != skills.charAt(0))
                        skills=skills.replace(","+value,"");
                    else if (value.toString() == skills)
                        skills = "";
                    else if (value == skills.charAt(0))
                        skills = skills.replace(value+",","");
                }
                joms.jQuery('#field19').val(skills);
            }
    </script>
<?php
}
?>
		<table class="formtable" cellspacing="1" cellpadding="0">
			<tr>
				<td class="key"></td>
				<td class="value"><span class="hints"><?php echo JText::_( 'COM_COMMUNITY_REGISTER_REQUIRED_FILEDS' ); ?></span></td>
			</tr>
		</table>

<?php if(!empty($afterFormDisplay)){ ?>
	<table class="formtable" cellspacing="1" cellpadding="0" style="width: 98%;">
		<?php echo $afterFormDisplay; ?>
	</table>
<?php } ?>
		<table class="formtable" cellspacing="1" cellpadding="0" style="width: 98%;">
		<tbody>
			<tr>
			    <td class="key"></td>
			    <td class="value">
					<input type="hidden" name="action" value="save" />
                </td>
			</tr>
		</tbody>
		</table>
</div> <!-- end basic setting -->

<div id="detailSet" class="section"> <!-- Profile Detail Setting -->
<?php if(!empty($beforeFormDisplay)){ ?>
	<table class="formtable" cellspacing="1" cellpadding="0" style="width: 98%;">
		<?php echo $beforeFormDisplay; ?>
	</table>
<?php } ?>
<table class="formtable" cellspacing="1" cellpadding="0" style="width: 98%;">
<tbody>
	<!-- username -->
	<tr>
	    <td class="key"><label class="label" for="username"><?php echo JText::_('COM_COMMUNITY_PROFILE_USERNAME'); ?></label></td>
	    <td class="value">
			<div class="inputbox halfwidth"><?php echo $this->escape($user->get('username')); ?></div>
	    </td>
	</tr>
	<?php if (!$isUseFirstLastName) { ?>
	<!-- fullname -->
	<tr>
	    <td class="key"><label class="label" for="name"><?php echo JText::_('COM_COMMUNITY_PROFILE_YOURNAME'); ?></label></td>
	    <td class="value">
			<input class="inputbox halfwidth" type="text" id="name" name="name" value="<?php echo $this->escape($user->get('name'));?>" />
	    </td>
	</tr>
	<?php } ?>
	<!-- email -->
	<tr>
	    <td class="key"><label class="label" for="jsemail"><?php echo JText::_( 'COM_COMMUNITY_EMAIL' ); ?></label></td>
	    <td class="value">
			<input type="text" class="inputbox halfwidth" id="jsemail" name="jsemail" value="<?php echo $this->escape( $user->get('email') ); ?>" />
			<input type="hidden" id="email" name="email" value="<?php echo $user->get('email'); ?>" />
		    <input type="hidden" id="emailpass" name="emailpass" id="emailpass" value="<?php echo $this->escape( $user->get('email') ); ?>"/>
		    <span id="errjsemailmsg" style="display:none;">&nbsp;</span>
	    </td>
	</tr>
	<?php if ( !$associated ) : ?>
	<?php     if ( $user->get('password') ) : ?>
	<!-- password -->
	<tr>
	    <td class="key"><label class="label" for="jspassword"><?php echo JText::_( 'COM_COMMUNITY_PASSWORD' ); ?></label></td>
	    <td class="value">
			<input id="jspassword" name="jspassword" class="inputbox halfwidth" type="password" value="" />
			<span id="errjspasswordmsg" style="display: none;"> </span>
	    </td>
	</tr>
	<!-- 2nd password -->
	<tr>
	    <td class="key"><label class="label" for="jspassword2"><?php echo JText::_( 'COM_COMMUNITY_VERIFY_PASSWORD' ); ?></label></td>
	    <td class="value">
			<input id="jspassword2" name="jspassword2" class="inputbox halfwidth" type="password" value="" />
			<span id="errjspassword2msg" style="display:none;"> </span>
			<div style="clear:both;"></div>
			<span id="errpasswordmsg" style="display:none;">&nbsp;</span>
	    </td>
	</tr>	
	<?php     endif; ?>
	<?php endif; ?>
</tbody>
</table>

<?php if(isset($params)) :  echo $params->render( 'params' ); endif; ?>

<?php 
$showDST = false;
if ($showDST) { 
?>
<table class="formtable" cellspacing="1" cellpadding="0" style="width: 98%;">
<tbody>

	<!-- DST -->
	<tr>
	    <td class="key">
			<label class="jomNameTips label" title="<?php echo JText::_('COM_COMMUNITY_DAYLIGHT_SAVING_OFFSET_TOOLTIP');?>" for="daylightsavingoffset">
				<?php echo JText::_( 'COM_COMMUNITY_DAYLIGHT_SAVING_OFFSET' ); ?>
			</label>
		</td>
	    <td class="value">
			<?php echo $offsetList; ?>
	    </td>
	</tr>
	<!-- group buttons -->
	<tr>
		<td class="key"></td>
		<td class="value">			
			<input type="hidden" name="id" value="<?php echo $user->get('id');?>" />
			<input type="hidden" name="gid" value="<?php echo $user->get('gid');?>" />
			<input type="hidden" name="option" value="com_community" />
			<input type="hidden" name="view" value="profile" />
			<input type="hidden" name="task" value="edit" />
			<input type="hidden" id="password" name="password" />
			<input type="hidden" id="password2" name="password2" />		
			<?php echo JHTML::_( 'form.token' ); ?>	
		</td>
	</tr>
</tbody>
</table>

<?php
}
/* Commented out by mpak as this code was causing a fatal error. Have a suspicisous that the object is either being re-initialised and should not 
 * be of a JConfig class or the fbconnectkey and fbconnectsecret values should be included into the current config
if( $config->get('fbconnectkey') && $config->get('fbconnectsecret') )
{
?>
	<div class="ctitle"><h2><?php echo JText::_('COM_COMMUNITY_ASSOCIATE_FACEBOOK_LOGIN' );?></h2></div>
<?php
	if( $isAdmin )
	{
?>
	<div class="small facebook"><?php echo JText::_('COM_COMMUNITY_ADMIN_NOT_ALLOWED_TO_ASSOCIATE_FACEBOOK');?></div>
<?php
	}
	else
	{
		if( $associated )
		{
		?>
			<div class="small facebook"><?php echo JText::_('COM_COMMUNITY_ACCOUNT_ALREADY_MERGED');?></div>
			<!--
			<div>
				<input<?php echo $readPermission ? ' checked="checked" disabled="true"' : '';?> type="checkbox" id="facebookread" name="connectpermission" onclick="FB.Connect.showPermissionDialog('read_stream', function(x){if(!x){ joms.jQuery('#facebookread').attr('checked',false);}}, true );">
				<label for="facebookread" style="display: inline;"><?php echo JText::_('COM_COMMUNITY_ALLOW_SITE_TO_READ_UPDATES_FROM_YOUR_FACEBOOK_ACCOUNT');?></label>
			</div>
			-->
			<br/>
			<div>
				<input<?php echo !empty($fbPostStatus) ? ' checked="checked"' : '';?> type="checkbox" id="postFacebookStatus" name="postFacebookStatus">
				<label for="postFacebookStatus" style="display: inline;"><?php echo JText::_('COM_COMMUNITY_ALLOW_SITE_TO_PUBLISH_UPDATES_TO_YOUR_FACEBOOK_ACCOUNT');?></label>
			</div>
		<?php
		}
		else
		{
			echo $fbHtml;
		}
	}
}
 * 
 */
?>

</div>
</div>
</form>
</div>

<script type="text/javascript">
    cvalidate.init();
    cvalidate.setSystemText('REM','<?php echo addslashes(JText::_("COM_COMMUNITY_ENTRY_MISSING")); ?>');
    cvalidate.setSystemText('JOINTEXT','<?php echo addslashes(JText::_("COM_COMMUNITY_AND")); ?>');
    
    joms.jQuery( document ).ready( function(){
    
    	joms.privacy.init();

 	var tabContainers = joms.jQuery('.cProfile-ProfContainer > div.section');
    
    joms.jQuery('.cProfile-ProfileNav ul li a').click(function () {
        tabContainers.hide().filter(this.hash).fadeIn(500);
        joms.jQuery('.cProfile-ProfileNav ul li a').removeClass('selected');
        joms.jQuery(this).addClass('selected');
        return false;
    }).filter(':first').click();

	});

function submitbutton() {	
	var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&|\+|\-]", "i");
	
	//hide all the error messsage span 1st
	joms.jQuery('#name').removeClass('invalid');
	joms.jQuery('#jspassword').removeClass('invalid');
	joms.jQuery('#jspassword2').removeClass('invalid');
	joms.jQuery('#jsemail').removeClass('invalid');
	
	joms.jQuery('#errnamemsg').hide();
	joms.jQuery('#errnamemsg').html('&nbsp');	

	joms.jQuery('#errpasswordmsg').hide();
	joms.jQuery('#errpasswordmsg').html('&nbsp');
	
	joms.jQuery('#errjsemailmsg').hide();
	joms.jQuery('#errjsemailmsg').html('&nbsp');
	
	joms.jQuery('#password').val(joms.jQuery('#jspassword').val());
	joms.jQuery('#password2').val(joms.jQuery('#jspassword2').val());
	
	// do field validation
	var isValid	= true;
	
	if (joms.jQuery('#name').val() == "") {
		isValid = false;
		joms.jQuery('#errnamemsg').html('<?php echo addslashes(JText::_( 'COM_COMMUNITY_PLEASE_ENTER_NAME', true ));?>');
		joms.jQuery('#errnamemsg').show();
		joms.jQuery('#name').addClass('invalid');
	}
	
	if(joms.jQuery('#jsemail').val() !=  joms.jQuery('#email').val())
	{
		regex=/^[a-zA-Z0-9._-]+@([a-zA-Z0-9.-]+\.)+[a-zA-Z0-9.-]{2,4}$/;
	   	isValid = regex.test(joms.jQuery('#jsemail').val());
	   	
		var fieldname = joms.jQuery('#jsemail').attr('name');;			       
		if(isValid == false){
			cvalidate.setMessage(fieldname, '', 'COM_COMMUNITY_INVALID_EMAIL');
			joms.jQuery('#jsemail').addClass('invalid');
		}	   	
   	}
	
	if(joms.jQuery('#password').val().length > 0 || joms.jQuery('#password2').val().length > 0) {
		//check the password only when the password is not empty!
		if(joms.jQuery('#password').val().length < 6 ){
			isValid = false;
			joms.jQuery('#jspassword').addClass('invalid');
			alert('<?php echo addslashes(JText::_( 'COM_COMMUNITY_PASSWORD_TOO_SHORT' ));?>');		
		} else if (((joms.jQuery('#password').val() != "") || (joms.jQuery('#password2').val() != "")) && (joms.jQuery('#password').val() != joms.jQuery('#password2').val())){
			isValid = false;			
			joms.jQuery('#jspassword').addClass('invalid');
			joms.jQuery('#jspassword2').addClass('invalid');
			var err_msg = "<?php echo addslashes(JText::_( 'COM_COMMUNITY_PASSWORD_NOT_SAME' )); ?>";
			alert(err_msg);
		} else if (r.exec(joms.jQuery('#password').val())) {
			isValid = false;		
			joms.jQuery('#errpasswordmsg').html('<?php echo $validPassword; ?>');
			joms.jQuery('#errpasswordmsg').show();
			
			joms.jQuery('#jspassword').addClass('invalid');
		}
	}
		
	if(isValid) {
		//replace the email value.
		joms.jQuery('#email').val(joms.jQuery('#jsemail').val());
		joms.jQuery('#frmSaveProfile').submit();
	}
}

// Password strenght indicator 
var password_strength_settings = {
	'texts' : {
		1 : '<?php echo addslashes(JText::_('COM_COMMUNITY_PASSWORD_STRENGHT_L1')); ?>',
		2 : '<?php echo addslashes(JText::_('COM_COMMUNITY_PASSWORD_STRENGHT_L2')); ?>',
		3 : '<?php echo addslashes(JText::_('COM_COMMUNITY_PASSWORD_STRENGHT_L3')); ?>',
		4 : '<?php echo addslashes(JText::_('COM_COMMUNITY_PASSWORD_STRENGHT_L4')); ?>',
		5 : '<?php echo addslashes(JText::_('COM_COMMUNITY_PASSWORD_STRENGHT_L5')); ?>'
	}
}
			
joms.jQuery('#jspassword').password_strength(password_strength_settings);	
</script>
</div>