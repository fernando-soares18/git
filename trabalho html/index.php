<?php

declare(strict_types=1);

// Artigos de exemplo (quando banco não está disponível)
$artigos = [
    [
        'titulo' => 'Como manter a saude da pele no inverno',
        'categoria' => 'Dermatologia',
        'data_publicacao' => '2026-07-10',
        'imagem_capa' => 'https://images.unsplash.com/photo-1556228578-8c89e6adf883?w=400',
        'conteudo' => 'O inverno traz desafios especiais para a saude da pele. Confira nossas dicas...',
        'autor' => 'Dr. Charles Genehr'
    ],
    [
        'titulo' => 'Nutrologia: alimentacao para pele radiante',
        'categoria' => 'Nutrologia',
        'data_publicacao' => '2026-07-08',
        'imagem_capa' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=400',
        'conteudo' => 'A nutricao e fundamental para uma pele saudavel e radiante. Saiba quais alimentos...',
        'autor' => 'Dr. Charles Genehr'
    ],
    [
        'titulo' => 'Acne em adultos: causas e tratamentos',
        'categoria' => 'Dermatologia',
        'data_publicacao' => '2026-07-05',
        'imagem_capa' => 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?w=400',
        'conteudo' => 'Muitos adultos sofrem com acne. Descubra como tratar efetivamente...',
        'autor' => 'Dr. Charles Genehr'
    ]
];

// eBooks gerenciados pelo painel (JSON)
$ebooks_file = __DIR__ . '/admin/ebooks.json';
$ebooks = [];

if (file_exists($ebooks_file)) {
    $ebooks_json = file_get_contents($ebooks_file);
    $ebooks_json = preg_replace('/^\xEF\xBB\xBF/', '', (string) $ebooks_json);
    $ebooks_data = json_decode($ebooks_json, true);

    if (is_array($ebooks_data)) {
        $ebooks = $ebooks_data;
    }
}

if (empty($ebooks)) {
    $ebooks = [
        [
            'titulo' => 'Saúde da pele e bem-estar',
            'descricao' => 'Um guia prático sobre cuidados com a pele, nutrição e hábitos que favorecem a saúde integral.',
            'link' => 'https://www.amazon.com.br/dp/B0FG8HV69F'
        ],
        [
            'titulo' => 'Nutrição para viver melhor',
            'descricao' => 'Conteúdo sobre alimentação funcional, metabolismo e escolhas que promovem energia e equilíbrio.',
            'link' => 'https://www.amazon.com.br/dp/B0FG87D936'
        ],
        [
            'titulo' => 'Equilíbrio e medicina integrativa',
            'descricao' => 'Uma visão completa sobre prevenção, autocuidado e o papel da medicina integrativa na saúde duradoura.',
            'link' => 'https://www.amazon.com.br/dp/B073V816YN'
        ]
    ];
}

