# 🚀 Guia de Upload para Hostinger
**Site**: Dr. Charles Genehr - Medicina Integrativa

---

## 📦 Pré-Requisitos
- [ ] Conta Hostinger ativa
- [ ] Acesso FTP/SFTP disponível
- [ ] MySQL database criado
- [ ] Domínio apontado/configurado

---

## 📁 Arquivos para Upload

### Arquivo principal
```
trabalho html/
├── index.php ⭐ (PRINCIPAL - Página home)
├── artigo.php ⭐ (IMPORTANTE - Páginas de artigos)
├── style.css ⭐
├── script.js ⭐
├── database.sql (restaurar no MySQL)
├── admin/
│   ├── login.php
│   ├── dashboard.php
│   └── logout.php
├── includes/
│   ├── config.php (EDITAR credenciais!)
│   ├── db.php
│   └── auth.php
├── assets/
├── uploads/
│   └── capas/ (criar pasta se não existir)
└── [outros arquivos estáticos]
```

---

## 🔧 Instruções de Upload (passo a passo)

### 1️⃣ Fazer Login no Hostinger
```
1. Acesse: https://www.hostinger.com.br
2. Login com suas credenciais
3. Dashboard → Gerenciador de Arquivos OU FTP
```

### 2️⃣ Criar Pastas (se não existirem)
```
Navegue para: /public_html/
Crie (se não existir):
  - admin/
  - includes/
  - uploads/
  - uploads/capas/
  - assets/
```

### 3️⃣ Upload dos Arquivos
**Via Gerenciador de Arquivos (mais fácil):**
```
1. Clique em "Upload"
2. Selecione os arquivos (ou pasta inteira)
3. Arraste para /public_html/
4. Aguarde conclusão
```

**Via FTP (alternativa):**
```
1. Abra seu cliente FTP favorito (ex: FileZilla)
2. Host: ftp.seu-dominio.com (ou IP fornecido)
3. Usuário: suas credenciais
4. Pasta remota: /public_html/
5. Arraste arquivos
```

---

## 🗄️ Configurar Database (MySQL)

### 4️⃣ Criar Database no Hostinger
```
1. Dashboard → MySQL
2. Clique em "Criar Database"
3. Nome: site_medico
4. Usuário: crie um novo
5. Senha: gere uma forte
6. COPIE essas credenciais!
```

### 5️⃣ Importar Estrutura
```
1. Abra phpMyAdmin (no Hostinger)
2. Selecione database: site_medico
3. Guia "Importar"
4. Selecione: database.sql (do seu projeto)
5. Clique "Importar"
```

---

## ⚙️ Configurar PHP (Credenciais)

### 6️⃣ Editar includes/config.php
**IMPORTANTE: Atualizar com credenciais Hostinger**

```php
// ANTES (local):
'host' => 'localhost',
'port' => 3306,
'name' => 'site_medico',
'user' => 'root',
'pass' => '',

// DEPOIS (Hostinger - substitua com seus dados):
'host' => 'localhost', // ou seu_servidor_mysql.hostinger.com
'port' => 3306,
'name' => 'seu_usuario_site_medico', // geralmente prefixado com usuário
'user' => 'seu_usuario_db',
'pass' => 'sua_senha_db',
```

**Como fazer upload da versão editada:**
```
1. Edite localmente: includes/config.php
2. Salve o arquivo
3. Upload via FTP ou Gerenciador
4. Confirme que sobrescreveu a versão antiga
```

---

## 🔗 URLs de Teste

Após upload, teste os seguintes URLs:

### Homepage
```
✓ https://seu-dominio.com/
✓ https://seu-dominio.com/index.php
```

### Artigos (teste todos)
```
✓ https://seu-dominio.com/artigo.php?id=comida-10
✓ https://seu-dominio.com/artigo.php?id=mente-10
✓ https://seu-dominio.com/artigo.php?id=corpo-10
✓ https://seu-dominio.com/artigo.php?id=sono-10
✓ https://seu-dominio.com/artigo.php?id=vida-10
```

### Admin (opcional)
```
⚠ https://seu-dominio.com/admin/login.php
   (Faça login com email: admin@example.com)
```

---

## 🐛 Troubleshooting

### ❌ "Erro ao conectar no banco de dados"
**Solução:**
1. Verifique credenciais em `includes/config.php`
2. Confirme database foi criado no Hostinger
3. Verifique se database.sql foi importado

### ❌ "Arquivo não encontrado"
**Solução:**
1. Confirme upload para `/public_html/`
2. Verifique se estrutura de pastas está correta
3. Use Gerenciador de Arquivos para confirmar

### ❌ "Erro 500 (Internal Server Error)"
**Solução:**
1. Ative error logging
2. Verifique arquivo `error_log` (via FTP)
3. Contate suporte Hostinger

### ⚠️ "Imagens não carregam"
**Solução:**
1. Artigos usam Unsplash (URLs externas) - normal
2. Se suas próprias imagens não carregam:
   - Verifique upload em `/uploads/capas/`
   - Verifique permissões da pasta (755)

---

## ✅ Checklist Final

- [ ] Arquivos uploadados para `/public_html/`
- [ ] Database criado: `site_medico`
- [ ] Database.sql importado
- [ ] `includes/config.php` atualizado com credenciais
- [ ] Homepage funciona: `seu-dominio.com/`
- [ ] Pelo menos 1 artigo funciona
- [ ] Menu de navegação funciona
- [ ] Design responsivo no mobile
- [ ] Links de contato funcionam
- [ ] Admin login pode ser testado

---

## 📞 Suporte

Se precisar de ajuda:
1. **Hostinger Help**: https://support.hostinger.com.br
2. **Verificar Logs**: FTP → `/error_log`
3. **Reload DNS**: Às vezes leva 24h para propagação

---

## 🎉 Parabéns!

Seu site Dr. Charles está online! 

Próximos passos sugeridos:
- Testar todos os links
- Pedir feedback para o Dr. Charles
- Configurar analytics (Google Analytics)
- Backup regular dos arquivos

**Última atualização**: 14/07/2026
