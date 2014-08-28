<div class="brainstorm">
    <? foreach ($brainstorms as $brainstorm): ?>
        <?= $this->render_partial('show/_linked_brainstorm', array('brainstorm' => $brainstorm)) ?>
    <? endforeach; ?>
</div>
