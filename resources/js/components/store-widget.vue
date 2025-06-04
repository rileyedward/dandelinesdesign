<template>
    <div class="store-widget-card max-w-sm rounded-lg bg-white p-6 shadow-md">
        <h3 class="mb-2 text-center text-xl font-semibold">Shop Our Collection</h3>

        <p class="mb-3 text-center text-sm text-gray-600 italic">Handcrafted Designs & Unique Treasures</p>

        <hr class="mx-auto mb-3 w-16 border-t border-gray-300" />

        <p class="text-center text-sm text-gray-700">
            Discover our curated collection of handcrafted designs, floral arrangements, and unique gifts. Each item is created with passion and
            attention to detail, bringing a touch of elegance to your space or special occasion.
        </p>

        <div class="mt-4 flex justify-center">
            <button class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 transition-colors hover:bg-gray-100">
                browse products
            </button>
        </div>
    </div>
</template>

<style scoped>
.store-widget-card {
    position: absolute;
    top: 50%;
    right: 10%;
    transform: translateY(-50%);
    z-index: 20;
}
</style>
