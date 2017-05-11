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


</head>
<body>

<div class="container">
    <div class="row" style="margin: 150px 0px 150px 0px">
        <div class="col-md-12">
            <div id="buttons" class="btn-group btn-group-justified" role="group" aria-label="...">
                <div class="btn-group" role="group">
                    <button id="btn_genereaza" class="btn btn-default" type="submit">Genereaza</button>
                </div>
                <div class="btn-group" role="group">
                    <button id="btn_verifica" class="btn btn-default" type="submit">Insereaza</button>
                </div>
                <div class="btn-group" role="group">
                    <button id="btn_sterge" class="btn btn-default" type="submit">Sterge</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div id="tabel">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Data nasterii</th>
                        <th>Varsta</th>
                        <th>Locul nasterii</th>
                        <th>CNP</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>


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
                        data: {
                            action: 'add_user_data',
                            cnp: cnp,
                            sex: sex,
                            data_nasterii: data_nasterii,
                            varsta: varsta,
                            locul_nasterii: locul_nasterii
                        },
                        type: 'post',
                        success: function (data) {
                            if ($.isNumeric(data)) {
                                alert('success');
                            } else {
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

