<div class='brainstorm'>
    <h1><?= htmlReady($brainstorm->title) ?></h1>
    <div class="body">
        <?= formatReady($brainstorm->text) ?>
    </div>
    <? if ($brainstorm->children): ?>
        <? foreach ($brainstorm->children->orderBy('power DESC', SORT_NUMERIC) as $child): ?>
            <? if ($brainstorm->type == 'sub'): ?>
                <?= $this->render_partial('show/_linked_brainstorm', array('brainstorm' => $child)) ?>
            <? else: ?>
                <?= $this->render_partial('show/_voteable_brainstorm', array('brainstorm' => $child)) ?>
            <? endif; ?>
        <? endforeach; ?>
    <? endif; ?>

    <? if ($brainstorm->type != 'sub'): ?>
        <form class='studip_form' method='post' action="<?= $controller->url_for('show/create/' . $brainstorm->id) ?>">
            <?= CSRFProtection::tokenTag() ?>
            <input type="hidden" name="brainstorm[type]" value="<?= $brainstorm->type ?>">
            <textarea type='text' name='brainstorm[text]' rows='0' cols='30' placeholder="Brainstorming ..."></textarea>
            <?= \Studip\Button::create(_('Absenden'), 'create') ?>
        </form>
    <? endif; ?>
</div>