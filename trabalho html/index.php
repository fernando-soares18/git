<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/db.php';

$artigos = $pdo->query(
    'SELECT a.titulo, a.categoria, a.data_publicacao, a.imagem_capa, a.conteudo, ad.nome AS autor
     FROM artigos a
     INNER JOIN admins ad ON ad.id = a.admin_id
     ORDER BY a.data_publicacao DESC, a.id DESC
     LIMIT 12'
)->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dr. Charles Genehr | Medicina Integrativa</title>
<link rel="stylesheet" href="/style.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<script defer src="script.js"></script>
</head>

<body>
<header class="site-header">
    <div class="container nav-bar">
        <a class="logo" href="#home">
            <img src="assets/logo-dr-charles-12.png" alt="Logo Dr. Charles Genehr" class="header-logo">
            <span>Dr. Charles Genehr</span>
        </a>

        <nav id="menu" class="nav-links">
            <a href="#home">Inicio</a>
            <a href="#sobre">Sobre</a>
            <a href="#especialidades">Especialidades</a>
            <a href="#artigos">Artigos</a>
            <a href="#depoimentos">Depoimentos</a>
            <a href="#contato">Contato</a>
        </nav>

        <button class="hamburguer" id="hamburguer" aria-label="Abrir menu">☰</button>
    </div>
</header>

