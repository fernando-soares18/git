<?php
declare(strict_types=1);

// ⚠️ Proteção: NÃO incluir db.php para não tentar conectar ao banco
// Este painel usa JSON, não precisa de MySQL!

session_start();

// Carregar credenciais
require_once __DIR__ . '/credenciais.php';
$credenciais_file = __DIR__ . '/credenciais.php';

// --- LOGOUT ---
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: painel.php');
    exit;
}

// --- PROCESSAR LOGIN ---
$erro_login = '';
if (!isset($_SESSION['painel_logado'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'login') {
        $usuario = trim($_POST['usuario'] ?? '');
        $senha = $_POST['senha'] ?? '';
        if ($usuario === PAINEL_USUARIO && password_verify($senha, PAINEL_SENHA_HASH)) {
            $_SESSION['painel_logado'] = true;
        } else {
            $erro_login = 'Usuário ou senha incorretos.';
        }
    }
    if (!isset($_SESSION['painel_logado'])) {
        // Mostrar tela de login
        ?><!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - Painel de Artigos</title>
<style>
  body { font-family: 'Poppins', sans-serif; background: #eaf7f3; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; }
  .login-box { background: #fff; padding: 40px; border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,0.10); width: 100%; max-width: 380px; }
  h1 { color: #1f6b75; font-size: 1.5rem; margin-bottom: 8px; }
  p { color: #5f6f6a; margin-bottom: 24px; font-size: 0.9rem; }
  label { display: block; font-weight: 600; color: #27433c; margin-bottom: 6px; font-size: 0.9rem; }
  input[type=text], input[type=password] { width: 100%; padding: 12px 14px; border: 2px solid #d0e8e4; border-radius: 8px; font-size: 1rem; box-sizing: border-box; margin-bottom: 16px; }
  input:focus { border-color: #2c8b80; outline: none; }
  button { width: 100%; padding: 14px; background: #1f6b75; color: #fff; border: none; border-radius: 8px; font-size: 1rem; font-weight: 600; cursor: pointer; }
  button:hover { background: #2c8b80; }
  .erro { background: #ffe0e0; color: #c00; padding: 10px 14px; border-radius: 8px; margin-bottom: 16px; font-size: 0.9rem; }
</style>
</head>
<body>
<div class="login-box">
  <h1>🔐 Painel de Artigos</h1>
  <p>Entre com suas credenciais para gerenciar os artigos.</p>
  <?php if ($erro_login): ?><div class="erro">⚠️ <?= htmlspecialchars($erro_login) ?></div><?php endif; ?>
  <form method="post">
    <input type="hidden" name="acao" value="login">
    <label for="usuario">Usuário</label>
    <input type="text" id="usuario" name="usuario" required autocomplete="username">
    <label for="senha">Senha</label>
    <input type="password" id="senha" name="senha" required autocomplete="current-password">
    <button type="submit">Entrar</button>
  </form>
</div>
</body>
</html><?php
        exit;
    }
}

// --- PROCESSAR TROCA DE SENHA ---
$mensagem_senha = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'trocar_senha') {
    $novo_usuario = trim($_POST['novo_usuario'] ?? '');
    $nova_senha = $_POST['nova_senha'] ?? '';
    $confirmar = $_POST['confirmar_senha'] ?? '';
    $senha_atual = $_POST['senha_atual'] ?? '';

    if (!password_verify($senha_atual, PAINEL_SENHA_HASH)) {
        $mensagem_senha = ['tipo' => 'erro', 'texto' => 'Senha atual incorreta.'];
    } elseif (strlen($novo_usuario) < 3) {
        $mensagem_senha = ['tipo' => 'erro', 'texto' => 'Usuário deve ter pelo menos 3 caracteres.'];
    } elseif (strlen($nova_senha) < 6) {
        $mensagem_senha = ['tipo' => 'erro', 'texto' => 'Nova senha deve ter pelo menos 6 caracteres.'];
    } elseif ($nova_senha !== $confirmar) {
        $mensagem_senha = ['tipo' => 'erro', 'texto' => 'As senhas não coincidem.'];
    } else {
        $novo_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
        $novo_conteudo = "<?php\ndefine('PAINEL_USUARIO', " . var_export($novo_usuario, true) . ");\ndefine('PAINEL_SENHA_HASH', " . var_export($novo_hash, true) . ");\n";
        if (file_put_contents($credenciais_file, $novo_conteudo)) {
            $mensagem_senha = ['tipo' => 'sucesso', 'texto' => 'Credenciais atualizadas com sucesso! Use as novas credenciais no próximo login.'];
        } else {
            $mensagem_senha = ['tipo' => 'erro', 'texto' => 'Erro ao salvar. Verifique as permissões do arquivo.'];
        }
    }
}

// Caminho do arquivo JSON de artigos
$artigos_file = __DIR__ . '/artigos.json';
$ebooks_file = __DIR__ . '/ebooks.json';

// Função para carregar artigos
function carregar_artigos(string $file): array {
    if (!file_exists($file)) {
        return [];
    }
    $json = file_get_contents($file);
    $json = preg_replace('/^\xEF\xBB\xBF/', '', (string) $json);
    return json_decode($json, true) ?? [];
}

// Função para salvar artigos
function salvar_artigos(string $file, array $artigos): bool {
    $json = json_encode($artigos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    return file_put_contents($file, $json) !== false;
}

function carregar_ebooks(string $file): array {
    if (!file_exists($file)) {
        return [];
    }

    $json = file_get_contents($file);
    $json = preg_replace('/^\xEF\xBB\xBF/', '', (string) $json);
    $ebooks = json_decode($json, true);

    return is_array($ebooks) ? $ebooks : [];
}

function salvar_ebooks(string $file, array $ebooks): bool {
    $json = json_encode(array_values($ebooks), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    return file_put_contents($file, $json) !== false;
}

// Carregar artigos
$artigos = carregar_artigos($artigos_file);
$ebooks = carregar_ebooks($ebooks_file);

// Processar formulário de edição
$mensagem = '';
$tipo_mensagem = '';
$artigo_editando = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['acao'])) {
        if ($_POST['acao'] === 'editar' && isset($_POST['id'])) {
            // Buscar artigo para editar
            $id = $_POST['id'];
            foreach ($artigos as $art) {
                if ($art['id'] === $id) {
                    $artigo_editando = $art;
                    break;
                }
            }
        } elseif ($_POST['acao'] === 'salvar' && isset($_POST['id'])) {
            // Salvar artigo
            $id = $_POST['id'];
            $titulo = trim($_POST['titulo'] ?? '');
            $categoria = trim($_POST['categoria'] ?? '');
            $data = trim($_POST['data_publicacao'] ?? '');
            $imagem = trim($_POST['imagem_capa'] ?? '');
            $conteudo = $_POST['conteudo'] ?? '';
            $autor = trim($_POST['autor'] ?? '');

            if ($titulo && $categoria && $data && $imagem && $conteudo && $autor) {
                $artigo_atualizado = false;
                foreach ($artigos as &$art) {
                    if ($art['id'] === $id) {
                        $art['titulo'] = $titulo;
                        $art['categoria'] = $categoria;
                        $art['data_publicacao'] = $data;
                        $art['imagem_capa'] = $imagem;
                        $art['conteudo'] = $conteudo;
                        $art['autor'] = $autor;
                        $artigo_atualizado = true;
                        break;
                    }
                }

                if ($artigo_atualizado && salvar_artigos($artigos_file, $artigos)) {
                    $mensagem = "✅ Artigo '{$titulo}' salvo com sucesso!";
                    $tipo_mensagem = 'sucesso';
                    // Recarregar artigos
                    $artigos = carregar_artigos($artigos_file);
                } else {
                    $mensagem = "❌ Erro ao salvar artigo. Verifique permissões de arquivo.";
                    $tipo_mensagem = 'erro';
                }
            } else {
                $mensagem = "⚠️ Todos os campos são obrigatórios!";
                $tipo_mensagem = 'aviso';
            }
        } elseif ($_POST['acao'] === 'adicionar_ebook') {
            $titulo_ebook = trim($_POST['titulo_ebook'] ?? '');
            $descricao_ebook = trim($_POST['descricao_ebook'] ?? '');
            $link_ebook = trim($_POST['link_ebook'] ?? '');

            if ($titulo_ebook === '' || $descricao_ebook === '' || $link_ebook === '') {
                $mensagem = '⚠️ Preencha todos os campos do eBook.';
                $tipo_mensagem = 'aviso';
            } elseif (!filter_var($link_ebook, FILTER_VALIDATE_URL)) {
                $mensagem = '⚠️ Informe uma URL válida para o eBook.';
                $tipo_mensagem = 'aviso';
            } else {
                $ebooks[] = [
                    'id' => uniqid('ebook-', true),
                    'titulo' => $titulo_ebook,
                    'descricao' => $descricao_ebook,
                    'link' => $link_ebook,
                ];

                if (salvar_ebooks($ebooks_file, $ebooks)) {
                    $mensagem = "✅ eBook '{$titulo_ebook}' adicionado com sucesso!";
                    $tipo_mensagem = 'sucesso';
                    $ebooks = carregar_ebooks($ebooks_file);
                } else {
                    $mensagem = '❌ Erro ao salvar o eBook. Verifique permissões de arquivo.';
                    $tipo_mensagem = 'erro';
                }
            }
        } elseif ($_POST['acao'] === 'excluir_ebook' && isset($_POST['id_ebook'])) {
            $id_ebook = (string) $_POST['id_ebook'];
            $titulo_removido = '';

            $ebooks = array_values(array_filter($ebooks, function (array $ebook) use ($id_ebook, &$titulo_removido): bool {
                $atual_id = (string) ($ebook['id'] ?? '');
                if ($atual_id === $id_ebook) {
                    $titulo_removido = (string) ($ebook['titulo'] ?? '');
                    return false;
                }
                return true;
            }));

            if (salvar_ebooks($ebooks_file, $ebooks)) {
                $mensagem = $titulo_removido !== ''
                    ? "✅ eBook '{$titulo_removido}' excluído com sucesso!"
                    : '✅ eBook removido com sucesso!';
                $tipo_mensagem = 'sucesso';
                $ebooks = carregar_ebooks($ebooks_file);
            } else {
                $mensagem = '❌ Erro ao excluir o eBook. Verifique permissões de arquivo.';
                $tipo_mensagem = 'erro';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Artigos - Dr. Charles Genehr</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --green-dark: #1f6b75;
            --green-soft: #eaf7f3;
            --green-strong: #2c8b80;
            --cream: #f8fdfa;
            --text: #27433c;
            --muted: #5f6f6a;
            --white: #ffffff;
            --bg: #f0f5f4;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            background: var(--green-dark);
            color: var(--white);
            padding: 30px 0;
            box-shadow: 0 2px 10px rgba(31, 107, 117, 0.1);
        }

        header h1 {
            margin-bottom: 5px;
            font-size: 1.8rem;
        }

        header p {
            opacity: 0.9;
            font-size: 0.95rem;
        }

        .voltar {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background: var(--white);
            color: var(--green-dark);
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .voltar:hover {
            transform: translateX(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .mensagem {
            margin: 20px 0;
            padding: 15px 20px;
            border-radius: 8px;
            font-weight: 500;
            border-left: 5px solid;
        }

        .mensagem.sucesso {
            background: #d4edda;
            color: #155724;
            border-left-color: #28a745;
        }

        .mensagem.erro {
            background: #f8d7da;
            color: #721c24;
            border-left-color: #f5c6cb;
        }

        .mensagem.aviso {
            background: #fff3cd;
            color: #856404;
            border-left-color: #ffc107;
        }

        .grid-artigos {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }

        .grid-ebooks {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            margin: 24px 0 0;
        }

        .card-ebook {
            background: var(--white);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(31, 107, 117, 0.08);
            border: 1px solid var(--green-soft);
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .card-ebook h3 {
            color: var(--green-dark);
            font-size: 1.05rem;
            line-height: 1.4;
        }

        .card-ebook p {
            color: var(--muted);
            font-size: 0.9rem;
        }

        .card-ebook a {
            color: var(--green-dark);
            font-weight: 600;
            text-decoration: none;
            word-break: break-word;
        }

        .card-artigo {
            background: var(--white);
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(31, 107, 117, 0.08);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .card-artigo:hover {
            box-shadow: 0 8px 25px rgba(31, 107, 117, 0.15);
            transform: translateY(-5px);
        }

        .card-artigo .categoria {
            display: inline-block;
            background: var(--green-soft);
            color: var(--green-dark);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 12px;
            width: fit-content;
        }

        .card-artigo h3 {
            color: var(--green-dark);
            margin-bottom: 10px;
            font-size: 1.1rem;
            line-height: 1.4;
        }

        .card-artigo .info {
            font-size: 0.85rem;
            color: var(--muted);
            margin-bottom: 15px;
            border-bottom: 1px solid var(--green-soft);
            padding-bottom: 12px;
        }

        .card-artigo .info span {
            display: block;
            margin-bottom: 4px;
        }

        .botoes {
            display: flex;
            gap: 10px;
            margin-top: auto;
        }

        .btn {
            flex: 1;
            padding: 10px 15px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
        }

        .btn-editar {
            background: var(--green-dark);
            color: var(--white);
        }

        .btn-editar:hover {
            background: var(--green-strong);
            transform: translateY(-2px);
        }

        .formulario {
            background: var(--white);
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(31, 107, 117, 0.08);
            margin: 30px 0;
        }

        .formulario h2 {
            color: var(--green-dark);
            margin-bottom: 25px;
        }

        .form-grupo {
            margin-bottom: 20px;
        }

        .form-grupo label {
            display: block;
            margin-bottom: 8px;
            color: var(--text);
            font-weight: 600;
        }

        .form-grupo input,
        .form-grupo textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid var(--green-soft);
            border-radius: 6px;
            font-family: 'Poppins', sans-serif;
            color: var(--text);
            transition: all 0.3s ease;
        }

        .form-grupo input:focus,
        .form-grupo textarea:focus {
            outline: none;
            border-color: var(--green-dark);
            background: var(--cream);
        }

        .form-grupo textarea {
            min-height: 400px;
            resize: vertical;
            font-size: 0.95rem;
        }

        .form-grupo-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .botoes-formulario {
            display: flex;
            gap: 12px;
            margin-top: 30px;
        }

        .btn-salvar {
            flex: 1;
            padding: 14px;
            background: var(--green-strong);
            color: var(--white);
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
        }

        .btn-salvar:hover {
            background: var(--green-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(31, 107, 117, 0.2);
        }

        .btn-cancelar {
            flex: 1;
            padding: 14px;
            background: var(--muted);
            color: var(--white);
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
        }

        .btn-cancelar:hover {
            background: #4a5a57;
        }

        .hint {
            font-size: 0.85rem;
            color: var(--muted);
            margin-top: 6px;
        }

        @media (max-width: 768px) {
            .grid-artigos {
                grid-template-columns: 1fr;
            }

            .form-grupo-row {
                grid-template-columns: 1fr;
            }

            .botoes-formulario {
                flex-direction: column;
            }

            header h1 {
                font-size: 1.4rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>📝 Painel de Artigos</h1>
            <p>Gerencie todos os artigos do blog facilmente</p>
            <div style="display:flex; gap:12px; flex-wrap:wrap; margin-top:12px;">
                <a href="/" class="voltar">← Voltar ao Site</a>
                <a href="?acao=trocar_senha" class="voltar" style="background:#2c8b80;">🔑 Alterar Senha</a>
                <a href="?logout=1" class="voltar" style="background:#c0392b;">🚪 Sair</a>
            </div>
        </div>
    </header>

    <div class="container">
        <?php if (isset($_GET['acao']) && $_GET['acao'] === 'trocar_senha'): ?>
        <!-- FORMULÁRIO DE TROCA DE SENHA -->
        <div class="formulario" style="max-width:500px; margin:0 auto;">
            <h2>🔑 Alterar Usuário e Senha</h2>
            <?php if ($mensagem_senha): ?>
                <div class="mensagem <?= $mensagem_senha['tipo'] ?>"><?= htmlspecialchars($mensagem_senha['texto']) ?></div>
            <?php endif; ?>
            <form method="POST">
                <input type="hidden" name="acao" value="trocar_senha">
                <div class="form-grupo">
                    <label>🔒 Senha Atual</label>
                    <input type="password" name="senha_atual" required>
                </div>
                <div class="form-grupo">
                    <label>👤 Novo Usuário</label>
                    <input type="text" name="novo_usuario" value="<?= htmlspecialchars(PAINEL_USUARIO) ?>" required minlength="3">
                </div>
                <div class="form-grupo">
                    <label>🔑 Nova Senha (mínimo 6 caracteres)</label>
                    <input type="password" name="nova_senha" required minlength="6">
                </div>
                <div class="form-grupo">
                    <label>🔑 Confirmar Nova Senha</label>
                    <input type="password" name="confirmar_senha" required minlength="6">
                </div>
                <div class="botoes">
                    <button type="submit" class="btn-salvar">💾 Salvar Credenciais</button>
                    <a href="painel.php" class="btn-cancelar">❌ Cancelar</a>
                </div>
            </form>
        </div>
        <?php endif; // fim do if trocar_senha

        if (!(isset($_GET['acao']) && $_GET['acao'] === 'trocar_senha')): ?>

        <?php if ($mensagem): ?>
            <div class="mensagem <?= $tipo_mensagem ?>">
                <?= htmlspecialchars($mensagem) ?>
            </div>
        <?php endif; ?>

        <?php if ($artigo_editando): ?>
            <!-- FORMULÁRIO DE EDIÇÃO -->
            <div class="formulario">
                <h2>✏️ Editando: <?= htmlspecialchars($artigo_editando['titulo']) ?></h2>
                
                <form method="POST">
                    <input type="hidden" name="acao" value="salvar">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($artigo_editando['id']) ?>">

                    <div class="form-grupo">
                        <label for="titulo">📌 Título do Artigo</label>
                        <input type="text" id="titulo" name="titulo" value="<?= htmlspecialchars($artigo_editando['titulo']) ?>" required>
                        <div class="hint">Título principal que aparecerá na página</div>
                    </div>

                    <div class="form-grupo-row">
                        <div class="form-grupo">
                            <label for="categoria">🏷️ Categoria</label>
                            <input type="text" id="categoria" name="categoria" value="<?= htmlspecialchars($artigo_editando['categoria']) ?>" required>
                            <div class="hint">Ex: Comida 10, Mente 10, etc</div>
                        </div>

                        <div class="form-grupo">
                            <label for="data_publicacao">📅 Data de Publicação</label>
                            <input type="date" id="data_publicacao" name="data_publicacao" value="<?= htmlspecialchars($artigo_editando['data_publicacao']) ?>" required>
                        </div>
                    </div>

                    <div class="form-grupo">
                        <label for="imagem_capa">🖼️ URL da Imagem de Capa</label>
                        <input type="url" id="imagem_capa" name="imagem_capa" value="<?= htmlspecialchars($artigo_editando['imagem_capa']) ?>" required>
                        <div class="hint">Recomenda-se usar Unsplash (https://images.unsplash.com/...)</div>
                    </div>

                    <div class="form-grupo">
                        <label for="conteudo">📝 Conteúdo do Artigo (HTML)</label>
                        <textarea id="conteudo" name="conteudo" required><?= htmlspecialchars($artigo_editando['conteudo']) ?></textarea>
                        <div class="hint">Você pode usar HTML: &lt;h2&gt;, &lt;h3&gt;, &lt;p&gt;, &lt;ul&gt;, &lt;li&gt;, &lt;strong&gt;, etc</div>
                    </div>

                    <div class="form-grupo">
                        <label for="autor">✍️ Autor</label>
                        <input type="text" id="autor" name="autor" value="<?= htmlspecialchars($artigo_editando['autor']) ?>" required>
                        <div class="hint">Nome do autor do artigo</div>
                    </div>

                    <div class="botoes-formulario">
                        <button type="submit" class="btn-salvar">💾 Salvar Artigo</button>
                        <button type="button" class="btn-cancelar" onclick="location.reload()">❌ Cancelar</button>
                    </div>
                </form>
            </div>

        <?php else: ?>
            <!-- LISTAGEM DE ARTIGOS -->
            <div style="margin-bottom: 20px;">
                <h2 style="color: var(--green-dark); margin-bottom: 10px;">📚 Artigos Disponíveis</h2>
                <p style="color: var(--muted);">Clique no botão "Editar" para modificar qualquer artigo</p>
            </div>

            <div class="grid-artigos">
                <?php foreach ($artigos as $artigo): ?>
                    <div class="card-artigo">
                        <span class="categoria"><?= htmlspecialchars($artigo['categoria']) ?></span>
                        <h3><?= htmlspecialchars($artigo['titulo']) ?></h3>
                        
                        <div class="info">
                            <span><strong>📅 Data:</strong> <?= date('d/m/Y', strtotime($artigo['data_publicacao'])) ?></span>
                            <span><strong>✍️ Autor:</strong> <?= htmlspecialchars($artigo['autor']) ?></span>
                            <span><strong>🔗 ID:</strong> <?= htmlspecialchars($artigo['id']) ?></span>
                        </div>

                        <div class="botoes">
                            <form method="POST" style="flex: 1;">
                                <input type="hidden" name="acao" value="editar">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($artigo['id']) ?>">
                                <button type="submit" class="btn btn-editar">✏️ Editar</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if (empty($artigos)): ?>
                <div style="text-align: center; padding: 40px; background: var(--cream); border-radius: 12px; color: var(--muted);">
                    <p style="font-size: 1.1rem;">😕 Nenhum artigo encontrado</p>
                    <p>Verifique se o arquivo artigos.json existe em admin/</p>
                </div>
            <?php endif; ?>

            <div class="formulario" style="margin-top: 36px;">
                <h2>📘 Gerenciar eBooks</h2>
                <p style="color: var(--muted); margin-bottom: 16px;">Adicione e exclua eBooks quando quiser. As mudanças aparecem automaticamente no site.</p>

                <form method="POST">
                    <input type="hidden" name="acao" value="adicionar_ebook">

                    <div class="form-grupo">
                        <label for="titulo_ebook">📌 Título do eBook</label>
                        <input type="text" id="titulo_ebook" name="titulo_ebook" required>
                    </div>

                    <div class="form-grupo">
                        <label for="descricao_ebook">📝 Descrição</label>
                        <textarea id="descricao_ebook" name="descricao_ebook" required style="min-height: 120px;"></textarea>
                    </div>

                    <div class="form-grupo">
                        <label for="link_ebook">🔗 Link do eBook</label>
                        <input type="url" id="link_ebook" name="link_ebook" required placeholder="https://...">
                    </div>

                    <button type="submit" class="btn-salvar">➕ Adicionar eBook</button>
                </form>

                <div class="grid-ebooks">
                    <?php foreach ($ebooks as $ebook): ?>
                        <div class="card-ebook">
                            <h3><?= htmlspecialchars((string) ($ebook['titulo'] ?? 'eBook')) ?></h3>
                            <p><?= htmlspecialchars((string) ($ebook['descricao'] ?? '')) ?></p>
                            <a href="<?= htmlspecialchars((string) ($ebook['link'] ?? '#')) ?>" target="_blank" rel="noopener">Abrir link</a>

                            <form method="POST" onsubmit="return confirm('Deseja excluir este eBook?');" style="margin-top: 8px;">
                                <input type="hidden" name="acao" value="excluir_ebook">
                                <input type="hidden" name="id_ebook" value="<?= htmlspecialchars((string) ($ebook['id'] ?? '')) ?>">
                                <button type="submit" class="btn btn-editar" style="background:#b73232;">🗑️ Excluir eBook</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php if (empty($ebooks)): ?>
                    <p style="margin-top: 16px; color: var(--muted);">Nenhum eBook cadastrado no momento.</p>
                <?php endif; ?>
            </div>
        <?php endif; // fim do else (não é trocar_senha) ?>
        <?php endif; // fim do if não é trocar_senha ?>
    </div>

    <footer style="text-align: center; padding: 30px; color: var(--muted); margin-top: 50px; border-top: 1px solid var(--green-soft);">
        <p>Painel de Administração - Dr. Charles Genehr © 2026</p>
    </footer>
</body>
</html>
