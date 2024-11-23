document.addEventListener("DOMContentLoaded", () => {
    const filters = {
        pais: "",
        habilidad: "",
        nombre: "",
    };

    const modal = document.getElementById("projectModal");
    const closeButton = modal.querySelector(".project-close-button");
    const closeMainButton = document.getElementById("close-modal");
    const modalTitle = document.getElementById("modal-title");
    const modalDescription = document.getElementById("modal-description");
    const modalPais = document.getElementById("modal-pais");
    const modalHabilidades = document.getElementById("modal-habilidades");
    const modalUsuarios = document.getElementById("modal-usuarios");
    const prevProjectButton = document.getElementById("prev-project");
    const nextProjectButton = document.getElementById("next-project");

    let currentIndex = 0;
    let projects = [];

    async function fetchProjects() {
        try {
            const response = await fetch("php/fetch_filtered_projects.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(filters),
            });
            const data = await response.json();

            // Actualizar la lista de proyectos
            renderProjects(data);
            projects = data; // Guardar proyectos para el modal
        } catch (error) {
            console.error("Error fetching projects:", error);
        }
    }

    function renderProjects(data) {
        const projectList = document.querySelector(".projects-list .row");
        projectList.innerHTML = ""; // Limpiar proyectos anteriores

        if (data.length === 0) {
            projectList.innerHTML = "<p>No se encontraron proyectos.</p>";
            return;
        }

        data.forEach((project, index) => {
            const card = document.createElement("div");
            card.classList.add("col-md-4");
            card.innerHTML = `
                <div class="card project-card" data-index="${index}">
                    <div class="card-body">
                        <h5 class="card-title">${project.nombre}</h5>
                        <p class="card-text">
                            <strong>Usuario Principal:</strong> ${project.creador_usuario}<br>
                            <strong>Descripción:</strong> ${project.descripcion}
                        </p>
                        <button class="btn btn-info project-btn-detalle" data-id="${project.id}" data-index="${index}">
                            Ver Detalles
                        </button>
                        <button class="btn btn-success project-btn-match" data-id="<?php echo $proyecto['id']; ?>">Match</button>
                    </div>
                </div>
            `;
            projectList.appendChild(card);
        });

        attachModalListeners();
        attachMatchListeners();
    }

    function attachModalListeners() {
        document.querySelectorAll(".project-btn-detalle").forEach((btn) => {
            btn.addEventListener("click", (e) => {
                const index = parseInt(btn.dataset.index, 10);
                openModal(index);
            });
        });
    }

    function attachMatchListeners() {
        document.querySelectorAll(".project-btn-match").forEach((btn) => {
            btn.addEventListener("click", async (e) => {
                const projectId = btn.dataset.id;
                try {
                    const response = await fetch("php/join_project.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify({ project_id: projectId }),
                    });
                    const result = await response.json();
                    if (result.success) {
                        alert("Te has unido al proyecto exitosamente.");
                        fetchProjects(); // Actualizar lista de proyectos
                    } else {
                        alert("Error al unirse al proyecto.");
                    }
                } catch (error) {
                    console.error("Error joining project:", error);
                }
            });
        });
    }

    function openModal(index) {
        currentIndex = index;
        updateModal(currentIndex);
        modal.style.display = "block";
    }

    function updateModal(index) {
        const projectId = projects[index].id;
    
        fetch(`php/fetch_project_details.php?id=${projectId}`)
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Error al recuperar los detalles del proyecto");
                }
                return response.json();
            })
            .then((data) => {
                if (data.error) {
                    alert(data.error);
                    return;
                }
    
                const project = data.project;
                const habilidades = data.habilidades || [];
                const usuarios = data.usuarios || [];
    
                // Actualizar datos del modal
                modalTitle.textContent = project.nombre || "Sin título";
                modalDescription.textContent = project.descripcion || "Sin descripción disponible.";
                modalPais.textContent = `País: ${project.pais || "No especificado"}`;
    
                // Mostrar habilidades
                modalHabilidades.innerHTML = "<strong>Habilidades Requeridas:</strong><ul>";
                habilidades.forEach((habilidad) => {
                    modalHabilidades.innerHTML += `<li>${habilidad}</li>`;
                });
                modalHabilidades.innerHTML += "</ul>";
    
                // Mostrar usuarios
                modalUsuarios.innerHTML = "<strong>Usuarios del Proyecto:</strong><ul>";
                usuarios.forEach((usuario) => {
                    modalUsuarios.innerHTML += `<li>${usuario}</li>`;
                });
                modalUsuarios.innerHTML += "</ul>";
    
                // Botón Match
                const matchButton = document.getElementById("match-project");
                matchButton.onclick = () => joinProject(project.id);
    
                modal.style.display = "block";
            })
            .catch((error) => {
                console.error("Error:", error);
                alert("Hubo un problema al cargar los detalles del proyecto.");
            });
    }
    
    // Función para unirse al proyecto
    function joinProject(projectId) {
        fetch(`php/join_project.php`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ project_id: projectId }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    alert("¡Te has unido al proyecto con éxito!");
                    modal.style.display = "none";
                    // Opcional: Recargar la página o actualizar la lista de proyectos
                    location.reload();
                } else {
                    alert(data.error || "Hubo un problema al unirse al proyecto.");
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                alert("Hubo un problema al procesar tu solicitud.");
            });
    }
    
    

    prevProjectButton.addEventListener("click", () => {
        currentIndex = (currentIndex - 1 + projects.length) % projects.length;
        updateModal(currentIndex);
    });

    nextProjectButton.addEventListener("click", () => {
        currentIndex = (currentIndex + 1) % projects.length;
        updateModal(currentIndex);
    });

    closeButton.addEventListener("click", () => (modal.style.display = "none"));
    closeMainButton.addEventListener("click", () => (modal.style.display = "none"));

    // Filtrar proyectos al enviar el formulario
    document.getElementById("filter-form").addEventListener("submit", (e) => {
        e.preventDefault();
        filters.pais = document.getElementById("filter-project-country").value;
        filters.habilidad = document.getElementById("filter-project-skill").value;
        filters.nombre = document.getElementById("filter-project-name").value;
        fetchProjects();
    });

    // Cargar proyectos al inicio
    fetchProjects();
});
