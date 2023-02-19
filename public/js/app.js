$('#time-select').prop( "hidden", true );
$('#time-select').prop( "disabled", true );

$('#labelTime').prop( "hidden", true );
$('#labelTime').prop( "disabled", true );

$('#selectPax').prop( "disabled", true );

$('#Pax').prop( "disabled", true );
$('#Pax').prop( "hidden", true );

$('#btn-resa').prop( "disabled", true );
$('#btn-resa').prop( "hidden", true );

function checkForm(){
    let reserHidden = true;
    if($('#name').val()!=="" && $('#LastName').val()!=="" && $('#email').val()!==""){
        reserHidden = false;
        if($('#selectPax').val()==null || $('#selectPax').val()==0){
            reserHidden = true;
        }
    }else{
        reserHidden = true;
    }
    $('#btn-resa').prop( "disabled", reserHidden );
    $('#btn-resa').prop( "hidden", reserHidden );
}

function showError(message){
    $('#msgErrorText').text(message);
    $('#msgError').prop('hidden', false);
}
function hideError(){
    $('#msgError').prop('hidden', true);
}

function getDate(){
    hideError();
    $('#time-select').find('option').remove();
    $('#time-select').find('optgroup').remove();
    $('#selectPax').find('option').remove();
    $('#selectPax').find('optgroup').remove();
    $('#selectPax').prop( "disabled", true );
    $('#Pax').prop( "hidden", true );
    checkForm();
    let dateselect = $("#scheduledDate" ).val();
    
    $.ajax({
        url: "/getdate",
        type: "POST",
        data: {"date": dateselect},
        dataType:'json',
        success: function (response) {
            var noonStartTime = response['noon']['start']['date'].slice(11,13);
            var noonEndTime = response['noon']['end']['date'].slice(11,13);
            var nightStartTime = response['night']['start']['date'].slice(11,13);
            var nightEndTime = response['night']['end']['date'].slice(11,13);

            if(noonStartTime == '00' && noonEndTime == '00' && nightStartTime == '00' && nightEndTime == '00'){
                showError("Le restaurant est fermer pour cette date, veillez selection une autre date.");
            }

            if(noonStartTime != '00' && noonEndTime != '00'){
                var noonTimes = [];
                for (let i = parseInt(noonStartTime); i < parseInt(noonEndTime); i++) {
                    noonTimes.push(i+':00');
                    noonTimes.push(i+':15');
                    noonTimes.push(i+':30');
                    noonTimes.push(i+':45');
                }
                noonTimes.push(response['noon']['end']['date'].slice(11,16));
                $('#time-select').append($('<optgroup>', { label: 'Midi'}));
                $.each(noonTimes, function (i, item) {
                    if(noonTimes.length != i+1){
                        $('#time-select').append($('<option>', { 
                            value: item,
                            text : item
                        }));
                    }
                });
            }

            if(nightStartTime != '00' && nightEndTime != '00'){
                var nightTimes = [];
                for (let i = parseInt(nightStartTime); i < parseInt(nightEndTime); i++) {
                    nightTimes.push(i+':00');
                    nightTimes.push(i+':15');
                    nightTimes.push(i+':30');
                    nightTimes.push(i+':45');
                }

                nightTimes.push(response['night']['end']['date'].slice(11,16));
                $('#time-select').append($('<optgroup>', { label: 'Soir'}));
                $.each(nightTimes, function (i, item) {
                    if(nightTimes.length != i+1){
                        $('#time-select').append($('<option>', { 
                            value: item,
                            text : item
                        }));
                    }
                });
            }

            $('#labelTime').prop( "disabled", false )
            $('#labelTime').prop( "hidden", false );
                
            $('#time-select').prop( "disabled", false )
            $('#time-select').prop( "hidden", false );

        },
        error: function(error){
            console.log("Something went wrong", error);
        }
    });
}

function getDispo(){
    hideError();
    $('#selectPax').find('option').remove();

    $.ajax({
        url: "/getdispo",
        type: "POST",
        data: {"date":$('#scheduledDate').val(), "time":$('#time-select').val()},
        dataType:'json',
        success: function (response) {
            var placeDispo = response['dispo'];            
            if(placeDispo === 0){
                showError("Désolé nous sommes complet pour ce service");
                
            }  else {
                $('#Pax').prop( "hidden", false );
                $('#selectPax').prop( "disabled", false );
            }
            $('#selectPax').append($('<option>', { label: 'Place Disponible', value: 0}));
            let nbCouvert=0;

            //{% if user %}
            //    nbCouvert = {{user.nbcouverts|raw}};
            //{% endif %}

            for (let i = 1; i <= placeDispo; i++) {
                let option = '<option>';
                $('#selectPax').append($(option, { 
                    value: i,
                    text : i
                }));
                if (nbCouvert == i){
                    $('#selectPax').val(i).change();
                }
            }
        },
        error: function(error){
            console.log("Something went wrong", error);
        }
    });
}
