<h1>Edit Todo</h1>

<form action="<?= e(base_url('/todos/update')) ?>" method="post" class="card">
    <input type="hidden" name="id" value="<?= e($todo['id']) ?>">

    <label>
        Title
        <input type="text" name="title" value="<?= e($todo['title']) ?>" required>
    </label>

    <label>
        Description
        <textarea name="description" rows="4"><?= e($todo['description']) ?></textarea>
    </label>

    <button type="submit" class="btn">Update</button>
    <a href="<?= e(base_url('/todos')) ?>" class="btn btn-link">Cancel</a>
</form>