$ebooks_home = array_slice($ebooks, 0, 3);
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
            <a href="#home">Início</a>
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
                <h1>Equilíbrio para sua pele, mente e corpo.</h1>
                <p>Uma abordagem personalizada que une ciência, cuidado humano e protocolos integrativos para transformar sua saúde e sua qualidade de vida.</p>

                <div class="hero-actions">
                    <a href="#contato" class="btn btn-primary">Agendar consulta</a>
                    <a href="https://wa.me/55519966042" class="btn btn-secondary" target="_blank" rel="noopener">Falar agora</a>
                </div>

                <ul class="hero-highlights">
                    <li>Atendimento humanizado</li>
                    <li>Presencial ou online</li>
                    <li>Plano personalizado</li>
                </ul>
            </div>

            <div class="hero-card">
                <h3>Seu caminho para uma saúde integral</h3>
                <p>Escuta ativa, diagnóstico cuidadoso e um plano pensado para você, com foco em resultados reais e duradouros.</p>
                <div class="hero-card-list">
                    <span>Dermatologia clínica</span>
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
                <h2>Uma abordagem integral para a saúde da pele e do organismo</h2>
                <p>Como dermatologista (CREMERS 26.509 | RQE 17317) com pós-graduação em nutrologia (não especialista), o Dr. Charles enxerga além dos sintomas superficiais.</p>
                <p>Sua metodologia integrativa investiga profundamente as raízes dos desequilíbrios que se manifestam na pele e no organismo, criando um plano de tratamento verdadeiramente personalizado.</p>
                <p>Através de uma combinação criteriosa entre a medicina ocidental e os conhecimentos do Ayurveda, o Dr. Charles trabalha para identificar as verdadeiras causas dos sintomas, restaurar a harmonia entre mente e corpo, capacitar o paciente com conhecimentos para manter a saúde a longo prazo e desenvolver soluções personalizadas que respeitam a individualidade biológica.</p>
                <a href="#contato" class="text-link">Conheça mais</a>
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
                <h2>Dermatologia clínica e estética com visão médica, humana e personalizada</h2>
                <p>A dermatologia é uma área essencial para cuidar da saúde da pele, do couro cabeludo e das unhas, com foco em diagnóstico preciso, prevenção e tratamento de longo prazo.</p>
                <p>Atendimentos para acne, rosácea, melasma, dermatite, psoríase, sensibilidade cutânea, queda de cabelo, envelhecimento e cuidados estéticos com segurança.</p>
                <div class="dermatology-features">
                    <span>Acne e pós-acne</span>
                    <span>Rosácea e sensibilidade</span>
                    <span>Melasma e hiperpigmentação</span>
                    <span>Cuidados preventivos</span>
                </div>
                <a href="#contato" class="text-link">Agendar avaliação dermatológica</a>
            </div>
        </div>
    </section>

    <section class="conditions-section">
        <div class="container">
            <div class="section-header">
                <p class="eyebrow">Condições dermatológicas</p>
                <h2>Abordagem integrativa para pele, inflamação e equilíbrio</h2>
                <p>Tratamentos personalizados para condições dermatológicas com foco em causa, inflamação, nutrição e bem-estar integral.</p>
            </div>

            <div class="conditions-grid">
                <article class="condition-card">
                    <img src="assets/logo-dr-charles-20.png" alt="Acne" class="condition-image">
                    <h3>Acne</h3>
                    <p>Frequentemente relacionada a desequilíbrios hormonais, inflamação e fatores dietéticos. A abordagem nutrológica e integrativa do Dr. Charles é fundamental para identificar e tratar as causas subjacentes, não apenas os sintomas.</p>
                </article>

                <article class="condition-card">
                    <img src="assets/logo-dr-charles-21.png" alt="Rosacea" class="condition-image">
                    <h3>Rosácea</h3>
                    <p>Uma condição inflamatória crônica da pele que pode ser agravada por fatores dietéticos, estresse e desequilíbrios internos. O tratamento com Ayurveda e Nutrologia Funcional pode oferecer um alívio significativo e duradouro.</p>
                </article>

                <article class="condition-card">
                    <img src="assets/logo-dr-charles-22.png" alt="Dermatite atópica" class="condition-image">
                    <h3>Dermatite Atópica (Eczema)</h3>
                    <p>Muitas vezes associada a alergias, sensibilidades alimentares e disfunções da barreira cutânea, que podem ser influenciadas pela saúde intestinal e nutricional.</p>
                </article>

                <article class="condition-card">
                    <img src="assets/logo-dr-charles-23.png" alt="Psoriase" class="condition-image">
                    <h3>Psoríase</h3>
                    <p>Uma doença autoimune crônica que tem forte ligação com o sistema imunológico, inflamação e, em muitos casos, com a saúde intestinal. A medicina integrativa e o Ayurveda podem ser valiosos para gerenciar a condição de forma holística.</p>
                </article>

                <article class="condition-card">
                    <img src="assets/logo-dr-charles-28.png" alt="Vitiligo" class="condition-image">
                    <h3>Vitiligo</h3>
                    <p>A nutrição desempenha papel fundamental nesta abordagem. Deficiências específicas de micronutrientes são frequentemente identificadas em pacientes com vitiligo e sua correção pode estabilizar a progressão da doença. Implementamos dietas anti-inflamatórias personalizadas que reduzem a ativação imunológica excessiva e o estresse oxidativo.</p>
                </article>

                <article class="condition-card">
                    <img src="assets/logo-dr-charles-24.png" alt="Melasma" class="condition-image">
                    <h3>Melasma</h3>
                    <p>Manchas escuras na pele que podem ser influenciadas por hormônios, exposição solar e, segundo a perspectiva ayurvédica, por desequilíbrios internos (especialmente do dosha Pitta).</p>
                </article>

                <article class="condition-card">
                    <img src="assets/logo-dr-charles-25.png" alt="Alopecia" class="condition-image">
                    <h3>Alopecia</h3>
                    <p>Pode ter diversas causas, incluindo deficiências nutricionais, estresse, desequilíbrios hormonais e doenças autoimunes, todos os quais podem ser abordados pela visão integrativa do Dr. Charles.</p>
                </article>

                <article class="condition-card">
                    <img src="assets/logo-dr-charles-26.png" alt="Outras condicoes inflamatorias" class="condition-image">
                    <h3>Outras condições inflamatórias da pele</h3>
                    <p>Como dermatites de contato, urticária, etc., que podem ter gatilhos internos ou serem exacerbadas por desequilíbrios sistêmicos.</p>
                </article>
            </div>
        </div>
    </section>

    <section id="especialidades" class="services">
        <div class="container">
            <div class="section-header">
                <p class="eyebrow">Especialidades</p>
                <h2>Como posso te ajudar</h2>
                <p>Atendimentos voltados para saúde da pele, metabolismo, longevidade e bem-estar, com foco em diagnóstico preciso e tratamento personalizado.</p>
            </div>

            <div class="cards">
                <article class="card">
                    <h3>Dermatologia clínica e estética</h3>
                    <p>Tratamentos personalizados para acne, rosácea, melasma, dermatite atópica, psoríase, alopecia, sensibilidade cutânea, hiperpigmentação e envelhecimento cutâneo, sempre com olhar clínico, estético e terapêutico.</p>
                </article>

                <article class="card">
                    <h3>Nutrologia e longevidade</h3>
                    <p>Acompanhamento nutricional com foco em metabolismo, energia, emagrecimento, prevenção e qualidade de vida.</p>
                </article>

                <article class="card">
                    <h3>Medicina integrativa</h3>
                    <p>Abordagem completa, considerando corpo, mente, emoções, estilo de vida e autocuidado para promover equilíbrio duradouro.</p>
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
                <p>Anos de experiência</p>
            </div>
            <div class="benefit-item">
                <h3>98%</h3>
                <p>Índice de satisfação</p>
            </div>
        </div>
    </section>

    <section id="artigos" class="learn-section">
        <div class="container">
            <div class="section-header">
                <p class="eyebrow">Aprenda Conosco</p>
                <h2>Conhecimento para sua saúde integral</h2>
                <p>Explore tópicos essenciais sobre nutrição, bem-estar, medicina integrativa e estilo de vida saudável.</p>
            </div>

            <div class="learn-list">
                <a href="comida-10.php" class="learn-list-item">
                    <span class="learn-list-category">Comida 10</span>
                    <span class="learn-list-title">Ver artigos de alimentação (Comida 10)</span>
                </a>

                <a href="mente-10.php" class="learn-list-item">
                    <span class="learn-list-category">Mente 10</span>
                    <span class="learn-list-title">Stress, emoções e seu impacto na saúde da pele</span>
                </a>

                <a href="corpo-10.php" class="learn-list-item">
                    <span class="learn-list-category">Corpo 10</span>
                    <span class="learn-list-title">Movimento, circulação e vitalidade corpórea</span>
                </a>

                <a href="sono-10.php" class="learn-list-item">
                    <span class="learn-list-category">Sono 10</span>
                    <span class="learn-list-title">Sono restaurador: a base para a regeneração celular</span>
                </a>

                <a href="vida-10.php" class="learn-list-item">
                    <span class="learn-list-category">Vida 10</span>
                    <span class="learn-list-title">Estilo de vida integral: o poder da consistência</span>
                </a>


            </div>
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
                    <p>"Mudou minha qualidade de vida. As orientações foram claras, objetivas e muito bem personalizadas."</p>
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
                <h2>Conteúdos gratuitos para você</h2>
                <p>Explore materiais que ajudam a entender melhor a saúde da pele, nutrição e bem-estar integral.</p>
            </div>

            <div class="cards">
                <?php foreach ($ebooks_home as $ebook): ?>
                    <article class="card ebook-card">
                        <h3><?= htmlspecialchars((string) ($ebook['titulo'] ?? 'eBook'), ENT_QUOTES, 'UTF-8') ?></h3>
                        <p><?= htmlspecialchars((string) ($ebook['descricao'] ?? 'Conteúdo em breve.'), ENT_QUOTES, 'UTF-8') ?></p>
                        <a href="<?= htmlspecialchars((string) ($ebook['link'] ?? '#'), ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener" class="text-link">Acessar eBook</a>
                    </article>
                <?php endforeach; ?>
            </div>

            <div style="margin-top: 20px; text-align: center;">
                <a href="ebooks.php" class="btn btn-primary">Mais eBooks</a>
            </div>
        </div>
    </section>

    <section id="contato" class="contact">
        <div class="container contact-grid">
            <div class="contact-info">
                <p class="eyebrow">Contato</p>
                <h2>Agende sua consulta</h2>
                <p>Atendimento presencial e online com acolhimento, escuta e um plano pensado para você. A saúde integral começa com um primeiro passo.</p>

                <div class="contact-item">
                    <strong>Endereços</strong>
                    <span>R. Tupi, 1242 - Centro, Novo Hamburgo - RS. (51) 3581-2645.</span>
                    <span>Tv. Sete de Setembro, 74 A - Sala 03 - Centro, Sapiranga - RS. (51) 99954-8778.</span>
                    <span>R. Rui Barbosa, 64 - Centro, Campo Bom - RS. (51) 99255-1772.</span>
                </div>

                <div class="contact-item">
                    <strong>Horário</strong>
                    <span>Segunda a quarta, das 09h às 18h</span>
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

