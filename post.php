<?php
/**
 * Created by PhpStorm.
 * User: Advisor2
 * Date: 20.04.2017
 * Time: 21:12
 */

?>
<button type="button" id="btn">Click Me!</button>

<script
    src="https://code.jquery.com/jquery-3.2.1.min.js"
    integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
    crossorigin="anonymous"></script>
<script>

    $('#btn').click(function (e) {
        e.preventDefault();
        var payload = 'payload';
        $.post('//devlaboratory.digitaladvisors.ro/clients/24d58832a062cf808dcebc196b5b1b98/cnp_app/git_pull.php', {
            payload: payload
        }, function (data) {
            alert(data);
        });
    });
</script>
