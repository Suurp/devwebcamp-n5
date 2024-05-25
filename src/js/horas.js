(() => {
	const horas = document.querySelector("#horas");

	if (horas) {
		let busqueda = {
			categoria_id: "",
			dia: "",
		};

		const categoria = document.querySelector("#categoria");
		const dias = document.querySelectorAll('[name="dia"]');
		const inputHiddenDia = document.querySelector('[name="dia_id"]');
		const inputHiddenHora = document.querySelector('[name="hora_id"]');

		const seleccionarHora = (e) => {
			const horaPrevia = document.querySelector(
				".horas__hora--seleccionada"
			);

			if (horaPrevia) {
				horaPrevia.classList.remove("horas__hora--seleccionada");
			}

			// Agregar clase de seleccionado
			e.target.classList.add("horas__hora--seleccionada");

			inputHiddenHora.value = e.target.dataset.horaId;

			// Llenar campo oculto de dia
			inputHiddenDia.value = document.querySelector(
				'[name="dia"]:checked'
			).value;
		};

		const obtenerHorasDisponibles = (eventos) => {
			//Reiniciar las horas
			const listadoHoras = document.querySelectorAll("#horas li");
			listadoHoras.forEach((li) =>
				li.classList.add("horas__hora--deshabilitada")
			);
            
            const horasDeshabilitadas = document.querySelectorAll("#horas li");
			horasDeshabilitadas.forEach((hora) =>
				hora.removeEventListener("click", seleccionarHora)
			);

			// Comprobar eventos ya tomados y quitar la variable de deshabilitado
			const horasTomadas = eventos.map((evento) => evento.hora_id);

			const listadoHorasArray = Array.from(listadoHoras);

			const resultado = listadoHorasArray.filter(
				(li) => !horasTomadas.includes(li.dataset.horaId)
			);
			resultado.forEach((li) =>
				li.classList.remove("horas__hora--deshabilitada")
			);

			const horasDisponibles = document.querySelectorAll(
				"#horas li:not(.horas__hora--deshabilitada)"
			);
			horasDisponibles.forEach((hora) => {
				hora.addEventListener("click", seleccionarHora);
			});
		};

		const buscarEventos = async () => {
			const { dia, categoria_id } = busqueda;

			const url = `/api/eventos-horario?dia_id=${dia}&categoria_id=${categoria_id}`;

			const resultado = await fetch(url);
			const eventos = await resultado.json();

			obtenerHorasDisponibles(eventos);
		};

		const terminoBusqueda = (e) => {
			busqueda[e.target.name] = e.target.value;

			// Reiniciar los campos ocultos y el selector de horas
			inputHiddenHora.value = "";
			inputHiddenDia.value = "";

			const horaPrevia = document.querySelector(
				".horas__hora--seleccionada"
			);

			if (horaPrevia) {
				horaPrevia.classList.remove("horas__hora--seleccionada");
			}

			if (Object.values(busqueda).includes("")) {
				return;
			}

			buscarEventos();
		};

		categoria.addEventListener("change", terminoBusqueda);

		dias.forEach((dia) => {
			dia.addEventListener("change", terminoBusqueda);
		});
	}
})();
