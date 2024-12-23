// Mendapatkan elemen-elemen dari DOM
const textarea = document.querySelector('.textarea');
const saveButton = document.querySelector('.btn.save');
const cancelButton = document.querySelector('.btn.cancel');

// Fungsi untuk menyimpan data ke localStorage
function saveData() {
    const data = textarea.value.trim();
    if (data) {
        localStorage.setItem('visiMisi', data); // Simpan ke localStorage
        alert('Visi dan Misi berhasil disimpan!');
    } else {
        alert('Textarea kosong. Tidak ada data yang disimpan.');
    }
}

// Fungsi untuk membatalkan perubahan
function cancelData() {
    const confirmation = confirm('Apakah Anda yakin ingin membatalkan perubahan?');
    if (confirmation) {
        textarea.value = ''; // Mengosongkan textarea
        alert('Perubahan telah dibatalkan.');
    }
}

// Mengisi textarea jika ada data yang sudah tersimpan
function loadSavedData() {
    const savedData = localStorage.getItem('visiMisi');
    if (savedData) {
        textarea.value = savedData; // Menampilkan data tersimpan di textarea
    }
}

// Menambahkan event listener pada tombol
saveButton.addEventListener('click', saveData);
cancelButton.addEventListener('click', cancelData);

// Memuat data yang tersimpan saat halaman di-load
window.addEventListener('DOMContentLoaded', loadSavedData);
