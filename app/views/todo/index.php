<div class="flex-between">
    <h1>Your Todos</h1>
    <a href="<?= e(base_url('/todos/create')) ?>" class="btn">+ New Todo</a>
</div>

<?php if (empty($todos)): ?>
    <p>No todos yet. Create one!</p>
<?php else: ?>
    <ul class="todo-list">
        <?php foreach ($todos as $todo): ?>
            <li class="todo-item">
                <div>
                    <strong><?= e($todo['title']) ?></strong><br>
                    <small><?= nl2br(e($todo['description'])) ?></small>
                </div>
                <div class="todo-actions">
                    <a href="<?= e(base_url('/todos/edit?id=' . $todo['id'])) ?>" class="btn btn-small">Edit</a>
                    <form action="<?= e(base_url('/todos/delete')) ?>" method="post" onsubmit="return confirm('Delete this todo?');">
                        <input type="hidden" name="id" value="<?= e($todo['id']) ?>">
                        <button type="submit" class="btn btn-small btn-danger">Delete</button>
                    </form>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>