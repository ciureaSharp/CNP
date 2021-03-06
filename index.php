<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
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
                                                                                      id="main_result_text"></p>
                    </div>
                    <div id="grup_butoane_confirmare" class="hidden">
                        <div class="col-md-3 col-md-offset-1">
                            <button id="btn_confirma_stergere" class="btn btn-success btn-sm btn-block"
                                    type="submit">Sterge
                            </button>
                        </div>
                        <div class="col-md-3 col-md-offset-4">
                            <button id="btn_renunta_stergere" class="btn btn-danger btn-sm btn-block" type="submit">
                                Renunta
                            </button>
                        </div>
                    </div>
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
                            <label style="padding-bottom: 0px"><input type="checkbox" id="select_all" checked=''>&nbsp;&nbsp;Selecteaza
                                tot</label>
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


<div id="modal_insereaza" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Insereaza CNP manual</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input id="manual_input" type="text" class="form-control" type="text" autocomplete="off"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <button id="btn_manual_input" class="btn btn-success pull-left">OK</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="btn_manual_close" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("input[name='user_id']:checkbox").prop('checked', false);
        $("#select_all").prop('checked', false);
        var ids;


        $('#btn_manual_input').click(function (e) {
            var manual_input = $('#manual_input').val();
            if (manual_input.length != 13 || !$.isNumeric(manual_input)) {
                alert('Format incorect, reincearca!');
            } else {
                $.ajax({
                    url: '//devlaboratory.digitaladvisors.ro/clients/24d58832a062cf808dcebc196b5b1b98/cnp_app/validatecnp.php',
                    data: {
                        action: 'validare_manual_input',
                        cnp: manual_input
                    },
                    type: 'post',
                    success: function (data) {
                        if (data == 1) {
                            $.ajax({
                                url: '//devlaboratory.digitaladvisors.ro/clients/24d58832a062cf808dcebc196b5b1b98/cnp_app/validatecnp.php',
                                data: {
                                    action: 'get_cnp_info',
                                    cnp: manual_input
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
                                            cnp: manual_input,
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
                        } else {
                            alert('CNP invalid!')
                        }
                    }
                });
            }
        });
        $('#btn_manual_close').click(function (e) {
            var manual_input = $('#manual_input').val('');
        });

        $('#btn_confirma_stergere').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: '//devlaboratory.digitaladvisors.ro/clients/24d58832a062cf808dcebc196b5b1b98/cnp_app/validatecnp.php',
                data: {
                    action: 'delete_users',
                    id_delete: ids
                },
                type: 'post',
                success: function (data) {
                    if (data > 0) {
                        $("#main_result").addClass("alert-success");
                        $('#main_result_text').text("Id-urile: " + ids + " au fost sterse!");
                        window.setTimeout(function () {
                            location.reload();
                        }, 3000);
                    } else {
                        alert(data);
                    }
                }
            });
        });

        $('#btn_renunta_stergere').click(function (e) {
            e.preventDefault();
            $("input[name='user_id']:checkbox").prop('checked', false);
            $("#select_all").prop('checked', false);
            location.reload();
        });

        $('#btn_Sterge').click(function () {
            ids = $('input[name=user_id]:checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (ids.length > 0) {
                $("#main_result").addClass("alert-warning");
                $('#main_result_text').text("Esti sigur ca vrei sa stergi userii cu id-urile: " + ids + "?");
                $('#grup_butoane_confirmare').removeClass('hidden');
            } else {
                alert("Nu ai selectat useri de sters");
            }
        });

        $('#select_all').click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
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
                $("#modal_insereaza").modal('show');
            } else {
                $.ajax({
                    url: '//devlaboratory.digitaladvisors.ro/clients/24d58832a062cf808dcebc196b5b1b98/cnp_app/validatecnp.php',
                    data: {
                        action: 'get_cnp_info',
                        cnp: cnp
                    },
                    type: 'post',
                    success: function (data) {
                        data = $.parseJSON(data); //Transformam obiectul JSON apelat de functie intr un array
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
    });
</script>

</body>
</html>

