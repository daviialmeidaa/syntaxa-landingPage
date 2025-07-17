# Syntaxa - Landing Page

Landing page moderna e responsiva para a empresa Syntaxa, desenvolvida com HTML5, CSS3 e JavaScript vanilla.

## 🚀 Sobre o Projeto

Esta landing page foi criada para apresentar a empresa Syntaxa, uma empresa de desenvolvimento de software especializada em soluções digitais sob medida, automação e inteligência artificial.

### ✨ Características

- **Design Moderno**: Interface limpa e profissional com a identidade visual da Syntaxa
- **Responsivo**: Adaptável a todos os dispositivos (desktop, tablet, mobile)
- **Performance**: Otimizado para carregamento rápido
- **Interativo**: Animações suaves e navegação fluida
- **SEO Friendly**: Estrutura semântica otimizada para motores de busca

## 📁 Estrutura do Projeto

```
syntaxa-landing/
├── index.html              # Página principal
├── assets/
│   ├── css/
│   │   ├── style.css       # Estilos principais
│   │   └── responsive.css  # Estilos responsivos
│   ├── js/
│   │   └── main.js         # Funcionalidades JavaScript
│   └── images/
│       └── logo-syntaxa.png # Logo da empresa
└── README.md               # Documentação
```

## 🎨 Seções da Landing Page

1. **Header/Navegação**: Menu fixo com navegação suave
2. **Hero**: Seção principal com call-to-action
3. **Sobre**: Visão, missão e valores da empresa
4. **Serviços**: 6 serviços principais oferecidos
5. **Depoimentos**: Carousel com depoimentos de clientes
6. **Contato**: Formulário e informações de contato
7. **Footer**: Informações adicionais e links

## 🛠️ Tecnologias Utilizadas

- **HTML5**: Estrutura semântica
- **CSS3**: Estilos modernos com Flexbox e Grid
- **JavaScript**: Funcionalidades interativas
- **Font Awesome**: Ícones (via CDN)
- **Google Fonts**: Tipografia Poppins

## 🚀 Como Usar

### 1. Teste Local

Para testar localmente, execute um servidor HTTP simples:

```bash
# Navegue até o diretório do projeto
cd syntaxa-landing

# Inicie um servidor local (Python)
python3 -m http.server 8000

# Ou use Node.js
npx http-server

# Acesse no navegador
http://localhost:8000
```

### 2. Deploy

Para fazer deploy em produção:

1. **Hospedagem Estática**: Upload dos arquivos para qualquer serviço de hospedagem (Netlify, Vercel, GitHub Pages, etc.)
2. **Servidor Web**: Configure seu servidor web (Apache, Nginx) para servir os arquivos
3. **CDN**: Para melhor performance, use um CDN para servir os assets

### 3. Personalização

#### Cores da Marca
As cores principais estão definidas no arquivo `assets/css/style.css`:

```css
:root {
    --primary-color: #1E88E5;
    --secondary-color: #42A5F5;
    --accent-color: #0D47A1;
    /* ... */
}
```

#### Conteúdo
- Edite o arquivo `index.html` para alterar textos e conteúdo
- Substitua `assets/images/logo-syntaxa.png` pela sua logo
- Modifique os depoimentos na seção correspondente

#### Formulário de Contato
O formulário está configurado para envio via JavaScript. Para funcionalidade completa:

1. Configure um backend para processar os dados
2. Ou use serviços como Formspree, Netlify Forms, etc.
3. Atualize a função `handleSubmit()` em `assets/js/main.js`

## 📱 Responsividade

A landing page é totalmente responsiva com breakpoints:

- **Mobile**: < 768px
- **Tablet**: 768px - 1024px  
- **Desktop**: > 1024px

## ⚡ Performance

- Imagens otimizadas
- CSS e JS minificados (recomendado para produção)
- Carregamento assíncrono de recursos externos
- Lazy loading implementado onde necessário

## 🎯 Funcionalidades

- ✅ Navegação suave entre seções
- ✅ Animações on scroll
- ✅ Carousel de depoimentos
- ✅ Formulário de contato funcional
- ✅ Menu responsivo
- ✅ Efeitos hover interativos

## 📞 Suporte

Para dúvidas ou suporte técnico, entre em contato:

- **Email**: contato@syntaxa.com.br
- **Website**: www.syntaxa.com.br
- **Telefone**: +55 (11) 9999-9999

## 📄 Licença

Este projeto foi desenvolvido especificamente para a Syntaxa. Todos os direitos reservados.

---

**Desenvolvido com ❤️ para a Syntaxa por Davi Almeida**

