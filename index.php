<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('max_execution_time', 300);
include_once('functions.php')
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
    <div class="row" style="margin: 50px 0px 50px 0px">
        <div class="col-md-12">
            <div class="col-md-4">
                <button id="btn_genereaza" class="btn btn-success btn-lg btn-block" type="submit">Genereaza</button>
            </div>
            <div class="col-md-4">
                <button id="btn_insereaza" class="btn btn-info btn-lg btn-block" type="submit">Insereaza</button>
            </div>
            <div class="col-md-4">
                <button id="btn_Sterge" class="btn btn-danger btn-lg btn-block" type="submit">Sterge</button>
            </div>
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="alert" id="main_result" style="margin-top: 20px; "><p class="text-center"
                                                                                      id="main_result_text"></p></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="margin-bottom: 50px">
        <div class="col-md-12">
            <div class="table-responsive" id="tabel">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Gen</th>
                        <th>Data nasterii</th>
                        <th>Varsta</th>
                        <th>Locul nasterii</th>
                        <th>CNP</th>
                        <th>Data adaugarii</th>
                        <th>
                            <label style="padding-bottom: 0px"><input type="checkbox" id="select_all" checked=''>&nbsp;&nbsp;Selecteaza tot</label>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $user = get_users();
                    foreach ($user as $u) {
                        echo "<tr>
                                <td>" . $u['id'] . "</td>
                                <td>" . $u['sex'] . "</td>
                                <td>" . $u['data_nasterii'] . "</td>
                                <td>" . $u['varsta'] . "</td>
                                <td>" . $u['locul_nasterii'] . "</td>
                                <td>" . $u['cnp'] . "</td>
                                <td>" . $u['timestamp'] . "</td>
                                <td class='text-center'><input type='checkbox' name='user_id' value='" . $u['id'] . "'></td>
                            </tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script>
    $('#btn_Sterge').click(function () {
       var ids = $('input:checkbox:checked').map(function () {
           return this.value;
       }).get();
        console.log(ids);
    });

    $('#select_all').click(function () {
        $("input[name='user_id']").prop('checked', this.checked);
    });

    $('#btn_genereaza').click(function (e) {
        e.preventDefault();
        $.post('randomcnp.php', function (data) {
            $("#main_result").addClass("alert-success");
            $('#main_result_text').text(data);
        });
    });

    $('#btn_insereaza').click(function (e) {
        e.preventDefault();
        var cnp = $('#main_result_text').text();
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
                                $("#main_result").removeClass('alert-success');
                                $("#main_result").addClass('alert-info');
                                $("#main_result_text").text("Inserat cu succes");
                                window.setTimeout(function () {
                                    location.reload();
                                }, 2000);
                            } else {
                                $("#main_result").removeClass('alert-success');
                                $("#main_result").addClass('alert-danger');
                                $("#main_result_text").text(data);
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

