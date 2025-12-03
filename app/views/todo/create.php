<h1>Create Todo</h1>

<form action="<?= e(base_url('/todos/store')) ?>" method="post" class="card">
    <label>
        Title
        <input type="text" name="title" required>
    </label>

    <label>
        Description
        <textarea name="description" rows="4"></textarea>
    </label>

    <button type="submit" class="btn">Save</button>
    <a href="<?= e(base_url('/todos')) ?>" class="btn btn-link">Cancel</a>
</form>