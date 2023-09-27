import { ref } from 'vue';

export default function useErrorHandling() {
    const errorMessage = ref('');

    const handleError = (error) => {
        // Menyimpan pesan kesalahan
        errorMessage.value = error;

        // Menggulir halaman ke atas
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };

    return {
        errorMessage,
        handleError,
    };
}
