<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('max_execution_time', 300);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Random CNP</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        #header {
            width: 250px;
            height: 200px;
            background-color: #333;
            box-shadow: 0px 4px 2px #333;
        }
    </style>

</head>
<body>

<div id="header">

</div>


<script
    src="https://code.jquery.com/jquery-3.2.1.min.js"
    integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
    crossorigin="anonymous">
</script>
<script>
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
</script>

</body>
</html>

