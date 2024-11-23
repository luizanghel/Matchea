document.addEventListener("DOMContentLoaded", () => {
    const filters = { pais: "", habilidad: "", nombre: "" };

    const modal = document.getElementById("projectModal");
    const closeButton = modal.querySelector(".project-close-button");
    const closeMainButton = document.getElementById("close-modal");
    const modalTitle = document.getElementById("modal-title");
    const modalDescription = document.getElementById("modal-description");
    const modalPais = document.getElementById("modal-pais");
    const modalHabilidades = document.getElementById("modal-habilidades");
    const modalUsuarios = document.getElementById("modal-usuarios");
    const matchButton = document.getElementById("match-project");
    const prevProjectButton = document.getElementById("prev-project");
    const nextProjectButton = document.getElementById("next-project");

    let currentIndex = 0;
    let projects = [];

    async function fetchProjects() {
        try {
            const response = await fetch("php/fetch_filtered_projects.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(filters),
            });
            const data = await response.json();
            renderProjects(data);
            projects = data;
        } catch (error) {
            console.error("Error fetching projects:", error);
        }
    }

    function renderProjects(data) {
        const projectList = document.querySelector(".projects-list .row");
        projectList.innerHTML = "";

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
                        <button class="btn btn-info project-btn-detalle" data-id="${project.id}" data-index="${index}">Ver Detalles</button>
                        <button class="btn btn-success project-btn-match" data-id="${project.id}">Match</button>
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
            btn.addEventListener("click", () => {
                const index = parseInt(btn.dataset.index, 10);
                openModal(index);
            });
        });
    }

    function attachMatchListeners() {
        document.querySelectorAll(".project-btn-match").forEach((btn) => {
            btn.addEventListener("click", async () => {
                const projectId = btn.dataset.id;
                try {
                    const response = await fetch("php/join_project.php", {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ project_id: projectId }),
                    });
                    const result = await response.json();
                    if (result.success) {
                        alert("¡Te has unido al proyecto con éxito!");
                        fetchProjects();
                    } else {
                        alert(result.message || "Error al unirse al proyecto.");
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
    }

    function updateModal(index) {
        const projectId = projects[index].id;

        fetch(`php/fetch_project_details.php?id=${projectId}`)
            .then((response) => response.json())
            .then((data) => {
                modalTitle.textContent = data.project.nombre || "Sin título";
                modalDescription.textContent = data.project.descripcion || "Sin descripción.";
                modalPais.textContent = `País: ${data.project.pais || "No especificado"}`;
                modalHabilidades.innerHTML = data.habilidades.map(h => `<li>${h}</li>`).join("");
                modalUsuarios.innerHTML = data.usuarios.map(u => `<li>${u}</li>`).join("");
                matchButton.onclick = () => joinProject(data.project.id);
                modal.style.display = "block";
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

    document.getElementById("filter-form").addEventListener("submit", (e) => {
        e.preventDefault();
        filters.pais = document.getElementById("filter-project-country").value;
        filters.habilidad = document.getElementById("filter-project-skill").value;
        filters.nombre = document.getElementById("filter-project-name").value;
        fetchProjects();
    });

    fetchProjects();
});
