const dropzone = document.getElementById('dropzone');
const inputFile = document.getElementById('logfile');
const filenameDisplay = document.getElementById('filename');

// Crearemos un ícono dinámico para mostrar junto al nombre del archivo
// Por simplicidad, usaremos un ícono Bootstrap (o puede ser un emoji o SVG)

function createFileIcon() {
    const icon = document.createElement('i');
    icon.className = 'bi bi-file-earmark-check-fill text-success me-2 fs-4'; // ícono Bootstrap (verde)
    icon.setAttribute('aria-hidden', 'true');
    return icon;
}

function showFileName() {
    const file = inputFile.files[0];
    const dropzoneMessage = document.getElementById('dropzone-message');
    const uploadIcon = document.getElementById('upload-icon');

    if (file) {
        // Ocultar mensaje e ícono
        dropzoneMessage.style.display = 'none';
        uploadIcon.style.display = 'none';

        // Limpiar contenido previo
        filenameDisplay.textContent = '';

        // Crear icono y texto
        const icon = createFileIcon();
        filenameDisplay.appendChild(icon);

        const textNode = document.createTextNode(` ${file.name}`);
        filenameDisplay.appendChild(textNode);
    } else {
        // Mostrar mensaje e ícono si no hay archivo
        dropzoneMessage.style.display = 'block';
        uploadIcon.style.display = 'inline-block';
        filenameDisplay.textContent = '';
    }
}

dropzone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropzone.classList.add('border-primary', 'bg-white');
});

dropzone.addEventListener('dragleave', () => {
    dropzone.classList.remove('border-primary', 'bg-white');
});

dropzone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropzone.classList.remove('border-primary', 'bg-white');

    const dt = new DataTransfer();
    for (const file of e.dataTransfer.files) {
        dt.items.add(file);
    }
    inputFile.files = dt.files;

    showFileName();
});

dropzone.addEventListener('click', () => {
    inputFile.click();
});

inputFile.addEventListener('change', showFileName);

