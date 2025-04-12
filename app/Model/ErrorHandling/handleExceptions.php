<?php
namespace app\Model\ErrorHandling;

class handleExceptions {
    public function __construct($fn)
    {

        try {
            return $fn();
        } catch(\Exception $e) {
            $exploded = explode('#', $e->getTraceAsString());
            $imploded = implode('<br><br>#', $exploded);

            //echo debug_print_backtrace();

            echo "<h2><span class=\"errorShadow\">AN ERROR OCURRED!</span></h2>",
                 '<div class="z-depth-4 #ffebee red lighten-5 error-stack-alert" style="border: solid red 1px; padding: 25px;">',
                 "<i class=\"small material-icons\">error</i> This Exception was caught: {$imploded}",
                 '</div>';

            $errorClass = get_class($e);

            echo <<<TXT
            <ul class="collapsible">
            <li>
                <div class="collapsible-header">
                <i class="#f9fbe7 lime lighten-5 material-icons">code</i>
                <b>File:</b>&nbsp;{$e->getFile()}
                </div>
            </li>
            <li>
                <div class="collapsible-header">
                <i class="#ffcdd2 red lighten-4 material-icons">edit_note</i>
                <b>Line:</b>&nbsp;{$e->getLine()}
                </div>
            </li>
            <li>
                <div class="collapsible-header">
                <i class="#ffab91 deep-orange lighten-3 material-icons">speaker_notes</i>
                <b>Error Message</b>&nbsp;{$e->getMessage()}
            </li>
            <li>
                <div class="collapsible-header">
                <i class="#fff59d yellow lighten-3 material-icons">question_mark</i>
                <b>Classe do Erro:</b>&nbsp;{$errorClass}
            </li>
            <li>
                <div class="collapsible-header">
                <i class="material-icons">priority_high</i>
                <b>Error Code:</b>&nbsp;<span>{$e->getCode()}</span>
            </li>
            </ul>
TXT;

        } catch (\Throwable $t) {
            $exploded = explode('#', $t->getTraceAsString());
            $imploded = implode('<br><br>#', $exploded);

            echo "<h2><span class=\"errorShadow\">AN ERROR OCURRED!</span></h2>",
                 '<div class="z-depth-4 #ffebee red lighten-5 error-stack-alert" style="border: solid red 1px; padding: 25px;">',
                 "<i class=\"small material-icons\">error</i> This Error was caught: {$imploded}",
                 '</div>';

            $errorClass = get_class($t);

            echo <<<TXT
            <ul class="collapsible">
            <li>
                <div class="collapsible-header">
                <i class="#f9fbe7 lime lighten-5 material-icons">code</i>
                <b>File:</b>&nbsp;{$t->getFile()}
                </div>
            </li>
            <li>
                <div class="collapsible-header">
                <i class="#ffcdd2 red lighten-4 material-icons">edit_note</i>
                <b>Line:</b>&nbsp;{$t->getLine()}
                </div>
            </li>
            <li>
                <div class="collapsible-header">
                <i class="#ffab91 deep-orange lighten-3 material-icons">speaker_notes</i>
                <b>Error Message</b>&nbsp;{$t->getMessage()}
            </li>
            <li>
                <div class="collapsible-header">
                <i class="#fff59d yellow lighten-3 material-icons">question_mark</i>
                <b>Classe do Erro:</b>&nbsp;{$errorClass}
            </li>
            <li>
                <div class="collapsible-header">
                <i class="material-icons">priority_high</i>
                <b>Error Code:</b>&nbsp;<span>{$t->getCode()}</span>
            </li>
            </ul>
TXT;
        }
    }
}