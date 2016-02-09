$(document).ready(function() {
    $('#calc-form').on('submit', function (e) {
        e.preventDefault();
        
        $.ajaxSetup({
          headers: {
            'X-CSRF-Token': $('input[name="_token"]').val()
          }
        });

        var token = $('input[name="_token"]').val();
        var user = $('#temp-user-payload-input').val();
        var workplace = $('#workplace-search-input').val();
        var freqLoc1 = $('#freq-loc-input-1').val();
        var freqLoc2 = $('#freq-loc-input-2').val();
        var freqLoc3 = $('#freq-loc-input-3').val();
        // var freqLoc4 = $('#freq-loc-input-4').val();
        // var freqLoc5 = $('#freq-loc-input-5').val();
        workplace = workplace.split(", ");
        $.ajax({
            type: "POST",
            url: "/home/workplace",
            data: {_token: token, temp_user_id: user, address: workplace[0], city: workplace[1], state: workplace[2], lat: 40.75175779999999
, lng: -73.9755189},
            success: function(data) {
                console.log(data);
            },
            error: function (msg) {
                console.log(msg);
            },
            dataType: "json"
        });
    });
});