<main>
    <section id="home" class="hero">
        <div class="container hero-grid">
            <div class="hero-content">
                <p class="eyebrow">Medicina integrativa • Dermatologia • Nutrologia</p>
                <h1>Equilibrio para sua pele, mente e corpo.</h1>
                <p>Uma abordagem personalizada que une ciencia, cuidado humano e protocolos integrativos para transformar sua saude e sua qualidade de vida.</p>

                <div class="hero-actions">
                    <a href="#contato" class="btn btn-primary">Agendar consulta</a>
                    <a href="https://wa.me/5551996604296" class="btn btn-secondary" target="_blank" rel="noopener">Falar no WhatsApp</a>
                </div>

                <ul class="hero-highlights">
                    <li>Atendimento humanizado</li>
                    <li>Presencial ou online</li>
                    <li>Plano personalizado</li>
                </ul>
            </div>

            <div class="hero-card">
                <h3>Seu caminho para uma saude integral</h3>
                <p>Escuta ativa, diagnostico cuidadoso e um plano pensado para voce, com foco em resultados reais e duradouros.</p>
                <div class="hero-card-list">
                    <span>Dermatologia clinica</span>
                    <span>Nutrologia funcional</span>
                    <span>Medicina integrativa</span>
                </div>
            </div>
        </div>
    </section>

    <section id="sobre" class="about">
        <div class="container about-grid">
            <div class="about-text">
                <p class="eyebrow">Sobre o Dr. Charles</p>
                <h2>Uma abordagem integral para a saude da pele e do organismo</h2>
                <p>Como dermatologista (CREMERS 26.509 | RQE 17317) com pos-graduacao em nutrologia (nao especialista), o Dr. Charles enxerga alem dos sintomas superficiais.</p>
                <p>Sua metodologia integrativa investiga profundamente as raizes dos desequilibrios que se manifestam na pele e no organismo, criando um plano de tratamento verdadeiramente personalizado.</p>
                <p>Atraves de uma combinacao criteriosa entre a medicina ocidental e os conhecimentos do Ayurveda, o Dr. Charles trabalha para identificar as verdadeiras causas dos sintomas, restaurar a harmonia entre mente e corpo, capacitar o paciente com conhecimentos para manter a saude a longo prazo e desenvolver solucoes personalizadas que respeitam a individualidade biologica.</p>
                <a href="#contato" class="text-link">Conheca mais</a>
            </div>

            <div class="about-image">
                <img src="assets/fbc353_9385328405b1402dbf9cc123204632ba~mv2.jpg" alt="Dr. Charles Genehr em atendimento personalizado">
            </div>
        </div>
    </section>

    <section class="dermatology-showcase">
        <div class="container dermatology-grid">

            <div class="dermatology-media">
                <img src="assets/frutas-legumes-vecteezy.jpg" alt="Tigela com frutas, legumes, limao e gengibre">
                <img src="https://images.unsplash.com/photo-1571781926291-c477ebfd024b?w=900" alt="Tratamento e cuidado da pele com atencao clinica">
            </div>

            <div class="dermatology-copy">
                <p class="eyebrow">Dermatologia</p>
                <h2>Dermatologia clinica e estetica com visao medica, humana e personalizada</h2>
                <p>A dermatologia e uma area essencial para cuidar da saude da pele, do couro cabeludo e das unhas, com foco em diagnostico preciso, prevencao e tratamento de longo prazo.</p>
                <p>Atendimentos para acne, rosacea, melasma, dermatite, psoriase, sensibilidade cutanea, queda de cabelo, envelhecimento e cuidados esteticos com seguranca.</p>
                <div class="dermatology-features">
                    <span>Acne e pos-acne</span>
                    <span>Rosacea e sensibilidade</span>
                    <span>Melasma e hiperpigmentacao</span>
                    <span>Cuidados preventivos</span>
                </div>
                <a href="#contato" class="text-link">Agendar avaliacao dermatologica</a>
            </div>
        </div>
    </section>

    <section class="conditions-section">
        <div class="container">
            <div class="section-header">
                <p class="eyebrow">Condicoes dermatologicas</p>
                <h2>Abordagem integrativa para pele, inflamacao e equilibrio</h2>
                <p>Tratamentos personalizados para condicoes dermatologicas com foco em causa, inflamacao, nutricao e bem-estar integral.</p>
            </div>

            <div class="conditions-grid">
                <article class="condition-card">
                    <img src="assets/logo-dr-charles-20.png" alt="Acne" class="condition-image">
                    <h3>Acne</h3>
                    <p>Frequentemente relacionada a desequilibrios hormonais, inflamacao e fatores dieteticos. A abordagem nutrologica e integrativa do Dr. Charles e fundamental para identificar e tratar as causas subjacentes, nao apenas os sintomas.</p>
                </article>

                <article class="condition-card">
                    <img src="assets/logo-dr-charles-21.png" alt="Rosacea" class="condition-image">
                    <h3>Rosacea</h3>
                    <p>Uma condicao inflamatoria cronica da pele que pode ser agravada por fatores dieteticos, estresse e desequilibrios internos. O tratamento com Ayurveda e Nutrologia Funcional pode oferecer um alivio significativo e duradouro.</p>
                </article>

                <article class="condition-card">
                    <img src="assets/logo-dr-charles-22.png" alt="Dermatite atopica" class="condition-image">
                    <h3>Dermatite Atopica (Eczema)</h3>
                    <p>Muitas vezes associada a alergias, sensibilidades alimentares e disfuncoes da barreira cutanea, que podem ser influenciadas pela saude intestinal e nutricional.</p>
                </article>

                <article class="condition-card">
                    <img src="assets/logo-dr-charles-23.png" alt="Psoriase" class="condition-image">
                    <h3>Psoriase</h3>
                    <p>Uma doenca autoimune cronica que tem forte ligacao com o sistema imunologico, inflamacao e, em muitos casos, com a saude intestinal. A medicina integrativa e o Ayurveda podem ser valiosos para gerenciar a condicao de forma holistica.</p>
                </article>

                <article class="condition-card">
                    <img src="assets/logo-dr-charles-28.png" alt="Vitiligo" class="condition-image">
                    <h3>Vitiligo</h3>
                    <p>A nutricao desempenha papel fundamental nesta abordagem. Deficiencias especificas de micronutrientes sao frequentemente identificadas em pacientes com vitiligo e sua correcao pode estabilizar a progressao da doenca. Implementamos dietas anti-inflamatorias personalizadas que reduzem a ativacao imunologica excessiva e o estresse oxidativo.</p>
                </article>

                <article class="condition-card">
                    <img src="assets/logo-dr-charles-24.png" alt="Melasma" class="condition-image">
                    <h3>Melasma</h3>
                    <p>Manchas escuras na pele que podem ser influenciadas por hormonios, exposicao solar e, segundo a perspectiva ayurvedica, por desequilibrios internos (especialmente do dosha Pitta).</p>
                </article>

                <article class="condition-card">
                    <img src="assets/logo-dr-charles-25.png" alt="Alopecia" class="condition-image">
                    <h3>Alopecia</h3>
                    <p>Pode ter diversas causas, incluindo deficiencias nutricionais, estresse, desequilibrios hormonais e doencas autoimunes, todos os quais podem ser abordados pela visao integrativa do Dr. Charles.</p>
                </article>

                <article class="condition-card">
                    <img src="assets/logo-dr-charles-26.png" alt="Outras condicoes inflamatorias" class="condition-image">
                    <h3>Outras condicoes inflamatorias da pele</h3>
                    <p>Como dermatites de contato, urticaria, etc., que podem ter gatilhos internos ou serem exacerbadas por desequilibrios sistemicos.</p>
                </article>
            </div>
        </div>
    </section>

    <section id="especialidades" class="services">
        <div class="container">
            <div class="section-header">
                <p class="eyebrow">Especialidades</p>
                <h2>Como posso te ajudar</h2>
                <p>Atendimentos voltados para saude da pele, metabolismo, longevidade e bem-estar, com foco em diagnostico preciso e tratamento personalizado.</p>
            </div>

            <div class="cards">
                <article class="card">
                    <h3>Dermatologia clinica e estetica</h3>
                    <p>Tratamentos personalizados para acne, rosacea, melasma, dermatite atopica, psoriase, alopecia, sensibilidade cutanea, hiperpigmentacao e envelhecimento cutaneo, sempre com olhar clinico, estetico e terapeutico.</p>
                </article>

                <article class="card">
                    <h3>Nutrologia e longevidade</h3>
                    <p>Acompanhamento nutricional com foco em metabolismo, energia, emagrecimento, prevencao e qualidade de vida.</p>
                </article>

                <article class="card">
                    <h3>Medicina integrativa</h3>
                    <p>Abordagem completa, considerando corpo, mente, emocoes, estilo de vida e autocuidado para promover equilibrio duradouro.</p>
                </article>
            </div>
        </div>
    </section>

    <section class="benefits">
        <div class="container benefits-grid">
            <div class="benefit-item">
                <h3>+5 mil</h3>
                <p>Pacientes acolhidos</p>
            </div>
            <div class="benefit-item">
                <h3>15+</h3>
                <p>Anos de experiencia</p>
            </div>
            <div class="benefit-item">
                <h3>98%</h3>
                <p>Indice de satisfacao</p>
            </div>
        </div>
    </section>

    <section id="artigos" class="articles-section">
        <div class="container">
            <div class="section-header">
                <p class="eyebrow">Artigos</p>
            </div>

            <?php if (count($artigos) === 0): ?>
                <div class="article-empty">
                    <p>Nenhum artigo publicado ainda. Acesse o <a href="admin/login.php">painel exclusivo</a> para criar o primeiro.</p>
                </div>
            <?php else: ?>
                <div class="articles-grid">
                    <?php foreach ($artigos as $artigo): ?>
                        <?php
                        $plainText = strip_tags((string) $artigo['conteudo']);
                        if (function_exists('mb_substr') && function_exists('mb_strlen')) {
                            $preview = mb_substr($plainText, 0, 220);
                            if (mb_strlen($plainText) > 220) {
                                $preview .= '...';
                            }
                        } else {
                            $preview = substr($plainText, 0, 220);
                            if (strlen($plainText) > 220) {
                                $preview .= '...';
                            }
                        }
                        ?>
                        <article class="article-card">
                            <img src="<?= htmlspecialchars((string) $artigo['imagem_capa'], ENT_QUOTES, 'UTF-8') ?>" alt="Capa do artigo <?= htmlspecialchars((string) $artigo['titulo'], ENT_QUOTES, 'UTF-8') ?>">
                            <div class="article-card-body">
                                <div class="article-meta">
                                    <span><?= htmlspecialchars((string) $artigo['categoria'], ENT_QUOTES, 'UTF-8') ?></span>
                                    <span><?= date('d/m/Y', strtotime((string) $artigo['data_publicacao'])) ?></span>
                                </div>
                                <h3><?= htmlspecialchars((string) $artigo['titulo'], ENT_QUOTES, 'UTF-8') ?></h3>
                                <p><?= htmlspecialchars($preview, ENT_QUOTES, 'UTF-8') ?></p>
                                <small>Por <?= htmlspecialchars((string) $artigo['autor'], ENT_QUOTES, 'UTF-8') ?></small>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <section id="depoimentos" class="testimonials">
        <div class="container">
            <div class="section-header">
                <p class="eyebrow">Depoimentos</p>
                <h2>Pacientes que encontraram um novo caminho</h2>
            </div>

            <div class="cards">
                <article class="card testimonial-card">
                    <p>"Excelente atendimento, acolhimento e uma abordagem muito completa. Senti que realmente me entenderam."</p>
                    <strong> Ana P.</strong>
                </article>

                <article class="card testimonial-card">
                    <p>"Mudou minha qualidade de vida. As orientacoes foram claras, objetivas e muito bem personalizadas."</p>
                    <strong> Marcos T.</strong>
                </article>

                <article class="card testimonial-card">
                    <p>"Profissionalismo, cuidado e resultados. Recomendo para quem busca uma abordagem mais humana."</p>
                    <strong> Carla R.</strong>
                </article>
            </div>
        </div>
    </section>

    <section class="ebooks">
        <div class="container">
            <div class="section-header">
                <p class="eyebrow">Ebooks</p>
                <h2>Conteudos gratuitos para voce</h2>
                <p>Explore materiais que ajudam a entender melhor a saude da pele, nutricao e bem-estar integral.</p>
            </div>

            <div class="cards">
                <article class="card ebook-card">
                    <h3>Saude da pele e bem-estar</h3>
                    <p>Um guia pratico sobre cuidados com a pele, nutricao e habitos que favorecem a saude integral.</p>
                    <a href="https://www.amazon.com.br/dp/B0FG8HV69F" target="_blank" rel="noopener" class="text-link">Acessar ebook</a>
                </article>

                <article class="card ebook-card">
                    <h3>Nutricao para viver melhor</h3>
                    <p>Conteudo sobre alimentacao funcional, metabolismo e escolhas que promovem energia e equilibrio.</p>
                    <a href="https://www.amazon.com.br/dp/B0FG87D936" target="_blank" rel="noopener" class="text-link">Acessar ebook</a>
                </article>

                <article class="card ebook-card">
                    <h3>Equilibrio e medicina integrativa</h3>
                    <p>Uma visao completa sobre prevencao, autocuidado e o papel da medicina integrativa na saude duradoura.</p>
                    <a href="https://www.amazon.com.br/dp/B073V816YN" target="_blank" rel="noopener" class="text-link">Acessar ebook</a>
                </article>
            </div>
        </div>
    </section>

    <section id="contato" class="contact">
        <div class="container contact-grid">
            <div class="contact-info">
                <p class="eyebrow">Contato</p>
                <h2>Agende sua consulta</h2>
                <p>Atendimento presencial e online com acolhimento, escuta e um plano pensado para voce. A saude integral comeca com um primeiro passo.</p>

                <div class="contact-item">
                    <strong>WhatsApp</strong>
                    <a href="https://wa.me/5551996604296" target="_blank" rel="noopener">+55 51 99660-4296</a>
                </div>

                <div class="contact-item">
                    <strong>Endereco</strong>
                    <span>Rua Araponga, 306 - Chacara das Pedras, Porto Alegre/RS</span>
                </div>

                <div class="contact-item">
                    <strong>Horario</strong>
                    <span>Segunda a quarta, das 09h as 18h</span>
                </div>

                <div class="contact-item">
                    <strong>Redes sociais</strong>
                    <a href="https://www.instagram.com/drcharlesgenehr" target="_blank" rel="noopener">Instagram</a>
                    <a href="https://www.youtube.com/c/DrCharlesGenehr" target="_blank" rel="noopener">YouTube</a>
                </div>
            </div>

            <form class="contact-form">
                <input type="text" placeholder="Nome">
                <input type="email" placeholder="E-mail">
                <input type="tel" placeholder="Telefone">
                <textarea placeholder="Mensagem"></textarea>
                <button type="submit">Enviar</button>
            </form>
        </div>
    </section>
</main>

<a class="whatsapp" href="https://wa.me/5551996604296" target="_blank" rel="noopener" aria-label="Abrir WhatsApp">💬</a>

<footer>
    <div class="container footer-content">
        <p>© 2026 Dr. Charles Genehr - Todos os direitos reservados.</p>
        <div class="footer-links">
            <a href="#home">Inicio</a>
            <a href="#sobre">Sobre</a>
            <a href="#artigos">Artigos</a>
            <a href="#contato">Contato</a>
            <a href="admin/login.php">Painel</a>
        </div>
    </div>
</footer>
</body>
</html>
