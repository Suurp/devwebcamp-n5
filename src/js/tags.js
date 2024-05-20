(() => {
    // Selecciona el input donde se escribirán las etiquetas
    const tagsInput = document.querySelector("#tags_input");

    // Si no existe el input, no continúa con la ejecución
    if (!tagsInput) return;

    // Selecciona el contenedor donde se mostrarán las etiquetas
    const tagsDiv = document.querySelector("#tags");
    // Selecciona el input oculto para almacenar las etiquetas en formato de texto
    const tagsInputHidden = document.querySelector("[name='tags']");
    // Inicializa el array para almacenar las etiquetas
    let tags = [];

    // Función para guardar la etiqueta cuando se presiona la coma
    const guardarTag = (e) => {
        // Verifica si la tecla presionada es la coma y si el valor del input no está vacío
        if (e.key === ',' && e.target.value.trim() !== "") {
            e.preventDefault(); // Previene el comportamiento por defecto de la tecla

            const newTag = e.target.value.trim();

            // Verifica si la etiqueta ya existe
            if (!tags.includes(newTag)) {
                // Agrega la etiqueta al array de etiquetas
                tags = [...tags, newTag];
                // Limpia el valor del input
                e.target.value = '';
                // Muestra las etiquetas actualizadas
                mostrarTags();
            } else {
                // Opcional: informar al usuario que la etiqueta ya existe
                e.target.value = '';
            }
        }
    };

    // Función para mostrar las etiquetas en el contenedor
    const mostrarTags = () => {
        tagsDiv.textContent = ""; // Limpia el contenido del contenedor

        // Crea y añade cada etiqueta al contenedor
        tags.forEach(tag => {
            const etiqueta = document.createElement('LI'); // Crea un elemento de lista
            etiqueta.classList.add('formulario__tag'); // Añade una clase CSS
            etiqueta.textContent = tag; // Establece el texto de la etiqueta
            etiqueta.ondblclick = eliminarTag; // Asigna el evento de doble clic para eliminar la etiqueta
            etiqueta.ontouchend = eliminarTag; // Asigna el evento de finalización de toque para eliminar la etiqueta en móviles
            tagsDiv.appendChild(etiqueta); // Añade la etiqueta al contenedor
        });

        // Actualiza el valor del input oculto con las etiquetas en formato de texto
        actualizarInputHidden();
    };

    // Función para actualizar el valor del input oculto
    const actualizarInputHidden = () => {
        tagsInputHidden.value = tags.join(','); // Convierte el array de etiquetas en una cadena
    };

    // Función para eliminar una etiqueta al hacer doble clic o al finalizar el toque en móviles
    const eliminarTag = (e) => {
        const tagToRemove = e.target.textContent; // Obtiene el texto de la etiqueta a eliminar
        // Filtra el array de etiquetas para eliminar la etiqueta seleccionada
        tags = tags.filter(tag => tag !== tagToRemove);
        // Muestra las etiquetas actualizadas
        mostrarTags();
    };

    // Añade el evento de escucha al input para detectar la tecla presionada
    tagsInput.addEventListener("keypress", guardarTag);
})();
