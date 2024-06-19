import Swal from "sweetalert2";

(() => {
	// Array para almacenar los eventos
	let eventos = [];
	// Selección del contenedor del resumen
	const resumen = document.querySelector("#registro-resumen");

	if (resumen) {
		const submitFormulario = (e) => {
			e.preventDefault();

			// Obtener el regalo
			const regaloId = document.querySelector("#regalo").value;
			const eventosId = eventos.map((evento) => evento.id);

			// Validacion
			if (eventosId.length === 0 || regaloId === "") {
				Swal.fire({
					title: "Error",
					text: "Elige al menos un Evento y un Regalo",
					icon: "error",
					confirmButtonText: "OK",
				});
				return;
			}

			console.log("Registrando...");
		};

		const formularioRegistro = document.querySelector("#registro");
		formularioRegistro.addEventListener("submit", submitFormulario);

		// Función para limpiar todos los eventos del DOM
		const limpiarEventos = () => {
			while (resumen.firstChild) {
				resumen.removeChild(resumen.firstChild);
			}
		};

		// Función para eliminar un evento por ID
		const eliminarEvento = (id) => {
			eventos = eventos.filter((evento) => evento.id !== id);
			const botonAgregar = document.querySelector(`[data-id="${id}"]`);
			botonAgregar.disabled = false;

			mostrarEventos();
		};

		// Función para crear el DOM de un evento
		const crearEventoDOM = (evento) => {
			const eventoDOM = document.createElement("div");
			eventoDOM.classList.add("registro__evento");

			const titulo = document.createElement("h3");
			titulo.classList.add("registro__nombre");
			titulo.textContent = evento.titulo;

			const botonEliminar = document.createElement("button");
			botonEliminar.classList.add("registro__eliminar");
			botonEliminar.innerHTML = '<i class="fa-solid fa-trash"></i>';
			botonEliminar.dataset.id = evento.id; // Agregar el ID al botón

			// Añadir elementos al contenedor del evento
			eventoDOM.appendChild(titulo);
			eventoDOM.appendChild(botonEliminar);

			return eventoDOM;
		};

		// Función para mostrar los eventos en el DOM
		const mostrarEventos = () => {
			limpiarEventos();

			if (eventos.length > 0) {
				eventos.forEach((evento) => {
					const eventoDOM = crearEventoDOM(evento);
					resumen.appendChild(eventoDOM);
				});
			}
		};

		// Función para manejar la selección de un evento
		const seleccionarEvento = (target) => {
			if (eventos.length < 5) {
				target.disabled = true;
				const nuevoEvento = {
					id: target.dataset.id,
					titulo: target
						.closest(".evento")
						.querySelector(".evento__nombre")
						.textContent.trim(),
				};

				eventos = [...eventos, nuevoEvento];

				mostrarEventos();
			} else {
				Swal.fire({
					title: "Error",
					text: "Máximo 5 eventos por registro",
					icon: "error",
					confirmButtonText: "OK",
				});
			}
		};

		// Delegar el evento de clic para añadir eventos
		document.addEventListener("click", (e) => {
			if (e.target.classList.contains("evento__agregar")) {
				seleccionarEvento(e.target);
			} else if (e.target.closest(".registro__eliminar")) {
				const id = e.target.closest(".registro__eliminar").dataset.id;
				eliminarEvento(id);
			}
		});
	}
})();
