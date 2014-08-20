<?php
    session_start();
if (!(isset($_SESSION['user_name']))) {
     header('Location: login.php');
     }
    ?>
<html>
    <head>
        <meta http-equiv="content-type" content="text/json; charset=utf-8" />
        <title>
            Himalaya
        </title>
        <link href="css/datepicker.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <script type="text/javascript" charset="utf-8" language="javascript" src="js/jquery.js"></script>
        <link rel="shortcut icon" type="image/ico" href="http://www.datatables.net/favicon.ico" />
        <link href="css/popup.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="css/DT_bootstrap.css">
        <link href="css/bootstrap.css" rel="stylesheet">
        <script src="js/bootstrap-dropdown.js"></script>
        <script src="js/setting.js"></script>
        <script src="datePicker/js/bootstrap-datepicker.js"></script>
        <script>
            $(document).ready(function()
            {
                
                $('.addDesc').val('');
                
                $('#date').datepicker({
                        format: "yyyy-mm-dd",
                        startDate: "today"
                  });
                  $('#date1').datepicker({
                        format: "yyyy-mm-dd",
                        startDate: "today"
                  });
                
        
                   $("#addEvents").click(function() {
                    $('#hidden').show();
                    $("#popup_name9").fadeIn(500);
                });
                
                
                $('.addGellery').live("click",function() {
                    
                  var id=$(this).attr('id');
                  window.location.href='eventEntry.php?id='+id;  
                });
                
                
                $(".viewGallery").live("click",function() {
                  var id=$(this).attr('viewValue');
                  window.location.href='viewGallery.php?id='+id;  
                });
                
                $("#saveAddEvent").click(function(){
                    var addevent=$(".addeventname").val();
                    addevent = addevent.substring(0, 1).toUpperCase() + addevent.substring(1);
                    var addloc= $(".addlocation").val();
                    addloc = addloc.substring(0, 1).toUpperCase() + addloc.substring(1);
                    var adduniv=$(".adduniversity").val();
                    adduniv = adduniv.substring(0, 1).toUpperCase() + adduniv.substring(1);
                    var addevdate=$(".addeventdate").val();
                    var addDesc=$('.addDesc').val();
                    addDesc = addDesc.substring(0, 1).toUpperCase() + addDesc.substring(1);
                    if (addevent != '' && addloc != '' && adduniv != '' && addevdate !='' && addDesc != '')
                    { 
                        var formData = new FormData(document.forms.namedItem("event5"));                        
                        formData.append("event_name", addevent);
                        formData.append("location", addloc);
                        formData.append("university_name", adduniv);
                        formData.append("event_date", addevdate); 
                        formData.append("event_desc", addDesc); 
                        var oReq = new XMLHttpRequest();
                        oReq.open("POST","index.php?action=add_events");
                        oReq.send(formData);
                        oReq.onreadystatechange = function(aEvt) {                                             
                        if (oReq.readyState == 4) {                                                     
                            if (oReq.status == 200) {
                                var json = JSON.parse(oReq.responseText);
                                if(json['log']==1)
                                    {
                                        $('#eventAddMessage').fadeIn('slow', function(){                                         
                                        });
                                        setTimeout(function() {
                                        window.location.href='events.php';
                                    }, 2000);
                                    }
                                    
                                    else { $('#eventerrormessage2').fadeIn('slow', function(){
                                    $('#eventerrormessage2').fadeOut(2000);
                                    });
                    }
                            }
                        }
                        
                    }
                    
                  }
                  else { $('#eventerrormessage').fadeIn('slow', function(){
                                    $('#eventerrormessage').fadeOut(2000);
                                    });
                    }
                    
                });
                
                
                
                $('#hidden').click(function() {
                    $("#popup_name9").fadeOut();
                    $("#popup_name18").fadeOut();
                    $('#hidden').hide();
                });
                
                
                $("#cancelAddEvent").click(function()
                {  
                    $(".addeventname").val('');
                    $(".addlocation").val('');
                    $(".adduniversity").val('');
                    $(".addeventdate").val('');
                    $('.addDesc').val('');
                    $("#popup_name9").hide();
                    $('#hidden').hide();
                });
                
                
                
                $(".edit").live("click",function() {
                    eventid=$(this).attr('editValue');
                   var event=$('.event'+eventid).attr('oldevent');
                   var univ=$('.univ'+eventid).attr('olduniv');
                   var loc=$('.loc'+eventid).attr('oldloc');
                   var date=$('.date'+eventid).attr('olddate');
                       oldDate=date;
                   var desc=$('.desc'+eventid).attr('olddesc');
                   $('.newevent').val(event);
                   $('.newlocation').val(loc);
                   $('.newuniversity').val(univ);
                   $('.newdate').val(date);
                   $('.newDesc').val(desc);
                   $("#popup_name18").fadeIn(500);
                   $('#hidden').show();
                });
                
                
    
    
               $("#saveEditedEvent").click(function()
                {
                    var event_name =$('.newevent').val();
                    event_name = event_name.substring(0, 1).toUpperCase() + event_name.substring(1);
                    var location =$('.newlocation').val();
                    location = location.substring(0, 1).toUpperCase() + location.substring(1);
                    var university_name =$('.newuniversity').val();
                    university_name = university_name.substring(0, 1).toUpperCase() + university_name.substring(1);
                    var event_date =$('.newdate').val();
                    var desc=$('.newDesc').val();
                    desc = desc.substring(0, 1).toUpperCase() + desc.substring(1);
                    var c=oldDate.localeCompare(event_date);
                    console.log(c);
                    if(c == 0)
                        {
                           event_date='same'; 
                        }
                        
                    if (event_name != '' && location != '' && university_name != '' && event_date !='' && desc != '')
                    {                                         
                        var formData = new FormData(document.forms.namedItem("event"));                        
                        formData.append("event_name", event_name);
                        formData.append("location", location);
                        formData.append("university_name", university_name);
                        formData.append("event_date", event_date);
                        formData.append("id", eventid); 
                        formData.append("desc", desc);   
                        var oReq = new XMLHttpRequest();
                        oReq.open("POST","index.php?action=update_event");
                        oReq.send(formData);
                        oReq.onreadystatechange = function(aEvt) {                                             
                        if (oReq.readyState == 4) {                                                     
                            if (oReq.status == 200) {
                                var json = JSON.parse(oReq.responseText);
                                console.log(json);
                                if(json['log']==1)
                                    {
                                        $('#eventEdited').fadeIn('slow', function(){                                         
                                        });
                                        setTimeout(function() {
                                        window.location.href='events.php';
                                    }, 2000);
                                    }
                            }
                        }
                        
                    } 
                      
                    }
                    else { $('#eventEmpty').fadeIn('slow', function(){
                                    $('#eventEmpty').fadeOut(2000);
                                    });
                    }

                });

               
               
               $("#cancelEventupadte").click(function()
                {
                    
                    $("#popup_name18").hide();
                    $('#hidden').hide();
                });
               
               
               
               $(".delete").live("click",function() {
                    var id=$(this).attr('deleteValue');
                    var val=confirm("Do want to delete this");
                    if(val)
                        {
                    $.ajax({
                            type: "POST",
                            url: 'index.php?action=delete_event',
                            data: {id:id},
                            dataType: "json",
                            success: function(data) {
                                       window.location.href='events.php';
                                    }
                        });
                        }
                });
               
               
               
    
                
                
                
            
              getEventDetail();
            function getEventDetail()
            {
                $.ajax({
                    type: "GET",
                    url: 'index.php?action=get_event_details',
                    //data: {offercity: offercity},
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                       // return false;
                       // $("#loading").hide();
                        var count = data['data'].length;
                        var i = 0;
                        var tables = "<thead>";
                        tables += "<tr>";
                        tables += "<th style='text-align:center;width: 135px;'>Event Name</th>";
                        tables += "<th style='text-align:center;width: 135px;'>Location</th>";
                        tables += "<th style='text-align:center;width: 115px;'>Institute Name</th>";
                        tables += "<th style='text-align:center;width: 115px;'>Event Description</th>";
                        tables += "<th style='text-align:center;width: 100px;'>Event Date</th>";
                        tables += "<th style='text-align:center;width: 100px;'>Preview Image</th>";
                        tables += "<th style='text-align:center;width: 100px;'>View Gallery</th>";
                        tables += "<th style='text-align:center;width: 100px;'>Action</th>";
                        tables += "</tr>";
                        tables += "</thead>";
                        tables += "<tbody>";
                        while (i < count)
                        {
                            tables += "<tr>";
                            tables += "<td style='text-align:center;font-size: 15px;' class='event"+data['data'][i]['event_id']+"' oldevent='"+data['data'][i]['event_name']+"'>" + data['data'][i]['event_name'];
                            tables += "</td>";
                            tables += "<td style='text-align:center;font-size: 15px;' class='loc"+data['data'][i]['event_id']+"' oldloc='"+data['data'][i]['location']+"'>" + data['data'][i]['location'];
                            tables += "</td>";
                            tables += "<td style='text-align:center;font-size: 15px;' class='univ"+data['data'][i]['event_id']+"' olduniv='"+data['data'][i]['university_name']+"'>" + data['data'][i]['university_name'] ;
                            tables += "</td>";
                            tables += "<td style='text-align:center;font-size: 15px;' class='desc"+data['data'][i]['event_id']+"' olddesc='"+data['data'][i]['event_desc']+"'>" + data['data'][i]['event_desc'] ;
                            tables += "</td>";
                            tables += "<td style='text-align:center;font-size: 15px;' class='date"+data['data'][i]['event_id']+"' olddate='"+data['data'][i]['event_date']+"'>" + data['data'][i]['event_date'];
                            tables += "</td>";
                            tables += "<td style='text-align:center;font-size: 15px;'><img src="+ data['data'][i]['image_name']+" alt='no image'  height='50px' width='50px' /> ";
                            tables += "</td>";
                            tables += "<td style='text-align:center;font-size: 15px;'><input type='button' name='edit' value='View' class='btn btn-small btn-primary viewGallery' viewValue='"+data['data'][i]['event_id']+"' style='width: 80px;'/>";
                            tables += "<br/><input type='button' name='edit' value='Add Gallery'   class='btn btn-small btn-primary addGellery' style='width: 80px;margin-top:21px;' id='"+data['data'][i]['event_id']+"'/></td>";
                            tables += "<td style='text-align:center;font-size: 15px;'><input type='button' name='edit' value='Edit' class='btn btn-small btn-primary edit' editValue='"+data['data'][i]['event_id']+"' style='width: 70px;'/>";
                            
                            tables += "<br><br><input type='button' name='delete' value='Delete' class='btn btn-small btn-danger delete' deleteValue='"+data['data'][i]['event_id']+"' style='width: 70px;'/>";
                            tables += "</td>";
                            i++;
                            tables += "</tr>";
                        }
                        tables += "</tbody>";
                        $('#example').html(tables);
                        $('#example').dataTable({"sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>", "aaSorting": [[4, "desc"]]
                        });
                            


                    }
                });
            }
            
            
            
            
            });
           

        </script>
        
        <style>
            #eventError{
                background: dimgray;
                color: rgb(250, 244, 244);
                font-size: 20px;
                display:none;
            }
            #eventErrortext{
                margin-left: 280px;
            }
            
            #eventheading{
                color:#E4DB0D;
            }
        </style>
    </head>

    <body>
        <div id="hidden" style="display: none; height: 800px; width: 100%; opacity: 0.7;background: #000;position: fixed;"></div>
        <?php
        include 'header.php';
        ?>
        
        <div id="main">
             <div style="margin-bottom:-40px"><button class="btn btn-large btn-primary" type="button" id="addEvents">Add Event</button></div>
            <div id="tablecontent" style="margin-top: 60px;">
                <table cellpadding='0' cellspacing='0' border='0' class='table table-striped table-bordered' id='example'>
                </table>
            </div>
        </div>
    
        
        <div id="popup_name9" class="popup_block" style="height: 430px;width:500px;text-align:center;margin:-160px 0px 0px -250px" >
            <p  class="addnewstitle">Add Event</p>
            <b style="padding: 0px 68px 0px 27px;">Event name:</b> <input type="text" name="eventname" id="extracity" class="addeventname" placeholder="enter event name"> <br>
            <b style="padding: 0px 97px 0px 23px;">Location:</b><input type="text" name="eventlocation" id="extracity" class="addlocation" placeholder="enter location"><br/> 
            <b style="padding: 0px 50px 0px 30px;"> Institute name:</b><input type="text" name="extracity" id="extracity" class="adduniversity" placeholder="enter institute name"> <br>
            <b style="padding: 0px 106px 0px 26px;">Description:</b><textarea rows="3"  style="resize:none;" class="addDesc" placeholder="enter event description" >
            </textarea><br/> 
            <b style="padding: 0px 109px 0px 30px;"> Event date:</b><input type="text" name="extracity" id="date" class="addeventdate" placeholder="enter event date"> <br>
           <form method="post" id="upload" name="event5" enctype="multipart/form-data">
            <b style="padding: 0px 77px 0px 59px;">Preview image:</b><input type="file" name="file" id="file">
            </form>
            <p id="eventAddMessage" style="display:none;text-align:center;color:green;">Event successfully inserted</p>
            <p id="eventerrormessage" style="display:none;text-align:center;color:red;">Please fill all fields</p>
            <p id="eventerrormessage2" style="display:none;text-align:center;color:red;">Please select a file</p>
            <button type="button" value="CANCEL" id="cancelAddEvent" class='btn btn-danger' style="width:100px;margin-left:-6px; margin-right:-75px;" />CANCEL</button>
            <input type="button" id="saveAddEvent" value="SUBMIT" class='btn btn-primary submitcity'  style="width:100px;">
            
            
        </div>
        
        
        
       <div id="popup_name7" class="popup_block" style="height: 340px;width:500px;text-align:center;margin:-160px 0px 0px -250px" style="display:none;">
            <p id="newcity" >Reset password</p>
            <b style="margin-right:65px;">User name:</b> <input type="text" name="username" id="extracity1" class="username" placeholder="enter user name" style="padding-left:6px"> <br>
            <b style="margin-right:50px;">Old password:</b><input type="password" name="oldpassword" id="extracity2" class="oldpassword" placeholder="enter old password"> <br>
            <b style="margin-right:40px;"> New password:</b><input type="password" name="newpassword" id="extracity3" class="newpassword" placeholder="enter new password"> <br>
            <b style="margin-right:11px;margin-left:5px;"> Confirm password:</b><input type="password" name="confirmpassword" id="extracity4" class="confirmpassword" placeholder="confirm password"> <br><br>
            <p id="update" style="display:none;text-align:center;color:green;">password successfully updated</p>
            <p id="notupdated" style="display:none;text-align:center;color:red;">password not updated</p>
            <p id="notmatched" style="display:none;text-align:center;color:red;">confirm password not matched</p>
            <p id="empty" style="display:none;text-align:center;color:red;">Please fill all fields</p>
            <button type="button" value="CANCEL" id="cancelupdate" class='btn btn-danger' style="width:100px;">CANCEL</button>
            <input type="button" id="updatepass" value="SAVE" class='btn btn-primary submitcity'  style="width:100px;margin-left:50px;">
        </div>
    
        
        <div id="popup_name18" class="popup_block" style="height: 460px;width:500px;text-align:center;margin:-160px 0px 0px -250px" >
            
                      <div><div class="addnewstitle">Edit Event</div><br>
                           <b style="padding: 0px 57px 0px 6px;font-size:20px;">Event name:</b> <input type="text" name="eventname" id="extracity" class="newevent" placeholder="enter event name"> <br>
                           <b style="padding: 0px 90px 0px 3px;font-size:20px;">Location:</b><input type="text" name="eventlocation" id="extracity" class="newlocation" placeholder="enter location"><br/> 
                           <b style="padding: 0px 36px 0px 11px;font-size:20px;"> Institute name:</b><input type="text" name="extracity" id="extracity" class="newuniversity" placeholder="enter university name"> <br>
                           <b style="padding: 0px 99px 0px 7px;font-size:20px;">Description:</b><textarea rows="3"  style="resize:none;" class="newDesc" placeholder="enter event description" >
                           </textarea><br/> 
                           <b style="padding: 0px 105px 0px 12px;font-size:20px;"> Event date:</b><input type="text" class="newdate" id="date1" placeholder="enter event date"> <br><br>
                           <form method="post" enctype="multipart/form-data" id="upload" name="event">
                                <b style="padding: 0px 71px 0px 45px;font-size:20px;">Preview image:</b><input type="file" name="file" /><br>
                           </form>
                           <p id="eventEdited" style="display:none;text-align:center;color: green;">Event successfully updated</p>
                           <p id="eventEmpty" style="display:none;text-align:center;color:red;">Please fill all fields</p>
                           
                            <button type="button" value="CANCEL" id="cancelEventupadte" class='btn btn-danger' style="width:100px;margin-left:15px;margin-right: -80px;">CANCEL</button>
                           
                            <input type="button" id="saveEditedEvent" value="SUBMIT" class='btn btn-primary submitcity'  style="width:100px;">
                       </div>
            
        </div>
        
        
    <script type="text/javascript" charset="utf-8" language="javascript" src="js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf-8" src="js/dataTables.bootstrap.js"></script>
    
</body>
</html>