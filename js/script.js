
var $j = jQuery.noConflict();

$j( document ).ready(function() {

  $j('#formcontact').on('submit', function(e){

    arfn = "FirstName: " + $j("#idFirstName").val();
    arln = "LastName: " + $j("#idLastName").val();
    aremail = "Email: " + $j("#idEmail").val();
    arph = "Phone: " + $j("#idPhone").val();
    arcity = "City: " + $j("#idCity").val();

    if(arfn.trim()==""){

      var sMsg = "Please enter contact information to proceed.";
      tmp = document.getElementById('contacterror');
      if(tmp!==null){
              tmp.innerHTML = sMsg;
      }
    }

    alert('AB');
    e.preventDefault();

    tmp = document.getElementById('varinput');
    if(tmp!==null){
        tmp.innerHTML = arfn + ' <br> ' + arln+ ' <br> ' + aremail+ ' <br> ' + arph+ ' <br> ' + arcity;
    }

    $j.ajax({
        url    : apiurl.ajax_url,
        type   : 'post',
        data   : $j('#formcontact').serialize(),
        success: function( response ) {
          var json = $j.parseJSON( response );
          console.log(json);
          if (json.code == 200){

            var vfirstname = json.v_firstname;
            var vlastname = json.v_lastname;
            $j('.vfirstname').html(vfirstname);
            $j('.vlastname').html(vlastname);
            $j('.error').html(json.error);
          }
          else if(json.code == 401){
            alert("Forbidden error. Please resubmit.");
          }
          else if(json.code == 503){
              alert("Service call error. Please resubmit.");
          }

          //else {
            //$j('#formcontact').html(json.message); //display error
          //}
          //$j('#formcontact').html( response );
        },
        error: function(request, err) {
            if (status == "timeout") {
                alert("failed");
            } else {
                // another error occured  
                alert("error: " + request + status + err);
            }
        }
    });

  });

});