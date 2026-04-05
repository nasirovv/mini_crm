const API_URL = '/api/tickets';

const btnSubmit    = document.getElementById('btnSubmit');
const btnNewTicket = document.getElementById('btnNewTicket');
const formState    = document.getElementById('formState');
const successState = document.getElementById('successState');
const alertError   = document.getElementById('alertError');
const alertErrorText = document.getElementById('alertErrorText');
const fileInput    = document.getElementById('files');
const fileList     = document.getElementById('fileList');

let selectedFiles = [];

// ── File handling ──
fileInput.addEventListener('change', function () {
    for (const file of this.files) {
        selectedFiles.push(file);
    }
    this.value = '';
    renderFileList();
});

function renderFileList() {
    fileList.innerHTML = '';
    selectedFiles.forEach((file, index) => {
        const item = document.createElement('div');
        item.className = 'file-item';
        item.innerHTML = `
                <span class="file-name">${file.name}</span>
                <button class="file-remove" data-index="${index}">&times;</button>
            `;
        fileList.appendChild(item);
    });

    fileList.querySelectorAll('.file-remove').forEach(btn => {
        btn.addEventListener('click', function () {
            selectedFiles.splice(this.dataset.index, 1);
            renderFileList();
        });
    });
}

// ── Errors ──
function clearErrors() {
    document.querySelectorAll('.form-group').forEach(g => g.classList.remove('has-error'));
    document.querySelectorAll('.error-text').forEach(e => { e.textContent = ''; e.style.display = 'none'; });
    alertError.classList.remove('show');
}

function showFieldError(field, message) {
    const group = document.getElementById('group-' + field);
    const error = document.getElementById('error-' + field);
    if (group) group.classList.add('has-error');
    if (error) { error.textContent = message; error.style.display = 'block'; }
}

// ── Submit ──
btnSubmit.addEventListener('click', async function () {
    clearErrors();

    const formData = new FormData();
    formData.append('name', document.getElementById('name').value.trim());
    formData.append('email', document.getElementById('email').value.trim());
    formData.append('phone', document.getElementById('phone').value.trim());
    formData.append('topic', document.getElementById('topic').value.trim());
    formData.append('description', document.getElementById('description').value.trim());

    selectedFiles.forEach(file => formData.append('files[]', file));

    btnSubmit.classList.add('loading');
    btnSubmit.disabled = true;

    try {
        const response = await fetch(API_URL, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
            },
            body: formData,
        });

        const data = await response.json();

        if (!response.ok) {
            if (response.status === 422 && data.errors) {
                Object.entries(data.errors).forEach(([field, messages]) => {
                    showFieldError(field, messages[0]);
                });
            } else {
                alertErrorText.textContent = data.message || 'Произошла ошибка. Попробуйте ещё раз.';
                alertError.classList.add('show');
            }
            return;
        }

        // Success
        formState.style.display = 'none';
        alertError.classList.remove('show');
        successState.style.display = 'block';

    } catch (error) {
        alertErrorText.textContent = 'Ошибка сети. Проверьте подключение к интернету и попробуйте снова.';
        alertError.classList.add('show');
    } finally {
        btnSubmit.classList.remove('loading');
        btnSubmit.disabled = false;
    }
});

// ── New ticket ──
btnNewTicket.addEventListener('click', function () {
    ['name', 'email', 'phone', 'topic', 'description'].forEach(id => {
        document.getElementById(id).value = '';
    });
    selectedFiles = [];
    fileList.innerHTML = '';
    clearErrors();
    successState.style.display = 'none';
    formState.style.display = 'block';
});

// ── Remove error on focus ──
document.querySelectorAll('input, textarea').forEach(el => {
    el.addEventListener('focus', function () {
        const group = this.closest('.form-group');
        if (group) group.classList.remove('has-error');
    });
});
