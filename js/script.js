
var $j = jQuery.noConflict();

$j( document ).ready(function() {

  alert('I am here.');

  // $j.ajax({ 
  //       url: apiurl.ajax_url + "?action=get_clientparams",
  //       type   : 'GET',
  //       data   : {
  //                   action : 'get_clientparams'
  //               },
  //       contentType: 'application/json',
  //       dataType: "json",
  //       success: function(data){
         
  //          var ar_color1 = data.color1;
  //          var ar_color2 = data.color2;
  //          var ar_color3 = data.color3;
  //          var ar_color4 = data.color4;
  //          var ar_phone = data.phone;
  //          var ar_markets = data.markets;
  //          var ar_ga = data.ga;


  //         //alert(ar_phone);
  //          document.documentElement.style.setProperty('--color1', ar_color1);
  //          document.documentElement.style.setProperty('--color2', ar_color2);
  //          document.documentElement.style.setProperty('--color3', ar_color3);
  //          document.documentElement.style.setProperty('--color4', ar_color4);
  //          document.documentElement.style.setProperty('--phone', ar_phone);
  //          document.documentElement.style.setProperty('--ga', ar_ga);

  //          tmp = document.getElementById('clientphone1');
  //          if(tmp!==null){
  //             tmp.innerText = ar_phone;
  //           }

  //       },
  //       error: function () {
  //           alert("failed");
  //           alert(data.status + ':' + data.message);
  //       }
  //     }
  // );

  // $j('.ar-submit').on('click',function(e) {
  //   alert('AA');
  //   e.preventDefault();
  //   arAccuracy = e.target.dataset.accuracy;
  //   //alert(arAccuracy);
  //   $j(e.target).parents('#ar-form').submit();
  // });


  $j('#formcontact').on('submit', function(e){
    alert('AB');
    e.preventDefault();

    $j.ajax({
        url    : apiurl.ajax_url,
        type   : 'post',
        data   : $j('#formcontact').serialize(),
        success: function( response ) {
          var json = $j.parseJSON( response );
          console.log(json);
          if (json.code == 200){

            var min = parseInt(json.min,10).toLocaleString('en-CA', {style: 'currency', currency: 'CAD'});
            var max = parseInt(json.max,10).toLocaleString('en-CA', {style: 'currency', currency: 'CAD'});
            $j('.min').html(min);
            $j('.max').html(max);
            $j('.accuracy').html(json.accuracy);
            if (json.accuracy == 80){
              var single = parseInt(json.single,10).toLocaleString('en-CA', {style: 'currency', currency: 'CAD'});
              $j('.single').html(single);
            }
          }
          else if(json.code == 401){
            // $j('#'+json.form).show(); //display form
            arModal($j('#'+json.form));
          }
          else if(json.code == 503){
              alert("Service call error. Please resubmit.");
          }
          else if(json.code == 601){
              arModal($j('#rate-form')); //risk - contact us
          }

          //else {
            //$j('#form_response').html(json.message); //display error
          //}
          //$j('#form_response').html( response );
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