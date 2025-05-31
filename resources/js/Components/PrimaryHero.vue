<template>
  <div class="relative bg-gray-900">
    <div class="absolute inset-0">
      <img
        class="w-full h-full object-cover"
        src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80"
        alt="VILTURA"
      />
      <div class="absolute inset-0 bg-black opacity-60"></div>
    </div>
    <div class="relative max-w-7xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8">
      <h1
        class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl"
      >
        VILTURA LARAVEL BOILERPLATE
      </h1>
      <p class="mt-6 text-xl text-gray-300 max-w-3xl">
        A good VILT Stack boilerplate with Laravel 12 + Breeze + Inertia2 + VUE3
        + Basic Api with Sanctum!
      </p>
      <div class="mt-10 flex flex-col sm:flex-row gap-4">
        <Link
          href="/about"
          class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary-500 hover:bg-primary-600"
        >
          Learn More
        </Link>
        <Link
          href="/contact"
          class="inline-flex items-center justify-center px-5 py-3 border border-white text-base font-medium rounded-md text-white hover:bg-gray-800"
        >
          Get Involved
        </Link>
      </div>
    </div>
  </div>
</template>
