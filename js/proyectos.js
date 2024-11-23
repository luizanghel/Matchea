document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("projectModal");
    const closeButton = modal.querySelector(".project-close-button");
    const closeMainButton = document.getElementById("close-modal");
    const matchButton = document.getElementById("modal-match");
    const modalTitle = document.getElementById("modal-title");
    const modalDescription = document.getElementById("modal-description");
    const modalPais = document.getElementById("modal-pais");
    const modalHabilidades = document.getElementById("modal-habilidades");
    const modalUsuarios = document.getElementById("modal-usuarios");
    const prevProjectButton = document.getElementById("prev-project");
    const nextProjectButton = document.getElementById("next-project");
    

    let currentIndex = 0;
    const projects = Array.from(document.querySelectorAll(".project-btn-detalle"));
    let currentProjectId = null;

    function updateModal(index) {
        currentProjectId = projects[index].dataset.id;

        fetch(`php/fetch_project_details.php?id=${currentProjectId}`)
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Error al recuperar los detalles del proyecto");
                }
                return response.json();
            })
            .then((data) => {
                modalTitle.textContent = data.nombre || "Sin título";
                modalDescription.textContent = data.descripcion || "Sin descripción disponible.";
                modalPais.textContent = `País: ${data.pais || "Sin información"}`;
                modalHabilidades.innerHTML = `
                    <strong>Habilidades requeridas:</strong>
                    <ul>${data.habilidades.map(h => `<li>${h}</li>`).join('')}</ul>
                `;
                modalUsuarios.innerHTML = `
                    <strong>Usuarios inscritos:</strong>
                    <ul>${data.usuarios.map(u => `<li>${u}</li>`).join('')}</ul>
                `;
                modal.style.display = "block";
            })
            .catch((error) => {
                console.error("Error:", error);
                alert("Hubo un problema al cargar los detalles del proyecto.");
            });
    }

    function joinProject(projectId) {
        fetch("php/join_project.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ proyecto_id: projectId }),
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Error al unirse al proyecto");
                }
                return response.json();
            })
            .then((data) => {
                if (data.success) {
                    alert(data.message);
                    location.reload(); // Recargar la página para actualizar el listado
                } else {
                    alert(data.message || "No se pudo unir al proyecto");
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                alert("Error al unirse al proyecto.");
            });
    }    
    

    projects.forEach((btn, index) => {
        btn.addEventListener("click", () => {
            currentIndex = index;
            updateModal(currentIndex);
        });
    });

    matchButton.addEventListener("click", () => {
        if (currentProjectId) {
            joinProject(currentProjectId);
        }
    });

    document.querySelectorAll(".project-btn-match").forEach((btn) => {
        btn.addEventListener("click", (event) => {
            const projectId = event.target.dataset.id;
            joinProject(projectId);
        });
    });

    closeButton.addEventListener("click", () => (modal.style.display = "none"));
    closeMainButton.addEventListener("click", () => (modal.style.display = "none"));

    prevProjectButton.addEventListener("click", () => {
        currentIndex = (currentIndex - 1 + projects.length) % projects.length;
        updateModal(currentIndex);
    });

    nextProjectButton.addEventListener("click", () => {
        currentIndex = (currentIndex + 1) % projects.length;
        updateModal(currentIndex);
    });
    
    // Cierra el modal al hacer clic fuera de su contenido
    window.addEventListener("click", (event) => {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });
});
