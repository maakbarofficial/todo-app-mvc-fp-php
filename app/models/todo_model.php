<?php
require_once __DIR__ . '/../database.php';

function todos_for_user($user_id)
{
    $pdo = db();
    $stmt = $pdo->prepare("SELECT * FROM todos WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->execute([$user_id]);
    return $stmt->fetchAll();
}

function todo_find($id, $user_id)
{
    $pdo = db();
    $stmt = $pdo->prepare("SELECT * FROM todos WHERE id = ? AND user_id = ?");
    $stmt->execute([$id, $user_id]);
    return $stmt->fetch();
}

function todo_create($user_id, $title, $description)
{
    $pdo = db();
    $stmt = $pdo->prepare("INSERT INTO todos (user_id, title, description) VALUES (?, ?, ?)");
    $stmt->execute([$user_id, $title, $description]);
    return $pdo->lastInsertId();
}

function todo_update($id, $user_id, $title, $description)
{
    $pdo = db();
    $stmt = $pdo->prepare("UPDATE todos SET title = ?, description = ? WHERE id = ? AND user_id = ?");
    return $stmt->execute([$title, $description, $id, $user_id]);
}

function todo_delete($id, $user_id)
{
    $pdo = db();
    $stmt = $pdo->prepare("DELETE FROM todos WHERE id = ? AND user_id = ?");
    return $stmt->execute([$id, $user_id]);
}
