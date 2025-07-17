document.addEventListener("DOMContentLoaded", function () {
  console.log("DOM carregado. Iniciando scripts da Syntaxa com SweetAlert2.");

  // ===== SELETORES DE ELEMENTOS =====
  const navMenu = document.getElementById("nav-menu");
  const navToggle = document.getElementById("nav-toggle");
  const navClose = document.getElementById("nav-close");
  const navLinks = document.querySelectorAll(".nav__link");
  const header = document.getElementById("header");
  const scrollTopBtn = document.getElementById("scroll-top");
  const contactForm = document.getElementById("contact-form");

  // ===== MENU MOBILE =====
  if (navToggle) {
    navToggle.addEventListener("click", () =>
      navMenu.classList.add("show-menu")
    );
  }
  if (navClose) {
    navClose.addEventListener("click", () =>
      navMenu.classList.remove("show-menu")
    );
  }
  navLinks.forEach((link) => {
    link.addEventListener("click", () => navMenu.classList.remove("show-menu"));
  });

  // ===== HEADER E SCROLL =====
  function handleScroll() {
    header.classList.toggle("scroll-header", window.scrollY >= 80);
    scrollTopBtn.classList.toggle("show", window.scrollY >= 560);
    const scrollY = window.pageYOffset;
    document.querySelectorAll("section[id]").forEach((section) => {
      const sectionHeight = section.offsetHeight;
      const sectionTop = section.offsetTop - 150;
      const sectionId = section.getAttribute("id");
      const link = document.querySelector(`.nav__link[href*="${sectionId}"]`);
      if (link) {
        link.classList.toggle(
          "active-link",
          scrollY > sectionTop && scrollY <= sectionTop + sectionHeight
        );
      }
    });
  }
  window.addEventListener("scroll", handleScroll);
  if (scrollTopBtn) {
    scrollTopBtn.addEventListener("click", () =>
      window.scrollTo({ top: 0, behavior: "smooth" })
    );
  }

  // ===== FORMULÁRIO DE CONTATO COM SWEETALERT2 =====
  async function handleContactForm(e) {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);
    const submitButton = form.querySelector(".form__submit");
    const originalText = submitButton.innerHTML;

    if (
      !formData.get("name") ||
      !formData.get("email") ||
      !formData.get("message")
    ) {
      Swal.fire({
        icon: "warning",
        title: "Oops...",
        text: "Por favor, preencha todos os campos obrigatórios!",
        confirmButtonColor: "#1E7FFF",
      });
      return;
    }

    submitButton.innerHTML =
      '<i class="fas fa-spinner fa-spin"></i> Enviando...';
    submitButton.disabled = true;

    try {
      const response = await fetch("enviar-email.php", {
        method: "POST",
        body: formData,
      });

      const result = await response.json();

      if (response.ok && result.status === "success") {
        Swal.fire({
          icon: "success",
          title: "Enviado com Sucesso!",
          text: "Sua mensagem foi recebida. Entraremos em contato em breve.",
          confirmButtonColor: "#1E7FFF",
        });
        form.reset();
      } else {
        throw new Error(
          result.message || "Ocorreu um erro desconhecido no servidor."
        );
      }
    } catch (error) {
      console.error("Falha no envio do formulário:", error);
      Swal.fire({
        icon: "error",
        title: "Erro no Envio",
        text: `Não foi possível enviar sua mensagem. Por favor, tente novamente.`,
        confirmButtonColor: "#1E7FFF",
      });
    } finally {
      submitButton.innerHTML = originalText;
      submitButton.disabled = false;
    }
  }

  if (contactForm) {
    contactForm.addEventListener("submit", handleContactForm);
  }
});
