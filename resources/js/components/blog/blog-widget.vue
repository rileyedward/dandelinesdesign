<template>
    <div class="blog-widget-card max-w-sm rounded-lg bg-white p-6 shadow-md">
        <h3 class="mb-2 text-center text-xl font-semibold">Dandelions Blog</h3>

        <p class="mb-3 text-center text-sm text-gray-600 italic">Inspiration, Tips & Creative Insights</p>

        <hr class="mx-auto mb-3 w-16 border-t border-gray-300" />

        <p class="text-center text-sm text-gray-700">
            Explore our blog for the latest design trends, floral arrangement tips, event planning advice, and behind-the-scenes glimpses of our
            creative process. Stay inspired and informed with our regularly updated articles.
        </p>
    </div>
</template>

<style scoped>
.blog-widget-card {
    position: absolute;
    bottom: 10%;
    left: 10%;
    transform: translateY(0);
    z-index: 20;
    box-shadow:
        0 10px 15px -3px rgba(0, 0, 0, 0.1),
        0 4px 6px -2px rgba(0, 0, 0, 0.05);
}
</style>
