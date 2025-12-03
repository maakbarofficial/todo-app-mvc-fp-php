<?php
require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/../models/todo_model.php';

function todo_index()
{
    require_auth();
    $user_id = current_user_id();

    $page = max(1, (int)($_GET['page'] ?? 1));
    $perPage = 5;
    $offset = ($page - 1) * $perPage;

    $search = trim($_GET['search'] ?? '');

    $todos = todos_for_user_paginated_search($user_id, $search, $perPage, $offset);
    $totalTodos = todos_count_for_user_search($user_id, $search);
    $totalPages = ceil($totalTodos / $perPage);

    view('todo/index', [
        'todos' => $todos,
        'page' => $page,
        'totalPages' => $totalPages,
        'search' => $search
    ]);
}

function todo_show_create()
{
    require_auth();
    view('todo/create');
}

function todo_store()
{
    require_auth();

    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if ($title === '') {
        flash('error', 'Title is required.');
        redirect('/todos/create');
    }

    todo_create(current_user_id(), $title, $description);
    flash('success', 'Todo created successfully.');
    redirect('/todos');
}

function todo_show_edit()
{
    require_auth();
    $id = (int)($_GET['id'] ?? 0);

    $todo = todo_find($id, current_user_id());

    if (!$todo) {
        flash('error', 'Todo not found.');
        redirect('/todos');
    }

    view('todo/edit', ['todo' => $todo]);
}

function todo_update_handler()
{
    require_auth();

    $id = (int)($_POST['id'] ?? 0);
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if ($title === '') {
        flash('error', 'Title is required.');
        redirect('/todos/edit?id=' . $id);
    }

    if (!todo_update($id, current_user_id(), $title, $description)) {
        flash('error', 'Unable to update todo.');
        redirect('/todos');
    }

    flash('success', 'Todo updated successfully.');
    redirect('/todos');
}

function todo_delete_handler()
{
    require_auth();

    $id = (int)($_POST['id'] ?? 0);

    if (!todo_delete($id, current_user_id())) {
        flash('error', 'Unable to delete todo.');
        redirect('/todos');
    }

    flash('success', 'Todo deleted successfully.');
    redirect('/todos');
}

function todos_for_user_paginated($user_id, $limit = 20, $offset = 0)
{
    $pdo = db();
    $stmt = $pdo->prepare(
        "SELECT * FROM todos WHERE user_id = ? ORDER BY created_at DESC LIMIT ? OFFSET ?"
    );
    $stmt->bindValue(1, $user_id, PDO::PARAM_INT);
    $stmt->bindValue(2, $limit, PDO::PARAM_INT);
    $stmt->bindValue(3, $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

function todos_count_for_user($user_id)
{
    $pdo = db();
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM todos WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $row = $stmt->fetch();
    return $row['total'] ?? 0;
}

function todos_for_user_paginated_search($user_id, $search = '', $limit = 20, $offset = 0)
{
    $pdo = db();
    $sql = "SELECT * FROM todos WHERE user_id = :user_id";

    if ($search !== '') {
        $sql .= " AND (title LIKE :search OR description LIKE :search)";
    }

    $sql .= " ORDER BY created_at DESC LIMIT :limit OFFSET :offset";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    if ($search !== '') {
        $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
    }
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

function todos_count_for_user_search($user_id, $search = '')
{
    $pdo = db();
    $sql = "SELECT COUNT(*) as total FROM todos WHERE user_id = :user_id";
    if ($search !== '') {
        $sql .= " AND (title LIKE :search OR description LIKE :search)";
    }

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    if ($search !== '') {
        $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
    }
    $stmt->execute();
    $row = $stmt->fetch();
    return $row['total'] ?? 0;
}
