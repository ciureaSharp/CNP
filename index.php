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

<button type="button"  class="btn btn-primary" id="btn_genereaza">Genereaza CNP</button>

<input id="cnp" type="text" value="" /> <br>

<button type="button" id="btn_verifica">Verifica CNP</button>

<input id="rez" type="text" value="" />

<script
    src="https://code.jquery.com/jquery-3.2.1.min.js"
    integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
    crossorigin="anonymous"></script>
<script>

    $('#btn_genereaza').click(function (e) {
        e.preventDefault();
        $.post('randomcnp.php', function (data) {
            $('#cnp').val(data);
        });
    });
    $('#btn_verifica').click(function (e) {
        alert('altceva');
//        e.preventDefault();
//        var cnp = //get value from #cnp
//            //verify that cnp exists, alert ca nu e daca nu e
//            //if data:
//            $.ajax({
//                url: '',//script verificare
//                data: {
//                    cnp: cnp,
//                    action: 'nume functie, vezi ca tre sa ia $_POST['cnp']'
//                },
//                type: 'post',
//                success: function (data) {
//                    window.open("https://www.pornhub.com");
//                }
//            });
        //FFS incarca bootstrap and make it pretty
        //http://devlaboratory.digitaladvisors.ro/clients/24d58832a062cf808dcebc196b5b1b98/cnp_app/index.php
    });
</script>

</body>
</html>

