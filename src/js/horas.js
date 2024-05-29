(() => {
	// Referencias a elementos del DOM
	const horas = document.querySelector("#horas");

	if (horas) {
		const categoria = document.querySelector("#categoria");
		const dias = document.querySelectorAll('[name="dia"]');
		const inputHiddenDia = document.querySelector('[name="dia_id"]');
		const inputHiddenHora = document.querySelector('[name="hora_id"]');

		// Objeto para almacenar la búsqueda actual
		let busqueda = {
			categoria_id: +categoria.value || "", // Convertir a número o usar cadena vacía
			dia: +inputHiddenDia.value || "", // Convertir a número o usar cadena vacía
		};

		/**
		 * Maneja la selección de una hora en la lista.
		 * @param {Event} e - El evento de clic en una hora.
		 */
		const seleccionarHora = (e) => {
			// Remover clase de hora previamente seleccionada
			const horaPrevia = document.querySelector(
				".horas__hora--seleccionada"
			);
			if (horaPrevia) {
				horaPrevia.classList.remove("horas__hora--seleccionada");
			}

			// Agregar clase de seleccionado a la hora actual
			e.target.classList.add("horas__hora--seleccionada");

			// Actualizar el campo oculto de hora con el ID de la hora seleccionada
			inputHiddenHora.value = e.target.dataset.horaId;

			// Llenar el campo oculto de día con el valor del día seleccionado
			inputHiddenDia.value = document.querySelector(
				'[name="dia"]:checked'
			).value;
		};

		/**
		 * Actualiza la lista de horas disponibles en base a los eventos obtenidos.
		 * @param {Array} eventos - Array de objetos con los eventos obtenidos.
		 */
		const obtenerHorasDisponibles = (eventos) => {
			// Reiniciar la lista de horas, deshabilitándolas todas inicialmente
			const listadoHoras = document.querySelectorAll("#horas li");
			listadoHoras.forEach((li) =>
				li.classList.add("horas__hora--deshabilitada")
			);

			// Remover el evento de clic de todas las horas
			listadoHoras.forEach((hora) =>
				hora.removeEventListener("click", seleccionarHora)
			);

			// Obtener los IDs de las horas que están ya ocupadas
			const horasTomadas = eventos.map((evento) => evento.hora_id);

			// Filtrar y habilitar las horas que no están ocupadas
			const resultado = Array.from(listadoHoras).filter(
				(li) => !horasTomadas.includes(li.dataset.horaId)
			);
			resultado.forEach((li) =>
				li.classList.remove("horas__hora--deshabilitada")
			);

			// Agregar el evento de clic a las horas disponibles
			const horasDisponibles = document.querySelectorAll(
				"#horas li:not(.horas__hora--deshabilitada)"
			);
			horasDisponibles.forEach((hora) => {
				hora.addEventListener("click", seleccionarHora);
			});
		};

		/**
		 * Busca eventos en el servidor según el día y categoría seleccionados.
		 */
		const buscarEventos = async () => {
			const { dia, categoria_id } = busqueda;
			const url = `/api/eventos-horario?dia_id=${dia}&categoria_id=${categoria_id}`;

			try {
				const resultado = await fetch(url);
				const eventos = await resultado.json();
				obtenerHorasDisponibles(eventos);
			} catch (error) {
				console.error("Error al obtener los eventos:", error);
			}
		};

		/**
		 * Maneja cambios en los campos de búsqueda (día y categoría).
		 * @param {Event} e - El evento de cambio en el campo de búsqueda.
		 */
		const terminoBusqueda = (e) => {
			busqueda[e.target.name] = e.target.value;

			// Reiniciar los campos ocultos y la selección de horas
			inputHiddenHora.value = "";
			inputHiddenDia.value = "";

			const horaPrevia = document.querySelector(
				".horas__hora--seleccionada"
			);
			if (horaPrevia) {
				horaPrevia.classList.remove("horas__hora--seleccionada");
			}

			// Si la búsqueda está incompleta, no hacer nada
			if (Object.values(busqueda).includes("")) {
				return;
			}

			// Buscar eventos con los nuevos criterios de búsqueda
			buscarEventos();
		};

		// Si ya hay una búsqueda completa, buscar eventos inmediatamente
		if (!Object.values(busqueda).includes("")) {
			const iniciarApp = async () => {
				await buscarEventos();

				const id = inputHiddenHora.value;

				const horaSeleccionada = document.querySelector(
					`[data-hora-id="${id}"]`
				);

				horaSeleccionada.classList.remove("horas__hora--deshabilitada");
				horaSeleccionada.classList.add("horas__hora--seleccionada");

				horaSeleccionada.onclick = seleccionarHora;
			};

			iniciarApp();
		}

		// Agregar eventos de cambio a los selectores de categoría y día
		categoria.addEventListener("change", terminoBusqueda);
		dias.forEach((dia) => {
			dia.addEventListener("change", terminoBusqueda);
		});
	}
})();
