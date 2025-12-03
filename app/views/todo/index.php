<div class="flex-between">
    <h1>Your Todos</h1>
    <form action="<?= e(base_url('/todos')) ?>" method="get" style="display:flex; gap:5px; align-items:center;">
        <input type="text" name="search" placeholder="Search todos..." value="<?= e($search ?? '') ?>">
        <button type="submit" class="btn btn-small">Search</button>
        <?php if (!empty($search)): ?>
            <a href="<?= e(base_url('/todos')) ?>" class="btn btn-small btn-secondary">Clear</a>
        <?php endif; ?>
    </form>
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

<?php if ($totalPages > 1): ?>
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="<?= e(base_url('/todos?page=' . ($page - 1))) ?>">&laquo; Previous</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="<?= e(base_url('/todos?page=' . $i)) ?>" class="<?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <a href="<?= e(base_url('/todos?page=' . ($page + 1))) ?>">Next &raquo;</a>
        <?php endif; ?>
    </div>
<?php endif; ?>