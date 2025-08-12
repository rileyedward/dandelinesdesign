<template>
    <div class="flex min-h-screen items-center justify-center bg-gradient-to-br from-purple-50 to-pink-50 px-4 py-12 sm:px-6 lg:px-8">
        <div class="w-full max-w-md space-y-8">
            <div class="text-center">
                <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-purple-500">
                    <span class="text-xl font-bold text-white">DD</span>
                </div>
                <h2 class="text-3xl font-bold text-black">Dandelines Design</h2>
                <p class="mt-2 text-sm text-gray-600">Beautiful floral arrangements & artistic designs</p>
            </div>
            <div class="rounded-lg border border-gray-100 bg-white px-6 py-8 shadow-xl sm:px-10">
                <slot />
            </div>
        </div>
    </div>
</template>
