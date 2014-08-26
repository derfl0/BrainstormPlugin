<article class='vote_brainstorm'>
    <nav>
        <form>
            <?= CSRFProtection::tokenTag() ?>
            <input type='hidden' name='brainstorm' value='<?= $brainstorm->id ?>'>
            <?= Assets::input('icons/16/'.($brainstorm->myvote->vote == 1 ? 'green' : 'blue').'/arr_1up.png', array('name' => 'vote[1][]')); ?>
            <?= Assets::input('icons/16/blue/remove.png', array('name' => 'vote[0][]')); ?>
            <?= Assets::input('icons/16/'.($brainstorm->myvote->vote == -1 ? 'red' : 'blue').'/arr_1down.png', array('name' => 'vote[-1][]')); ?>
        </form>
    </nav>
    <h1><?= htmlReady($brainstorm->title) ?></h1>
    <div class='power'>
        <?= $brainstorm->power ?>
    </div>
    <div class="body">
        <?= formatReady($brainstorm->text) ?>
    </div>
</article>