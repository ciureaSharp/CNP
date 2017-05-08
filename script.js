/**
 * Created by ciure on 5/8/2017.
 */

$('#btn_genereaza').click(function (e) {
    e.preventDefault();
    $.post('randomcnp.php', function (data) {
        $('#cnp').val(data);
    });
});
$('#btn_verifica').click(function (e) {
    e.preventDefault();
    var cnp = $('#cnp').val();
    $('#rez').val(cnp);
    if (cnp == "") {
        alert('CNP nu exista. Apasa "Genereaza cnp".');
    } else {
        $.ajax({
            url: '//devlaboratory.digitaladvisors.ro/clients/24d58832a062cf808dcebc196b5b1b98/cnp_app/validatecnp.php',
            data: {
                action: 'get_cnp_info',
                cnp: cnp
            },
            type: 'post',
            success: function (data) {
                data = $.parseJSON(data);
                var sex = data['sex'];
                var data_nasterii = data['data_nasterii'];
                var varsta = data['varsta'];
                var locul_nasterii = data['locul_nasterii'];
                $.ajax({
                    url: '//devlaboratory.digitaladvisors.ro/clients/24d58832a062cf808dcebc196b5b1b98/cnp_app/validatecnp.php',
                    data:{
                        action: 'add_user_data',
                        cnp: cnp,
                        sex: sex,
                        data_nasterii: data_nasterii,
                        varsta: varsta,
                        locul_nasterii: locul_nasterii
                    },
                    type: 'post',
                    success: function(data){
                        if($.isNumeric(data)){
                            alert('success');
                        }else {
                            alert(data);
                        }
                    }
                });
            }
        });
    }
});