
var $j = jQuery.noConflict();

function submitForm(submit){
    if(submit.value=="Fetch")
    {

          tmp = document.getElementById('varinput');
          if(tmp!==null){
              tmp.innerHTML = "";
          }

          $j.ajax({
            url    : apiurl.ajax_url,
            type   : 'GET',
            data   : "&FirstName="+$j("#idFirstName").val(),
            success: function( response ) {
              console.log(response);
              var json = $j.parseJSON( response );
              console.log("person:" + json); 
              
              if(response) {
                  try {
                      
                      //tmp.innerHTML = response
                       var htmlText = "";
                      for ( var key in json ) {
                          
                          if (key==0){
                            htmlText += '<div class="row">';
                            htmlText += '<div class="column" style="background-color:#000000;">FirstName</div>';
                            htmlText += '<div class="column" style="background-color:#000000;">LastName</div>';
                            htmlText += '<div class="column" style="background-color:#000000;">Id</div>';
                            htmlText += '</div>';
                          }

                          htmlText += '<div class="row">';
                          htmlText += '<div class="column" style="background-color:#aaa;">FirstName: ' + json[key][1].split(":")[1] + '</div>';
                          htmlText += '<div class="column" style="background-color:#bbb;">LastName: ' + json[key][2].split(":")[1] + '</div>';
                          htmlText += '<div class="column" style="background-color:#ccc;">Id: ' + json[key][0].split(":")[1] + '</div>';
                          htmlText += '</div>';
                      }

                      tmp.innerHTML = htmlText;


                  } catch(e) {
                      aldivrt(e); // error in the above string (in this case, yes)!
               div  }
              }
            }
          });
    }else if(submit.value == "Done"){
  
            $j.ajax({
                url    : apiurl.ajax_url,
                type   : 'POST',
                data   : $j('#formcontact').serialize(),
                success: function( response ) {
                  var json = $j.parseJSON( response );
                  //console.log(json);
                  if (json.code == 200){

                    var vfirstname = "FirstName: " + json.v_firstname;
                    var vlastname = "LastName: " + json.v_lastname;
                    var vemail = "Email: " + json.v_email;
                    var vphone = "Phone: " + json.v_phone;
                    var vcity = "City: " + json.v_city;
                    var vlat = "Latitude: " + json.v_lat;
                    var vlong = "Longitude: " + json.v_long;
                    var vtemp = "Temperature (deg.): " + json.v_temp;

                    tmp = document.getElementById('varinput');
                    if(tmp!==null){
                        tmp.innerHTML = '<span style=\'color:blue\'>Feedback Loop</span>' + '<br>' + vfirstname + ' <br> ' + vlastname+ ' <br> ' + vemail+ ' <br> ' + vphone+ ' <br> ' + vcity
                            + '<br>' + vlat + '<br>' + vlong + '<br>' + vtemp;
                    }

                    $j('.error').html(json.error);
                  }
                  else if(json.code == 401){
                      var sMsg = "Forbidden error. Please resubmit.";
                      tmp = document.getElementById('contacterror');
                      if(tmp!==null){
                              tmp.innerHTML = sMsg;
                      }
                  }
                  else if(json.code == 503){
                      alert("Service call error. Please resubmit.");
                  }
                },
                error: function(request, err) {
                    if (status == "timeout") {
                        alert("failed");
                    } else {
                        // another error occured  
                        alert("error: " + request + status + err);
                    }
                }
              }); // POST call
    } 
}

$j( document ).ready(function() {

  $j('#formcontact').on('submit', function(e){

    arfn = "FirstName: " + $j("#idFirstName").val();
    // arcity = "City: " + $j("#idCity").val();

    if(arfn.trim()==""){

      var sMsg = "Please enter contact information to proceed.";
      tmp = document.getElementById('contacterror');
      if(tmp!==null){
              tmp.innerHTML = sMsg;
      }
    }

    e.preventDefault();

    // //ajax for POST
    // $j.ajax({
    //     url    : apiurl.ajax_url,
    //     type   : 'POST',
    //     data   : $j('#formcontact').serialize(),
    //     success: function( response ) {

    //       if(response) {
    //           try {
    //               var json = $j.parseJSON(response);
    //           } catch(e) {
    //               alert(e); // error in the above string (in this case, yes)!
    //           }
    //       }
    //       console.log(json);
    //       if (json.code == 200){

    //         var vfirstname = "FirstName: " + json.v_firstname;
    //         var vlastname = "LastName: " + json.v_lastname;
    //         var vemail = "Email: " + json.v_email;
    //         var vphone = "Phone: " + json.v_phone;
    //         var vcity = "City: " + json.v_city;
    //         var vlat = "Latitude: " + json.v_lat;
    //         var vlong = "Longitude: " + json.v_long;
    //         var vtemp = "Temperature (deg.): " + json.v_temp;

    //         tmp = document.getElementById('varinput');
    //         if(tmp!==null){
    //             tmp.innerHTML = vfirstname + ' <br> ' + vlastname+ ' <br> ' + vemail+ ' <br> ' + vphone+ ' <br> ' + vcity
    //                 + '<br>' + vlat + '<br>' + vlong + '<br>' + vtemp;
    //         }

    //         $j('.error').html(json.error);
    //       }
    //       else if(json.code == 401){
    //           var sMsg = "Forbidden error. Please resubmit.";
    //           tmp = document.getElementById('contacterror');
    //           if(tmp!==null){
    //                   tmp.innerHTML = sMsg;
    //           }
    //       }
    //       else if(json.code == 503){
    //           alert("Service call error. Please resubmit.");
    //       }
    //     },
    //     error: function(request, err) {
    //         if (status == "timeout") {
    //             alert("failed");
    //         } else {
    //             // another error occured  
    //             alert("error: " + request + status + err);
    //         }
    //     }
    //   }); // POST call

  });



});