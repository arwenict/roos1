<?php
include_once("dbconfig.php");
include_once("functions.php");

$a=htmlspecialchars($_REQUEST['a']);


function addCalendar($st, $et, $sub, $ade){
  $ret = array();
  try{
    $db = new DBConnection();
    $db->getConnection();
    $sql = "insert into `pr_community_events` (`title`, `startdate`, `enddate`, `allday`,`catid`, `creator`, `parent`,`repeat`,`repeatend`) values ('"
      .mysql_real_escape_string($sub)."', '"
      .php2MySqlTime(js2PhpTime($st))."', '"
      .php2MySqlTime(js2PhpTime($et))."', '"
      .mysql_real_escape_string($ade)."', '"
      ."4"."', '"
      ."400"."', '"
      ."1"."', '"
      ."2012-11-30"."', '"
      ."weekly"."' )";
    //echo($sql);
		if(mysql_query($sql)==false){
      $ret['IsSuccess'] = false;
      $ret['Msg'] = mysql_error();
    }else{
      $ret['IsSuccess'] = true;
      $ret['Msg'] = 'add success';
      $ret['Data'] = mysql_insert_id();
    }
	}catch(Exception $e){
     $ret['IsSuccess'] = false;
     $ret['Msg'] = $e->getMessage();
  }
  return $ret;
}


function addDetailedCalendar($st, $et, $sub, $ade, $dscr, $loc, $color, $tz){
  $ret = array();
  try{
    $db = new DBConnection();
    $db->getConnection();
    $sql = "insert into `pr_community_events` (`title`, `startdate`, `enddate`, `allday`, `description`, `location`, `InstructorID` ) values ('"
      .mysql_real_escape_string($sub)."', '"
      .php2MySqlTime(js2PhpTime($st))."', '"
      .php2MySqlTime(js2PhpTime($et))."', '"
      .mysql_real_escape_string($ade)."', '"
      .mysql_real_escape_string($dscr)."', '"
      .mysql_real_escape_string($loc)."', )"
      .mysql_real_escape_string($ins)."', )";
   //   .mysql_real_escape_string($color)."' )";
    //echo($sql);
		if(mysql_query($sql)==false){
      $ret['IsSuccess'] = false;
      $ret['Msg'] = mysql_error();
    }else{
      $ret['IsSuccess'] = true;
      $ret['Msg'] = 'add success';
      $ret['Data'] = mysql_insert_id();
    }
	}catch(Exception $e){
     $ret['IsSuccess'] = false;
     $ret['Msg'] = $e->getMessage();
  }
  return $ret;
}

function listCalendarByRange($sd, $ed){
  $ret = array();
  $ret['events'] = array();
  $ret["issort"] =true;
  $ret["start"] = php2JsTime($sd);
  $ret["end"] = php2JsTime($ed);
  $ret['error'] = null;
  try{
    $db = new DBConnection();
    $db->getConnection();
    $sql = "select * from `pr_community_events` where `catid`<>0 and `startdate` between '"
      .php2MySqlTime($sd)."' and '". php2MySqlTime($ed)."'";
    $handle = mysql_query($sql);
    //echo $sql;
    $sqlinst= "select * from `pr_users` where 1"; //not working
    $handleinst = mysql_query($sqlinst); // not working
    
    while ($row = mysql_fetch_object($handle)) {
      //$ret['events'][] = $row;
      //$attends = $row->AttendeeNames;
      //if($row->OtherAttendee){
      //  $attends .= $row->OtherAttendee;
      //}
      //echo $row->StartTime;
      $ret['events'][] = array(
                $row->id,
        $row->title,
        php2JsTime(mySql2PhpTime($row->startdate)),
        php2JsTime(mySql2PhpTime($row->enddate)),
        $row->allday,
        0, //more than one day event
        //$row->InstanceType,
        0,//Recurring event,
        $row->Color,
        1,//editable
        $row->location, 
        $row->InstructorID,             
        ''  //$attends

  /*      
        $row->id,
        0, //$row->parent,
        0, //$row->catid,
        0, //$row->contentid,
        '', //$row->type,
        $row->title,
        $row->location,
        '', //$row->summary,
        $row->description,
        0, //$row->creator,
        php2JsTime(mySql2PhpTime($row->startdate)),
        php2JsTime(mySql2PhpTime($row->enddate)),
        0, //$row->permission,
        '', //$row->avatar,
        '', //$row->thumb,
        0, //$row->invitedcount,
        0, //$row->confirmedcount,
        0, //$row->declinedcount,
        0, //$row->maybecount,
        0, //$row->wallcount,
        0, //$row->ticket,
        0, //$row->allowinvite,
        '', //$row->created,
        0, //$row->hits,
        0, //$row->published,
        0, //$row->latitude,
        0, //$row->longitude,
        0, //$row->offset,
        $row->allday,

        '', //$row->repeat,
        '', //$row->repeatend,
       
        
        */
        
      );
    }
	}catch(Exception $e){
     $ret['error'] = $e->getMessage();
  }
  return $ret;
}

