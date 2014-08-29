<div class='brainstorm'>
    <h1><?= htmlReady($brainstorm->title) ?></h1>
    <div class="body">
        <?= formatReady($brainstorm->text) ?>
    </div>

    <? foreach ($brainstorm->children->orderBy('power DESC') as $child): ?>
        <? if ($brainstorm->type == 'sub'): ?>
            <?= $this->render_partial('show/_linked_brainstorm', array('brainstorm' => $child)) ?>
        <? else: ?>
            <?= $this->render_partial('show/_voteable_brainstorm', array('brainstorm' => $child)) ?>
        <? endif; ?>
    <? endforeach; ?>

    <? if ($brainstorm->type != 'sub'): ?>
        <form class='studip_form' method='post'>
            <?= CSRFProtection::tokenTag() ?>
            <textarea type='text' name='answer' rows='0' cols='30' placeholder="Brainstorming ..."></textarea>
            <?= \Studip\Button::create(_('Absenden'), 'create') ?>
        </form>
    <? endif; ?>
</div>