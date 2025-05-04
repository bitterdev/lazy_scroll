<?php

defined('C5_EXECUTE') or die('Access denied');

use Concrete\Core\Form\Service\Form;
use Concrete\Core\Form\Service\Widget\PageSelector;
use Concrete\Core\Support\Facade\Application;
use Concrete\Core\Validation\CSRF\Token;
use Concrete\Core\View\View;

/** @var int $scrollDuration */

$app = Application::getFacadeApplication();
/** @var Form $form */
/** @noinspection PhpUnhandledExceptionInspection */
$form = $app->make(Form::class);
/** @var Token $token */
/** @noinspection PhpUnhandledExceptionInspection */
$token = $app->make(Token::class);

?>

<div class="ccm-dashboard-header-buttons">
    <?php /** @noinspection PhpUnhandledExceptionInspection */
    View::element("dashboard/help", [], "lazy_scroll"); ?>
</div>

<?php \Concrete\Core\View\View::element("dashboard/did_you_know", [], "lazy_scroll"); ?>

<form action="#" method="post">
    <?php echo $token->output("update_settings"); ?>

    <fieldset>
        <legend>
            <?php echo t("General"); ?>
        </legend>

        <div class="form-group">
            <?php echo $form->label("scrollDuration", t("Scroll Duration")); ?>

            <div class="input-group">
                <?php echo $form->number("scrollDuration", $scrollDuration, ["min" => 0, "step" => 1, "max" => 30000]); ?>

                <div class="input-group-text">
                    <?php echo t("ms"); ?>
                </div>
            </div>
        </div>
    </fieldset>

    <div class="ccm-dashboard-form-actions-wrapper">
        <div class="ccm-dashboard-form-actions">
            <?php echo $form->submit('save', t('Save'), ['class' => 'btn btn-primary float-end']); ?>
        </div>
    </div>
</form>