function listCalendar($day, $type){
  $phpTime = js2PhpTime($day);
  //echo $phpTime . "+" . $type;
  switch($type){
    case "month":
      $st = mktime(0, 0, 0, date("m", $phpTime), 1, date("Y", $phpTime));
      $et = mktime(0, 0, -1, date("m", $phpTime)+1, 1, date("Y", $phpTime));
      break;
    case "week":
      //suppose first day of a week is monday 
      $monday  =  date("d", $phpTime) - date('N', $phpTime) + 1;
      //echo date('N', $phpTime);
      $st = mktime(0,0,0,date("m", $phpTime), $monday, date("Y", $phpTime));
      $et = mktime(0,0,-1,date("m", $phpTime), $monday+7, date("Y", $phpTime));
      break;
    case "day":
      $st = mktime(0, 0, 0, date("m", $phpTime), date("d", $phpTime), date("Y", $phpTime));
      $et = mktime(0, 0, -1, date("m", $phpTime), date("d", $phpTime)+1, date("Y", $phpTime));
      break;
  }
  //echo $st . "--" . $et;
  return listCalendarByRange($st, $et);
}

function updateCalendar($id, $st, $et){
  $ret = array();
  try{
    $db = new DBConnection();
    $db->getConnection();
    $sql = "update `pr_community_events` set"
      . " `startdate`='" . php2MySqlTime(js2PhpTime($st)) . "', "
      . " `enddate`='" . php2MySqlTime(js2PhpTime($et)) . "' "
      . "where `id`=" . $id;
    //echo $sql;
		if(mysql_query($sql)==false){
      $ret['IsSuccess'] = false;
      $ret['Msg'] = mysql_error();
    }else{
      $ret['IsSuccess'] = true;
      $ret['Msg'] = 'Succefully';
    }
	}catch(Exception $e){
     $ret['IsSuccess'] = false;
     $ret['Msg'] = $e->getMessage();
  }
  return $ret;
}

function updateDetailedCalendar($id, $st, $et, $sub, $ade, $dscr, $loc, $color, $tz){
  $ret = array();
  try{
    $db = new DBConnection();
    $db->getConnection();
    $sql = "update `pr_community_events` set"
      . " `startdate`='" . php2MySqlTime(js2PhpTime($st)) . "', "
      . " `enddate`='" . php2MySqlTime(js2PhpTime($et)) . "', "
      . " `title`='" . mysql_real_escape_string($sub) . "', "
      . " `allday`='" . mysql_real_escape_string($ade) . "', "
      . " `description`='" . mysql_real_escape_string($dscr) . "', "
      . " `location`='" . mysql_real_escape_string($loc) . "' "
    //  . " `color`='" . mysql_real_escape_string($color) . "' "
      . "where `id`=" . $id;
    //echo $sql;
		if(mysql_query($sql)==false){
      $ret['IsSuccess'] = false;
      $ret['Msg'] = mysql_error();
    }else{
      $ret['IsSuccess'] = true;
      $ret['Msg'] = 'Succefully';
    }
	}catch(Exception $e){
     $ret['IsSuccess'] = false;
     $ret['Msg'] = $e->getMessage();
  }
  return $ret;
}

function removeCalendar($id){
  $ret = array();
  try{
    $db = new DBConnection();
    $db->getConnection();
    $sql = "delete from `pr_community_events` where `id`=" . $id;
		if(mysql_query($sql)==false){
      $ret['IsSuccess'] = false;
      $ret['Msg'] = mysql_error();
    }else{
      $ret['IsSuccess'] = true;
      $ret['Msg'] = 'Succefully';
    }
	}catch(Exception $e){
     $ret['IsSuccess'] = false;
     $ret['Msg'] = $e->getMessage();
  }
  return $ret;
}




header('Content-type:text/javascript;charset=UTF-8');
$method = $_GET["method"];
switch ($method) {
    case "add":
        $ret = addCalendar($_POST["CalendarStartTime"], $_POST["CalendarEndTime"], $_POST["CalendarTitle"], $_POST["IsAllDayEvent"]);
        break;
    case "list":
        $ret = listCalendar($_POST["showdate"], $_POST["viewtype"]);
        break;
    case "update":
        $ret = updateCalendar($_POST["calendarId"], $_POST["CalendarStartTime"], $_POST["CalendarEndTime"]);
        break; 
    case "remove":
        $ret = removeCalendar( $_POST["calendarId"]);
        break;
    case "adddetails":
        $st = $_POST["stpartdate"] . " " . $_POST["stparttime"];
        $et = $_POST["etpartdate"] . " " . $_POST["etparttime"];
        if(isset($_GET["id"])){
            $ret = updateDetailedCalendar($_GET["id"], $st, $et, 
                $_POST["Subject"], isset($_POST["IsAllDayEvent"])?1:0, $_POST["Description"], 
                $_POST["Location"], $_POST["colorvalue"], $_POST["timezone"]);
        }else{
            $ret = addDetailedCalendar($st, $et,                    
                $_POST["Subject"], isset($_POST["IsAllDayEvent"])?1:0, $_POST["Description"], 
                $_POST["Location"], $_POST["colorvalue"], $_POST["timezone"]);
        }        
           
        
        
        break; 


}
echo json_encode($ret); 



?>