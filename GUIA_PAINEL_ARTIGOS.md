# 🎉 Painel de Administração - Guia Rápido

## 🚀 Como Acessar

```
http://localhost:8000/admin/painel.php
```

ou no Hostinger:

```
https://seu-dominio.com/admin/painel.php
```

---

## 📝 Como Usar

### 1️⃣ **Ver Todos os Artigos**
- Ao abrir o painel, você vê todos os 5 artigos em cards bonitos
- Cada card mostra:
  - 📌 Categoria
  - 📝 Título
  - 📅 Data de publicação
  - ✍️ Autor
  - 🔗 ID do artigo

### 2️⃣ **Editar um Artigo**
1. Clique no botão **✏️ Editar** do artigo que quer modificar
2. O formulário abrirá com todos os campos preenchidos
3. Faça as alterações que quiser:
   - **Título**: Mude o nome do artigo
   - **Categoria**: Categoria (ex: Comida 10, Mente 10)
   - **Data**: Data de publicação
   - **URL da Imagem**: Link da imagem (Unsplash recomendado)
   - **Conteúdo**: Texto completo com HTML
   - **Autor**: Nome do autor

### 3️⃣ **Salvar Artigo**
- Clique no botão **💾 Salvar Artigo**
- Você verá uma mensagem de sucesso: ✅ "Artigo 'Título' salvo com sucesso!"
- A mudança aparece imediatamente no painel e nas páginas do site

### 4️⃣ **Cancelar Edição**
- Clique no botão **❌ Cancelar** para voltar à listagem sem salvar

---

## 📝 Formatando o Conteúdo (HTML)

O campo de conteúdo aceita **HTML**. Você pode usar:

### Headings
```html
<h2>Título Principal</h2>
<h3>Subtítulo</h3>
```

### Parágrafos e Texto
```html
<p>Parágrafo normal</p>
<p><strong>Texto em negrito</strong></p>
<p><em>Texto em itálico</em></p>
```

### Listas
```html
<ul>
  <li>Item 1</li>
  <li>Item 2</li>
  <li>Item 3</li>
</ul>
```

### Exemplo Completo
```html
<h2>Título do Artigo</h2>
<p>Introdução do artigo com <strong>algumas palavras em negrito</strong>.</p>

<h3>Primeira Seção</h3>
<p>Conteúdo da primeira seção.</p>
<ul>
  <li>Ponto 1</li>
  <li>Ponto 2</li>
</ul>

<h3>Segunda Seção</h3>
<p>Conteúdo da segunda seção.</p>
```

---

## 🔧 Onde os Artigos são Salvos?

Os artigos são armazenados em um arquivo JSON:
```
trabalho html/admin/artigos.json
```

Este arquivo é:
- ✅ Atualizado automaticamente quando você salva
- ✅ Lido quando você abre uma página de artigo
- ✅ Portável (pode ser copiado para o Hostinger facilmente)

---

## 📚 Os 5 Artigos

| ID | Título | Categoria |
|----|--------|-----------|
| comida-10 | Nutrição que transforma sua pele | Comida 10 |
| mente-10 | Stress, emoções e impacto na pele | Mente 10 |
| corpo-10 | Movimento, circulação e vitalidade | Corpo 10 |
| sono-10 | Sono restaurador e regeneração | Sono 10 |
| vida-10 | Estilo de vida integral | Vida 10 |

---

## ✨ Dicas Úteis

1. **Copie e Cole**: Se quer criar artigos similares, copie o conteúdo HTML de um existente
2. **Imagens**: Use URLs do Unsplash (https://unsplash.com/) para manter a qualidade
3. **Data**: Use formato YYYY-MM-DD (ex: 2026-07-14)
4. **Testando**: Abra o painel em uma aba e o site em outra para ver mudanças em tempo real
5. **Backup**: Faça download do artigos.json periodicamente para segurança

---

## 🚨 Problemas Comuns

### "Artigo não salvou"
- Verifique se **todos os campos obrigatórios** estão preenchidos
- Pressione F5 para recarregar se a mensagem não aparecer

### "Conteúdo com HTML quebrado"
- Use `<br/>` em vez de `<br>` para quebras de linha
- Verifique se abriu e fechou todas as tags (ex: `<p>...texto...</p>`)

### "Imagem não carrega"
- Verifique se a URL está correta
- Teste a URL em outra aba

---

## 📞 Próximas Etapas

1. ✅ Testar o painel localmente
2. ✅ Fazer mudanças que quiser nos artigos
3. ✅ Upload para o Hostinger (junto com os outros arquivos)
4. ✅ Acessar o painel online: seu-dominio.com/admin/painel.php

**Pronto! Agora você pode gerenciar os artigos facilmente! 🎉**
