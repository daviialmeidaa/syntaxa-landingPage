function corrigirDepoimentos() {
    // console.log('🔧 Iniciando correção dos depoimentos...');
    
    // Selecionar elementos
    const testimonialCards = document.querySelectorAll('.testimonial__card');
    const nextBtn = document.querySelector('#testimonials-next, .testimonials__next');
    const prevBtn = document.querySelector('#testimonials-prev, .testimonials__prev');
    
    if (testimonialCards.length === 0) {
        // console.log('❌ Nenhum card de depoimento encontrado');
        return;
    }
    
    // console.log(`✅ Encontrados ${testimonialCards.length} depoimentos`);
    
    let currentIndex = 0;
    
    // Função para mostrar um depoimento específico
    function mostrarDepoimento(index) {
        // Ocultar todos os cards
        testimonialCards.forEach((card, i) => {
            card.style.display = 'none';
            card.classList.remove('active');
        });
        
        // Mostrar o card atual
        if (testimonialCards[index]) {
            testimonialCards[index].style.display = 'block';
            testimonialCards[index].classList.add('active');
            // console.log(`📄 Mostrando depoimento ${index + 1}`);
        }
    }
    
    // Função para próximo depoimento
    function proximoDepoimento() {
        currentIndex = (currentIndex + 1) % testimonialCards.length;
        mostrarDepoimento(currentIndex);
    }
    
    // Função para depoimento anterior
    function depoimentoAnterior() {
        currentIndex = (currentIndex - 1 + testimonialCards.length) % testimonialCards.length;
        mostrarDepoimento(currentIndex);
    }
    
    // Remover event listeners antigos e adicionar novos
    if (nextBtn) {
        nextBtn.replaceWith(nextBtn.cloneNode(true));
        const newNextBtn = document.querySelector('#testimonials-next, .testimonials__next');
        newNextBtn.addEventListener('click', proximoDepoimento);
        // console.log('✅ Botão próximo configurado');
    }
    
    if (prevBtn) {
        prevBtn.replaceWith(prevBtn.cloneNode(true));
        const newPrevBtn = document.querySelector('#testimonials-prev, .testimonials__prev');
        newPrevBtn.addEventListener('click', depoimentoAnterior);
        // console.log('✅ Botão anterior configurado');
    }
    
    // Mostrar o primeiro depoimento
    mostrarDepoimento(0);
    
    // console.log('🎉 Correção dos depoimentos concluída!');
    
    // Retornar funções para uso externo
    return {
        mostrarDepoimento,
        proximoDepoimento,
        depoimentoAnterior,
        totalDepoimentos: testimonialCards.length
    };
}

// Executar a correção quando o DOM estiver pronto
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', corrigirDepoimentos);
} else {
    corrigirDepoimentos();
}

// Também disponibilizar globalmente para uso manual
window.corrigirDepoimentos = corrigirDepoimentos;
