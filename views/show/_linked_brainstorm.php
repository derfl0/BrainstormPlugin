<a href="<?= $controller->url_for('show/brainstorm/' . $brainstorm->id) ?>">
    <article class='linked_brainstorm'>
        <div class="type">
            <?= $brainstorm->typename ?>
        </div>
        <h1><?= htmlReady($brainstorm->title) ?></h1>
        <div class="body">
            <?= formatReady($brainstorm->text) ?>
        </div>
    </article>
</a>