<?php

function handleErrors(
    int $errno,
    string $errstr,
    string $errfile,
    int $errline,
) {
    echo "",
            '<div class="z-depth-4 #ffebee red lighten-5 error-stack-alert" style="border: solid red 1px; padding: 25px;">',
            "<i class=\"small material-icons\">error</i> This Error was caught: {$errstr}",
            '</div>';
}
?>
<style>
    body {
        margin-top: 0;
        margin-left: 25px;
        margin-right: 25px;
        margin-bottom: 25px;
        background: url(http://localhost:9093/background-colored2.jpg) #99f no-repeat fixed;
    }

    .error-stack-alert {
        text-shadow: -1px -1px red;
    }

    .errorShadow {
        text-shadow: -1px 2px red;
        opacity: 0.7;
    }
</style>