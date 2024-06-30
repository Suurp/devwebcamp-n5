import Swal from "sweetalert2";

(() => {
	// Array para almacenar los eventos
	let eventos = [];
	// Selección del contenedor del resumen
	const resumen = document.querySelector("#registro-resumen");

	if (resumen) {
		const submitFormulario = async (e) => {
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

			// Objeto de formdata
			const datos = new FormData();
			datos.append("eventos", eventosId);
			datos.append("regalo_id", regaloId);

			const url = "/finalizar-registro/conferencias";
			const respuesta = await fetch(url, {
				method: "POST",
				body: datos,
			});
			const resultado = await respuesta.json();

			if (resultado.resultado) {
				Swal.fire(
					"Registro Exitoso",
					"Tus conferencias se han almacenado y tu registro fue exito, te esperamos en DevWebCamp",
					"success"
				).then(() => (location.href = `/boleto?id=${resultado.token}`));
			} else {
				Swal.fire({
					title: "Error",
					text: "Hubo un error",
					icon: "error",
					confirmButtonText: "OK",
				}).then(() => location.reload());
			}
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
			} else {
				const noRegistro = document.createElement("P");
				noRegistro.textContent =
					"No hay eventos, añade hasta 5 del lado izquierdo";
				noRegistro.classList.add("registro__texto");
				resumen.appendChild(noRegistro);
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

		mostrarEventos();
	}
})();
