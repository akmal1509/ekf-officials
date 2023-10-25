<template>
    <div class="space-y-4">
        <div>
            <p class="font-semibold">1. Contoh Belum Verifikasi <br> ( Sudah Selesai 100% )</p>
            <img :src="belum_verif" alt="">
            <p class="text-xs mt-2">
                note:
                <br>
                - Jika data belum terisi semua status verifikasi akan berwana merah, tingkat kelengkapan di nyatakan dalam
                persentase (dalam contoh sudah complete 100%)
            </p>
        </div>
        <div>
            <p class="font-semibold">2. Contoh Sudah Verifikasi <br> ( Sudah Selesai 100% )</p>
            <img :src="belum_verif" alt="">
            <p class="text-xs mt-2">
                note:
                <br>
                - Verifikasi dilakukan oleh admin
                <br>
                - Setiap ada update, data yang sudah verifikasi akan berubah kembali ke belum verifikasi. Jika data sudah
                selesai dan belum ada verifikasi oleh admin dalam janga waktu tertentu dalam langsung dikomunikasikan
            </p>
        </div>
    </div>
</template>
<script setup>
import belum_verif from '@/assets/belum_verif.png'
import udah_verif from '@/assets/udah_verif.png'
</script>
