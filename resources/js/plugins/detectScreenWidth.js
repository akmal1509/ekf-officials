// src/plugins/detectScreenWidth.js
import { onMounted, onUnmounted, reactive } from 'vue';

const state = reactive({
    isDesktop: window.innerWidth >= 768, // Menentukan nilai awal sesuai dengan kondisi desktop atau mobile
});

// Fungsi untuk mengubah nilai isDesktop berdasarkan lebar layar
function updateIsDesktop() {
    state.isDesktop = window.innerWidth >= 768;
}

onMounted(() => {
    // Mengupdate nilai saat komponen dipasang
    updateIsDesktop();
    window.addEventListener('resize', updateIsDesktop);
});

onUnmounted(() => {
    // Membersihkan event listener saat komponen di-unmount
    window.removeEventListener('resize', updateIsDesktop);
});

export { state };
