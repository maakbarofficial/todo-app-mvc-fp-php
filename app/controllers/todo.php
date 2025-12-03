<?php
require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/../models/todo_model.php';

function todo_index()
{
    require_auth();

    $todos = todos_for_user(current_user_id());

    view('todo/index', ['todos' => $todos]);
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