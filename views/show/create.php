<form class="studip_form">

    <?= CSRFProtection::tokenTag() ?>
    
    <fieldset>
        <legend><?= _('Neuen Brainstorm anlegen') ?></legend>

        <label><?= _('Titel') ?>
            <input type="text" name="brainstorm[title]">
        </label>

        <label><?= _('Text') ?>
            <textarea name="brainstorm[text]"></textarea>
        </label>
        
        <?= \Studip\Button::create(_('Anlegen'), 'create') ?>
        
    </fieldset>

</form>