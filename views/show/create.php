<form class="studip_form" method="post" action="<?= $controller->url_for('show/create') ?>">

    <?= CSRFProtection::tokenTag() ?>
    
    <input type="hidden" name="brainstorm[range_id]" value="<?= $range_id ?>">

    <label>
        <?= _('Titel') ?>
        <input type="text" name="brainstorm[title]">
    </label>

    <label>
        <?= _('Text') ?>
        <textarea name="brainstorm[text]"></textarea>
    </label>
    
    <label>
        <?= _('Brainstormtyp') ?>
        <select name="brainstorm[type]">
            <? foreach (Brainstorm::getTypes() as $type => $fullname): ?>
                <option value="<?= $type ?>"><?= $fullname ?></option>
            <? endforeach; ?>
        </select>
    </label>

    <?= \Studip\Button::create(_('Anlegen'), 'create') ?>

</form>