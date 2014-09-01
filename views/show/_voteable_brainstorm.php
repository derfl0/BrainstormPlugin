<article class='vote_brainstorm'>
    <section class="main">
        <nav>
            <form>
                <?= CSRFProtection::tokenTag() ?>
                <input type='hidden' name='brainstorm' value='<?= $brainstorm->id ?>'>
                <?= Assets::input('icons/16/' . ($brainstorm->myvote->vote == 1 ? 'green' : 'blue') . '/arr_1up.png', array('name' => 'vote[1][]')); ?>
                <?= Assets::input('icons/16/blue/remove.png', array('name' => 'vote[0][]')); ?>
                <?= Assets::input('icons/16/' . ($brainstorm->myvote->vote == -1 ? 'red' : 'blue') . '/arr_1down.png', array('name' => 'vote[-1][]')); ?>
            </form>
        </nav>
        <h1><?= htmlReady($brainstorm->title) ?></h1>
        <div class='power'>
            <?= $brainstorm->power ?>
        </div>
        <div class="body">
            <?= formatReady($brainstorm->text) ?>
        </div>
    </section>
    <? if ($brainstorm->type == 'commented'): ?>

        <footer>

            <? foreach ($brainstorm->children->orderBy('power DESC') as $child): ?>
                <?= $this->render_partial('show/_voteable_brainstorm', array('brainstorm' => $child)) ?>
            <? endforeach; ?>

            <label for="check_<?= $brainstorm->id ?>"><?= _('Kommentieren') ?></label>
            <input type="checkbox" id="check_<?= $brainstorm->id ?>">

            <form class='studip_form' method='post' action="<?= $controller->url_for('show/create/' . $brainstorm->id) ?>">
                <?= CSRFProtection::tokenTag() ?>
                <input type="hidden" name="brainstorm[type]" value="commented">
                <textarea name='brainstorm[text]' rows='0' cols='30' placeholder="Brainstorming ..."></textarea>
                <?= \Studip\Button::create(_('Absenden'), 'create') ?>
            </form>
        </footer>
    <? endif; ?>
</article>