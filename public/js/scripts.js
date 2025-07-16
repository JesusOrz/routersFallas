
document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
    new bootstrap.Tooltip(el);
});




const toggler = document.querySelector(".btn");
toggler.addEventListener("click",function(){
    document.querySelector("#sidebar").classList.toggle("collapsed");
});


function showToast(type = 'success', message = 'Operación exitosa', delay = 3000) {
    let toastId, messageId;

    if (type === 'success') {
        toastId = 'toastSuccess';
        messageId = 'toastSuccessMessage';
    } else if (type === 'error') {
        toastId = 'toastError';
        messageId = 'toastErrorMessage';
    } else {
        console.warn('Tipo de toast no válido');
        return;
    }

    const toastElement = document.getElementById(toastId);
    const messageElement = document.getElementById(messageId);

    if (messageElement && toastElement) {
        messageElement.innerText = message;
        const toast = new bootstrap.Toast(toastElement, { delay: delay });
        toast.show();
    }
}

