// Referencias a los elementos
const fileDropArea = document.querySelector('.file-drop-area');
const fileInput = document.querySelector('.file-input');
const fileMsg = document.querySelector('.file-msg');
const imagePreview = document.getElementById('image-preview');
const removeImageBtn = document.querySelector('.remove-image-btn');
const fakeBtn = document.querySelector('.fake-btn');

// Añadir la clase "dashed" y cambiar el texto cuando un archivo está siendo arrastrado sobre el área
fileDropArea.addEventListener('dragover', function(e) {
    e.preventDefault();
    this.classList.add('dashed');
    fileMsg.textContent = "Drop your image"; // Cambia el texto
});

// Eliminar la clase "dashed" y restaurar el texto original cuando el archivo sale del área
fileDropArea.addEventListener('dragleave', function(e) {
    this.classList.remove('dashed');
    fileMsg.textContent = "Drag your image here"; // Restaura el texto original
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
    fileMsg.textContent = "Drag your image here";
    imagePreview.src = window.imageDefaultUrl; // Imagen por defecto
    imagePreview.style.display = 'block'; // Muestra la imagen por defecto
    hideRemoveImageBtn(); // Oculta el botón para remover la imagen
}

// Evento para el botón de eliminar imagen
removeImageBtn.addEventListener('click', removeImage);

// Inicializar el estado del botón basado en la presencia de archivos
function initialize() {
    if (fileInput.files.length > 0) {
        showRemoveImageBtn();
        previewImage(fileInput.files[0]); // Muestra la imagen cargada, si hay
    } else {
        hideRemoveImageBtn();
        imagePreview.src = window.imageDefaultUrl; // Imagen por defecto
        imagePreview.style.display = 'block'; // Muestra la imagen por defecto
    }
}

// Llama a initialize cuando se carga la página
document.addEventListener('DOMContentLoaded', initialize);
