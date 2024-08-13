// Referencias a los elementos
const fileDropArea = document.querySelector('.file-drop-area');
const fileInput = document.querySelector('.file-input');
const fileMsg = document.querySelector('.file-msg');
const imagePreview = document.getElementById('image-preview');
const removeImageBtn = document.querySelector('.remove-image-btn');
const fakeBtn = document.querySelector('.fake-btn');

// Función para previsualizar la imagen
function previewImage(file) {
    const reader = new FileReader();
    reader.onload = function(e) {
        imagePreview.src = e.target.result;
        imagePreview.style.display = 'block'; // Muestra la imagen
    };
    reader.readAsDataURL(file);
}

// Función para mostrar el botón de eliminar imagen
function showRemoveImageBtn() {
    fakeBtn.style.display = 'none';
    removeImageBtn.style.display = 'block';
}

// Función para ocultar el botón de eliminar imagen
function hideRemoveImageBtn() {
    fakeBtn.style.display = 'block';
    removeImageBtn.style.display = 'none';
}

// Función para eliminar la imagen y restaurar el estado inicial
function removeImage() {
    fileInput.value = '';
    if (fileInput.files.length > 0) {
        // Restaurar la imagen almacenada en la BD o imagen por defecto
        const hasImageInDB = fileInput.dataset.hasImage === 'true';
        imagePreview.src = hasImageInDB ? fileInput.dataset.imageUrl : window.imageDefaultUrl;
        fileMsg.textContent = hasImageInDB ? fileInput.dataset.imageName : dragText;
    } else {
        // Restaurar imagen por defecto si no hay archivo
        imagePreview.src = window.imageDefaultUrl;
        fileMsg.textContent = dragText;
    }
    hideRemoveImageBtn(); // Oculta el botón para remover la imagen
}

// Inicializar el estado del botón basado en la presencia de archivos
function initialize() {
    const hasImageInDB = fileInput.dataset.hasImage === 'true';
    if (fileInput.files.length > 0 || hasImageInDB) {
        showRemoveImageBtn();
        if (fileInput.files.length > 0) {
            previewImage(fileInput.files[0]); // Muestra la imagen cargada, si hay
            fileMsg.textContent = fileInput.files[0].name; // Muestra el nombre del archivo
        } else {
            imagePreview.src = fileInput.dataset.imageUrl; // Imagen almacenada en la BD
            fileMsg.textContent = fileInput.dataset.imageName; // Nombre del archivo almacenado
        }
    } else {
        hideRemoveImageBtn();
        imagePreview.src = window.imageDefaultUrl; // Imagen por defecto
        fileMsg.textContent = dragText; // Texto por defecto
    }
}

// Añadir la clase "dashed" y cambiar el texto cuando un archivo está siendo arrastrado sobre el área
fileDropArea.addEventListener('dragover', function(e) {
    e.preventDefault();
    this.classList.add('dashed');
    fileMsg.textContent = dropText; // Cambia el texto
});

// Eliminar la clase "dashed" y restaurar el texto original cuando el archivo sale del área
fileDropArea.addEventListener('dragleave', function(e) {
    this.classList.remove('dashed');
    fileMsg.textContent = fileInput.files.length > 0 ? fileInput.files[0].name : dragText; // Restaura el texto original
});

// Eliminar la clase "dashed", mostrar el nombre y previsualizar la imagen cuando el archivo es soltado
fileDropArea.addEventListener('drop', function(e) {
    e.preventDefault();
    this.classList.remove('dashed');
    var files = e.dataTransfer.files;
    fileInput.files = files;
    fileMsg.textContent = files[0].name; // Muestra el nombre del archivo
    previewImage(files[0]); // Previsualiza la imagen
    showRemoveImageBtn(); // Muestra el botón para remover la imagen
});

// Mostrar el nombre y previsualizar la imagen cuando se selecciona a través del botón
fileInput.addEventListener('change', function() {
    if (fileInput.files.length > 0) {
        fileMsg.textContent = fileInput.files[0].name; // Muestra el nombre del archivo
        previewImage(fileInput.files[0]); // Previsualiza la imagen
        showRemoveImageBtn(); // Muestra el botón para remover la imagen
    }
});

// Llama a initialize cuando se carga la página
document.addEventListener('DOMContentLoaded', initialize);

// Evento para el botón de eliminar imagen
removeImageBtn.addEventListener('click', removeImage);