<a class="whatsapp" href="https://wa.me/55519966042" target="_blank" rel="noopener" aria-label="Abrir contato" title="Falar agora">
    <svg viewBox="0 0 32 32" aria-hidden="true" focusable="false">
        <path fill="currentColor" d="M19.11 17.27c-.27-.14-1.57-.77-1.81-.86-.24-.09-.41-.14-.59.14-.18.27-.68.86-.84 1.03-.16.18-.31.2-.57.07-.27-.14-1.12-.41-2.14-1.31-.79-.7-1.32-1.57-1.47-1.84-.16-.27-.02-.41.12-.54.12-.12.27-.31.41-.47.14-.16.18-.27.27-.45.09-.18.05-.34-.02-.47-.07-.14-.59-1.42-.81-1.95-.21-.5-.43-.43-.59-.44h-.5c-.18 0-.47.07-.72.34-.24.27-.95.93-.95 2.27s.97 2.63 1.11 2.81c.14.18 1.91 2.91 4.63 4.08.65.28 1.16.45 1.55.58.65.2 1.23.17 1.69.1.52-.08 1.57-.64 1.79-1.25.22-.61.22-1.13.15-1.25-.06-.11-.24-.18-.5-.31zM16.03 4.8c-6.18 0-11.2 5.01-11.2 11.2 0 1.98.52 3.84 1.43 5.45L4.8 27.2l5.89-1.55a11.14 11.14 0 0 0 5.34 1.36h.01c6.18 0 11.2-5.02 11.2-11.2 0-3-1.17-5.81-3.29-7.93a11.14 11.14 0 0 0-7.92-3.08zm0 20.3h-.01a9.12 9.12 0 0 1-4.66-1.27l-.33-.2-3.49.92.93-3.4-.22-.35a9.07 9.07 0 0 1-1.39-4.79c0-5.04 4.1-9.14 9.15-9.14 2.44 0 4.73.95 6.45 2.67a9.07 9.07 0 0 1 2.68 6.47c0 5.04-4.1 9.14-9.14 9.14z"/>
    </svg>
</a>

<footer>
    <div class="container footer-content">
        <p>© 2026 Dr. Charles Genehr - Todos os direitos reservados.</p>
        <p class="footer-addresses">R. Tupi, 1242 - Centro, Novo Hamburgo - RS • Tv. Sete de Setembro, 74 A - Sala 03 - Centro, Sapiranga - RS • R. Rui Barbosa, 64 - Centro, Campo Bom - RS</p>
        <div class="footer-links">
            <a href="#home">Início</a>
            <a href="#sobre">Sobre</a>
            <a href="#artigos">Artigos</a>
            <a href="#contato">Contato</a>
            <a href="admin/login.php">Painel</a>
        </div>
    </div>
</footer>
</body>
</html>
