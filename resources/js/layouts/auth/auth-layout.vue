<template>
    <div class="flex min-h-screen items-center justify-center bg-gradient-to-br from-purple-50 to-pink-50 px-4 py-12 sm:px-6 lg:px-8">
        <div class="w-full max-w-md space-y-8">
            <div class="text-center">
                <div class="mx-auto h-16 w-16 rounded-full bg-gradient-to-r from-purple-500 to-pink-500 flex items-center justify-center mb-4">
                    <span class="text-white font-bold text-xl">DD</span>
                </div>
                <h2 class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                    Dandeline Designs
                </h2>
                <p class="mt-2 text-sm text-gray-600">Beautiful floral arrangements & artistic designs</p>
            </div>
            <div class="rounded-lg bg-white px-6 py-8 shadow-xl border border-gray-100 sm:px-10">
                <slot />
            </div>
        </div>
    </div>
</template>
