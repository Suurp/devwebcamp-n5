(() => {
	// Referencias a elementos del DOM
	const ponentesInput = document.querySelector("#ponentes");
	const ponenteHidden = document.querySelector('[name="ponente_id"]');

	/**
	 * Maneja la selección de un ponente en la lista.
	 * @param {Event} e - El evento de clic en un ponente.
	 */
	const seleccionarPonente = (e) => {
		// Establece el valor del input con el nombre del ponente seleccionado
		ponentesInput.value = e.target.textContent;
		const ponente = e.target;

		// Remueve la clase de selección previa
		const ponentePrevio = document.querySelector(
			".listado-ponentes__ponente--seleccionado"
		);
		if (ponentePrevio) {
			ponentePrevio.classList.remove(
				"listado-ponentes__ponente--seleccionado"
			);
		}

		// Añade la clase de seleccionado al nuevo ponente y actualiza el valor oculto
		ponente.classList.add("listado-ponentes__ponente--seleccionado");
		ponenteHidden.value = ponente.dataset.ponenteId;
	};

	/**
	 * Muestra los ponentes filtrados en la lista.
	 */
	const mostrarPonentes = () => {
		const listadoPonentes = document.querySelector("#listado-ponentes");
		listadoPonentes.innerHTML = ""; // Limpiar lista de ponentes

		if (ponentesFiltrados.length > 0) {
			// Crear elementos LI para cada ponente filtrado
			ponentesFiltrados.forEach((ponente) => {
				const ponenteHTML = document.createElement("LI");
				ponenteHTML.classList.add("listado-ponentes__ponente");
				ponenteHTML.textContent = ponente.nombre;
				ponenteHTML.dataset.ponenteId = ponente.id;
				ponenteHTML.addEventListener("click", seleccionarPonente);
				listadoPonentes.appendChild(ponenteHTML);
			});
		} else if (ponentesInput.value.length >= 3) {
			// Mostrar mensaje de "no resultados" si no hay coincidencias
			const noResultados = document.createElement("P");
			noResultados.classList.add("listado-ponentes__no-resultados");
			noResultados.textContent = "No hay resultados para tu búsqueda";
			listadoPonentes.appendChild(noResultados);
		}

		// Limpiar el valor oculto
		ponenteHidden.value = "";
	};

	/**
	 * Filtra los ponentes según el valor del input.
	 * @param {Event} e - El evento de entrada en el input.
	 */
	const buscarPonentes = (e) => {
		const busqueda = e.target.value;
		if (busqueda.length > 3) {
			// Normalizar y crear expresión regular para la búsqueda
			const expresion = new RegExp(
				busqueda.normalize("NFD").replace(/[\u0300-\u036f]/g, ""),
				"i"
			);
			ponentesFiltrados = ponentes.filter((ponente) => {
				const ponenteNombre = ponente.nombre
					.normalize("NFD")
					.replace(/[\u0300-\u036f]/g, "")
					.toLowerCase();
				return expresion.test(ponenteNombre);
			});
		} else {
			ponentesFiltrados = [];
		}

		// Mostrar los resultados filtrados
		mostrarPonentes();
	};

	/**
	 * Formatea los datos de los ponentes para su uso en el script.
	 * @param {Array} arrayPonentes - Array de objetos con datos de los ponentes.
	 */
	const formatearPonentes = (arrayPonentes = []) => {
		ponentes = arrayPonentes.map((ponente) => ({
			nombre: `${ponente.nombre} ${ponente.apellido}`,
			id: ponente.id,
		}));
	};

	/**
	 * Obtiene los datos de los ponentes desde la API.
	 */
	const obtenerPonentes = async () => {
		const url = `/api/ponentes`;

		try {
			const respuesta = await fetch(url);
			const resultado = await respuesta.json();
			formatearPonentes(resultado);
		} catch (error) {
			console.error("Error al obtener los ponentes:", error);
		}
	};

	// Inicializa la funcionalidad si el input de ponentes existe
	if (ponentesInput) {
		let ponentes = [];
		let ponentesFiltrados = [];

		obtenerPonentes();
		ponentesInput.addEventListener("input", buscarPonentes);
	}
})();
