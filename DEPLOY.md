# Guia de Deploy - Landing Page Syntaxa

## 🚀 Opções de Deploy

### 1. Netlify (Recomendado)

1. Acesse [netlify.com](https://netlify.com)
2. Faça login ou crie uma conta
3. Arraste a pasta `syntaxa-landing` para o deploy
4. Configure o domínio personalizado `syntaxa.com.br`

### 2. Vercel

1. Acesse [vercel.com](https://vercel.com)
2. Conecte com GitHub ou faça upload direto
3. Configure o domínio personalizado

### 3. GitHub Pages

1. Crie um repositório no GitHub
2. Faça upload dos arquivos
3. Ative GitHub Pages nas configurações
4. Configure domínio personalizado

### 4. Servidor Próprio (Apache/Nginx)

#### Apache
```apache
<VirtualHost *:80>
    ServerName syntaxa.com.br
    DocumentRoot /var/www/syntaxa-landing
    
    <Directory /var/www/syntaxa-landing>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

#### Nginx
```nginx
server {
    listen 80;
    server_name syntaxa.com.br;
    root /var/www/syntaxa-landing;
    index index.html;
    
    location / {
        try_files $uri $uri/ =404;
    }
}
```

## 🔧 Configurações Adicionais

### SSL/HTTPS
- Configure certificado SSL (Let's Encrypt recomendado)
- Redirecione HTTP para HTTPS

### Performance
- Configure compressão gzip
- Configure cache headers
- Use CDN para assets estáticos

### Analytics
- Adicione Google Analytics no `<head>` do index.html
- Configure Google Search Console

### Formulário de Contato
Para o formulário funcionar completamente:

1. **Formspree** (mais simples):
   ```html
   <form action="https://formspree.io/f/YOUR_FORM_ID" method="POST">
   ```

2. **Netlify Forms**:
   ```html
   <form name="contact" netlify>
   ```

3. **Backend próprio**: Configure endpoint para processar dados

## 📋 Checklist de Deploy

- [ ] Testar localmente
- [ ] Verificar responsividade
- [ ] Configurar domínio
- [ ] Configurar SSL
- [ ] Configurar formulário
- [ ] Adicionar Analytics
- [ ] Testar performance
- [ ] Configurar redirects se necessário

## 🔍 Monitoramento

- Configure alertas de uptime
- Monitore performance com PageSpeed Insights
- Verifique SEO com ferramentas apropriadas

