<?php

declare(strict_types=1);

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';

require_admin_login();

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    $action = $_POST['action'] ?? 'publish';

    if (!validate_csrf($token)) {
        $error = 'Token de seguranca invalido. Recarregue a pagina e tente novamente.';
    } elseif ($action === 'delete') {
        $artigoId = (int) ($_POST['artigo_id'] ?? 0);

        if ($artigoId <= 0) {
            $error = 'Artigo invalido para exclusao.';
        } else {
            $findStmt = $pdo->prepare('SELECT imagem_capa FROM artigos WHERE id = :id LIMIT 1');
            $findStmt->execute(['id' => $artigoId]);
            $artigo = $findStmt->fetch();

            if (!$artigo) {
                $error = 'Artigo nao encontrado.';
            } else {
                $deleteStmt = $pdo->prepare('DELETE FROM artigos WHERE id = :id');
                $deleteStmt->execute(['id' => $artigoId]);

                $imagePath = (string) ($artigo['imagem_capa'] ?? '');
                if ($imagePath !== '' && str_starts_with($imagePath, 'uploads/capas/')) {
                    $absoluteImagePath = __DIR__ . '/../' . $imagePath;
                    if (is_file($absoluteImagePath)) {
                        @unlink($absoluteImagePath);
                    }
                }

                $success = 'Artigo excluido com sucesso.';
            }
        }
    } elseif ($action === 'delete_selected') {
        $selectedIds = $_POST['artigo_ids'] ?? [];

        if (!is_array($selectedIds) || count($selectedIds) === 0) {
            $error = 'Selecione pelo menos um artigo para excluir.';
        } else {
            $validIds = [];
            foreach ($selectedIds as $selectedId) {
                $id = (int) $selectedId;
                if ($id > 0) {
                    $validIds[] = $id;
                }
            }

            $validIds = array_values(array_unique($validIds));

            if (count($validIds) === 0) {
                $error = 'Nenhum artigo valido foi selecionado.';
            } else {
                $placeholders = implode(',', array_fill(0, count($validIds), '?'));

                $findStmt = $pdo->prepare("SELECT imagem_capa FROM artigos WHERE id IN ($placeholders)");
                $findStmt->execute($validIds);
                $artigosSelecionados = $findStmt->fetchAll();

                $deleteStmt = $pdo->prepare("DELETE FROM artigos WHERE id IN ($placeholders)");
                $deleteStmt->execute($validIds);
                $deletedCount = (int) $deleteStmt->rowCount();

                foreach ($artigosSelecionados as $artigoSelecionado) {
                    $imagePath = (string) ($artigoSelecionado['imagem_capa'] ?? '');
                    if ($imagePath !== '' && str_starts_with($imagePath, 'uploads/capas/')) {
                        $absoluteImagePath = __DIR__ . '/../' . $imagePath;
                        if (is_file($absoluteImagePath)) {
                            @unlink($absoluteImagePath);
                        }
                    }
                }

                $success = $deletedCount === 1
                    ? '1 artigo excluido com sucesso.'
                    : $deletedCount . ' artigos excluidos com sucesso.';
            }
        }
    } else {
        $titulo = trim($_POST['titulo'] ?? '');
        $categoria = trim($_POST['categoria'] ?? '');
        $dataPublicacao = $_POST['data_publicacao'] ?? '';
        $conteudo = trim($_POST['conteudo'] ?? '');

        if ($titulo === '' || $categoria === '' || $dataPublicacao === '' || $conteudo === '') {
            $error = 'Preencha todos os campos obrigatorios.';
        } elseif (empty($_FILES['capa']['name']) || ($_FILES['capa']['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            $error = 'Selecione uma imagem de capa valida.';
        } else {
            $allowedMime = [
                'image/jpeg' => 'jpg',
                'image/png' => 'png',
                'image/webp' => 'webp',
            ];

            $tmpPath = $_FILES['capa']['tmp_name'];
            $mime = '';

            if (class_exists('finfo')) {
                $fileInfo = new finfo(FILEINFO_MIME_TYPE);
                $mime = $fileInfo->file($tmpPath) ?: '';
            }

            if ($mime === '' && function_exists('mime_content_type')) {
                $mime = mime_content_type($tmpPath) ?: '';
            }

            if ($mime === '') {
                $imageInfo = @getimagesize($tmpPath);
                if (is_array($imageInfo) && !empty($imageInfo['mime'])) {
                    $mime = (string) $imageInfo['mime'];
                }
            }

            if (!isset($allowedMime[$mime])) {
                $error = 'Formato de imagem nao suportado. Use JPG, PNG ou WEBP.';
            } else {
                $extension = $allowedMime[$mime];
                $safeFileName = bin2hex(random_bytes(16)) . '.' . $extension;
                $uploadDir = __DIR__ . '/../uploads/capas/';
                $relativePath = 'uploads/capas/' . $safeFileName;
                $targetPath = $uploadDir . $safeFileName;

                if (!move_uploaded_file($tmpPath, $targetPath)) {
                    $error = 'Falha ao salvar a imagem de capa. Verifique as permissoes da pasta uploads/capas.';
                } else {
                    $stmt = $pdo->prepare(
                        'INSERT INTO artigos (titulo, categoria, data_publicacao, imagem_capa, conteudo, admin_id)
                         VALUES (:titulo, :categoria, :data_publicacao, :imagem_capa, :conteudo, :admin_id)'
                    );

                    $stmt->execute([
                        'titulo' => $titulo,
                        'categoria' => $categoria,
                        'data_publicacao' => $dataPublicacao,
                        'imagem_capa' => $relativePath,
                        'conteudo' => $conteudo,
                        'admin_id' => $_SESSION['admin_id'],
                    ]);

                    $success = 'Artigo publicado com sucesso e ja disponivel na pagina principal.';
                }
            }
        }
    }
}

$artigos = $pdo->query(
    'SELECT a.id, a.titulo, a.categoria, a.data_publicacao, a.imagem_capa, a.created_at, ad.nome AS autor
     FROM artigos a
     INNER JOIN admins ad ON ad.id = a.admin_id
     ORDER BY a.data_publicacao DESC, a.id DESC'
)->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Painel de Artigos</title>
<link rel="stylesheet" href="/style.css">
</head>
<body class="admin-page">
<header class="admin-topbar">
    <div class="container admin-topbar-inner">
        <div>
            <strong>Painel de Artigos</strong>
            <span>Ola, <?= htmlspecialchars((string) ($_SESSION['admin_name'] ?? 'Admin'), ENT_QUOTES, 'UTF-8') ?></span>
        </div>
        <div class="admin-actions">
            <a href="../index.php" target="_blank" rel="noopener">Ver site</a>
            <a href="logout.php" class="admin-logout">Sair</a>
        </div>
    </div>
</header>

<main class="container admin-grid">
    <section class="admin-card">
        <h1>Novo artigo</h1>
        <p>Preencha os campos abaixo e clique em Publicar.</p>

        <?php if ($success !== ''): ?>
            <div class="admin-alert admin-alert-success"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>

        <?php if ($error !== ''): ?>
            <div class="admin-alert admin-alert-error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>

        <form class="admin-form" method="post" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') ?>">
            <input type="hidden" name="action" value="publish">

            <label for="titulo">Titulo</label>
            <input id="titulo" name="titulo" type="text" required>

            <label for="categoria">Categoria</label>
            <input id="categoria" name="categoria" type="text" required>

            <label for="data_publicacao">Data</label>
            <input id="data_publicacao" name="data_publicacao" type="date" required>

            <label for="capa">Imagem de capa</label>
            <input id="capa" name="capa" type="file" accept="image/jpeg,image/png,image/webp" required>

            <label for="conteudo">Conteudo do artigo</label>
            <textarea id="conteudo" name="conteudo" placeholder="Escreva o artigo aqui..." required></textarea>

            <button type="submit">Publicar artigo</button>
        </form>
    </section>

    <section class="admin-card">
        <h2>Artigos publicados</h2>
        <?php if (count($artigos) === 0): ?>
            <p>Nenhum artigo publicado ainda.</p>
        <?php else: ?>
            <form id="bulk-delete-form" method="post" class="admin-bulk-actions" onsubmit="return confirm('Tem certeza que deseja excluir os artigos selecionados?');">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') ?>">
                <input type="hidden" name="action" value="delete_selected">
                <button type="submit" class="admin-delete-btn admin-delete-bulk-btn">Excluir selecionados</button>
            </form>

            <div class="admin-list">
                <?php foreach ($artigos as $artigo): ?>
                    <article>
                        <label class="admin-select-row">
                            <input
                                type="checkbox"
                                name="artigo_ids[]"
                                value="<?= (int) $artigo['id'] ?>"
                                form="bulk-delete-form"
                            >
                            Selecionar para exclusao em lote
                        </label>
                        <h3><?= htmlspecialchars($artigo['titulo'], ENT_QUOTES, 'UTF-8') ?></h3>
                        <p>
                            <?= htmlspecialchars($artigo['categoria'], ENT_QUOTES, 'UTF-8') ?> |
                            <?= date('d/m/Y', strtotime((string) $artigo['data_publicacao'])) ?> |
                            por <?= htmlspecialchars($artigo['autor'], ENT_QUOTES, 'UTF-8') ?>
                        </p>
                        <form method="post" onsubmit="return confirm('Tem certeza que deseja excluir este artigo?');">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') ?>">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="artigo_id" value="<?= (int) $artigo['id'] ?>">
                            <button type="submit" class="admin-delete-btn">Excluir artigo</button>
                        </form>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
</main>
</body>
</html>
