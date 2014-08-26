<article class='linked_brainstorm'>
    <a href="<?= $controller->url_for('show/brainstorm/'.$brainstorm->id) ?>">
    <h1><?= htmlReady($brainstorm->title) ?></h1>
    </a>
    <div class="body">
        <?= formatReady($brainstorm->text) ?>
    </div>
</article>