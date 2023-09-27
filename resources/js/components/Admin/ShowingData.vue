<template>
    <div class="border-gray-200 border rounded-sm text-sm">
        <div class="bg-white">
            <p class="p-2 font-semibold"><slot name="label"></slot></p>
        </div>
        <div class="p-2">
            <p>Nama Lengkap : <slot name="nama"></slot></p>
            <p>Nomor Telepon : <slot name="tel"></slot></p>
        </div>
    </div>
</template>
<script setup></script>
