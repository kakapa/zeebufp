<template>
  <Head title="Molotsi Pilane Resume" />

  <GuestLayout>
    <div class="min-h-screen bg-gray-50">
      <!-- Hero Section -->
      <div class="bg-gradient-to-r from-primary-500 to-red-500 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-32">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            <div>
              <h1 class="text-4xl md:text-5xl font-bold mb-4">
                {{ name }}
              </h1>
              <h2 class="text-2xl md:text-3xl font-medium mb-6">
                Full Stack Web/Mobile Developer
              </h2>
              <p class="text-lg mb-8">
                Crafting beautiful, functional websites and applications with a
                focus on user experience and performance.
              </p>
              <div class="flex space-x-4">
                <a
                  href="#contact"
                  class="bg-white text-primary-600 px-6 py-3 rounded-md font-medium hover:bg-gray-100 transition-colors"
                >
                  Contact Me
                </a>
                <a
                  href="#portfolio"
                  class="border border-white text-white px-6 py-3 rounded-md font-medium hover:bg-white hover:bg-opacity-10 transition-colors"
                >
                  View Portfolio
                </a>
              </div>
            </div>
            <div class="flex justify-center">
              <img
                src="molotsi_pilane.jpg"
                alt="John Doe"
                class="rounded-full h-64 w-64 object-cover border-4 border-white shadow-lg"
              />
            </div>
          </div>
        </div>
      </div>

      <!-- About Section -->
      <section id="about" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">
            About Me
          </h2>
          <div class="max-w-3xl mx-auto">
            <p class="text-lg text-gray-700 mb-6">
              I'm a PHP Full Stack Developer with 10+ years of experience in web
              and software development, specializing in PHP, MySQL, Laravel, and
              JavaScript.
            </p>
            <p class="text-lg text-gray-700 mb-6">
              I’m currently working remotely with Katmandu Trading (USA) and a
              local municipality client on a tendering web app, while also
              building personal projects like
              <a href="https://makhee.com" target="_blank">makhee.com</a>
            </p>
            <p class="text-lg text-gray-700">
              I focus on creating innovative solutions that empower clients and
              communities through technology. I am also interesting in exploring
              the booming Cloud Data Engineering, AI machine learning and
              developing smart contracts in Web 3.0 cryptocurrency world.
            </p>
          </div>
        </div>
      </section>

      <!-- Skills Section -->
      <section id="skills" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">
            Skills & Technologies
          </h2>

          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Frontend Skills -->
            <div class="bg-white p-6 rounded-lg shadow-md">
              <div class="flex items-center mb-4">
                <CodeIcon class="h-8 w-8 text-primary-500 mr-3" />
                <h3 class="text-xl font-semibold text-gray-900">Frontend</h3>
              </div>
              <ul class="space-y-2">
                <li class="flex items-center">
                  <CheckCircleIcon class="h-5 w-5 text-green-500 mr-2" />
                  <span>HTML5, CSS3, JavaScript (ES6+)</span>
                </li>
                <li class="flex items-center">
                  <CheckCircleIcon class="h-5 w-5 text-green-500 mr-2" />
                  <span>Vue.js, React, React Native</span>
                </li>
                <li class="flex items-center">
                  <CheckCircleIcon class="h-5 w-5 text-green-500 mr-2" />
                  <span>Tailwind CSS, Bootstrap</span>
                </li>
                <li class="flex items-center">
                  <CheckCircleIcon class="h-5 w-5 text-green-500 mr-2" />
                  <span>Responsive Design, Accessibility</span>
                </li>
                <li class="flex items-center">
                  <CheckCircleIcon class="h-5 w-5 text-green-500 mr-2" />
                  <span>TypeScript, Redux, Vuex</span>
                </li>
              </ul>
            </div>

            <!-- Backend Skills -->
            <div class="bg-white p-6 rounded-lg shadow-md">
              <div class="flex items-center mb-4">
                <ServerIcon class="h-8 w-8 text-primary-500 mr-3" />
                <h3 class="text-xl font-semibold text-gray-900">Backend</h3>
              </div>
              <ul class="space-y-2">
                <li class="flex items-center">
                  <CheckCircleIcon class="h-5 w-5 text-green-500 mr-2" />
                  <span>Node.js</span>
                </li>
                <li class="flex items-center">
                  <CheckCircleIcon class="h-5 w-5 text-green-500 mr-2" />
                  <span>PHP, Laravel</span>
                </li>
                <li class="flex items-center">
                  <CheckCircleIcon class="h-5 w-5 text-green-500 mr-2" />
                  <span>RESTful APIs, GraphQL</span>
                </li>
                <li class="flex items-center">
                  <CheckCircleIcon class="h-5 w-5 text-green-500 mr-2" />
                  <span>MySQL, MongoDB, PostgreSQL</span>
                </li>
                <li class="flex items-center">
                  <CheckCircleIcon class="h-5 w-5 text-green-500 mr-2" />
                  <span>Authentication, Authorization</span>
                </li>
              </ul>
            </div>

            <!-- Tools & Others -->
            <div class="bg-white p-6 rounded-lg shadow-md">
              <div class="flex items-center mb-4">
                <MenuIcon class="h-8 w-8 text-primary-500 mr-3" />
                <h3 class="text-xl font-semibold text-gray-900">
                  Tools & Others
                </h3>
              </div>
              <ul class="space-y-2">
                <li class="flex items-center">
                  <CheckCircleIcon class="h-5 w-5 text-green-500 mr-2" />
                  <span>Git, GitHub</span>
                </li>
                <li class="flex items-center">
                  <CheckCircleIcon class="h-5 w-5 text-green-500 mr-2" />
                  <span>Docker, CI/CD, AWS</span>
                </li>
                <li class="flex items-center">
                  <CheckCircleIcon class="h-5 w-5 text-green-500 mr-2" />
                  <span>Webpack, Vite, npm/yarn</span>
                </li>
                <li class="flex items-center">
                  <CheckCircleIcon class="h-5 w-5 text-green-500 mr-2" />
                  <span>PhpUnit, PSR-12</span>
                </li>
                <li class="flex items-center">
                  <CheckCircleIcon class="h-5 w-5 text-green-500 mr-2" />
                  <span>Figma, Adobe Photoshop</span>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </section>

      <!-- Experience Section -->
      <section id="experience" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">
            Work Experience
          </h2>

          <div class="max-w-3xl mx-auto space-y-12">
            <!-- Job 1 -->
            <div class="relative pl-8 sm:pl-32 py-6 group">
              <div
                class="flex flex-col sm:flex-row items-start mb-1 group-hover:text-primary-500"
              >
                <div
                  class="absolute left-0 top-0 sm:top-6 flex items-center justify-center"
                >
                  <div
                    class="h-16 w-16 rounded-full border-2 border-primary-500 bg-white flex items-center justify-center"
                  >
                    <BriefcaseIcon class="h-8 w-8 text-primary-500" />
                  </div>
                </div>
                <div class="sm:ml-8 mt-8 sm:mt-0">
                  <span class="text-sm text-gray-500 mb-1 block"
                    >Mar 2025 - Present (Contract)</span
                  >
                  <h3 class="text-xl font-bold text-gray-900 mb-2">
                    Full Stack Laravel Developer
                  </h3>
                  <h4 class="text-lg font-medium text-gray-700 mb-4">
                    Katmandu Trading (USA)
                  </h4>
                  <p class="text-gray-600">
                    Developing an apparel design web application using PHP
                    Laravel, Vue.js, Inertia.js, Three.js, and Tailwind CSS for
                    the global fashion design market, while collaborating
                    remotely with a team based in India.
                  </p>
                </div>
              </div>
            </div>

            <!-- Job 2 -->
            <div class="relative pl-8 sm:pl-32 py-6 group">
              <div
                class="flex flex-col sm:flex-row items-start mb-1 group-hover:text-primary-500"
              >
                <div
                  class="absolute left-0 top-0 sm:top-6 flex items-center justify-center"
                >
                  <div
                    class="h-16 w-16 rounded-full border-2 border-primary-500 bg-white flex items-center justify-center"
                  >
                    <BriefcaseIcon class="h-8 w-8 text-primary-500" />
                  </div>
                </div>
                <div class="sm:ml-8 mt-8 sm:mt-0">
                  <span class="text-sm text-gray-500 mb-1 block"
                    >2021 - 2025</span
                  >
                  <h3 class="text-xl font-bold text-gray-900 mb-2">
                    PHP Laravel Developer
                  </h3>
                  <h4 class="text-lg font-medium text-gray-700 mb-4">
                    PowerVision & Katmandu
                  </h4>
                  <p class="text-gray-600">
                    Remotely assisted Katmandu Trading (USA) with eCommerce
                    website maintenance across platforms like Shopify, Faire,
                    Poshmark, and Whatnot, collaborating with developers in
                    India. Also worked on a tendering and bidding web
                    application for a local municipality through Powervision
                    Technologies in Durban.
                  </p>
                </div>
              </div>
            </div>

            <!-- Job 3 -->
            <div class="relative pl-8 sm:pl-32 py-6 group">
              <div
                class="flex flex-col sm:flex-row items-start mb-1 group-hover:text-primary-500"
              >
                <div
                  class="absolute left-0 top-0 sm:top-6 flex items-center justify-center"
                >
                  <div
                    class="h-16 w-16 rounded-full border-2 border-primary-500 bg-white flex items-center justify-center"
                  >
                    <BriefcaseIcon class="h-8 w-8 text-primary-500" />
                  </div>
                </div>
                <div class="sm:ml-8 mt-8 sm:mt-0">
                  <span class="text-sm text-gray-500 mb-1 block"
                    >2017 - 2020</span
                  >
                  <h3 class="text-xl font-bold text-gray-900 mb-2">
                    Junior PHP Developer
                  </h3>
                  <h4 class="text-lg font-medium text-gray-700 mb-4">
                    Khosini Tax & Legal
                  </h4>
                  <p class="text-gray-600">
                    Developed a web application to manage the company’s business
                    operations, including invoicing, taxation, and service
                    management for offerings such as company registrations and
                    printing services.
                  </p>
                </div>
              </div>
            </div>

            <!-- Job 4 -->
            <div class="relative pl-8 sm:pl-32 py-6 group">
              <div
                class="flex flex-col sm:flex-row items-start mb-1 group-hover:text-primary-500"
              >
                <div
                  class="absolute left-0 top-0 sm:top-6 flex items-center justify-center"
                >
                  <div
                    class="h-16 w-16 rounded-full border-2 border-primary-500 bg-white flex items-center justify-center"
                  >
                    <BriefcaseIcon class="h-8 w-8 text-primary-500" />
                  </div>
                </div>
                <div class="sm:ml-8 mt-8 sm:mt-0">
                  <span class="text-sm text-gray-500 mb-1 block"
                    >2010 - 2016</span
                  >
                  <h3 class="text-xl font-bold text-gray-900 mb-2">
                    Web Designer & Owner
                  </h3>
                  <h4 class="text-lg font-medium text-gray-700 mb-4">
                    Studio1909
                  </h4>
                  <p class="text-gray-600">
                    Founded and operated a web design and development company
                    under the incubation of SmartXchange in Durban, focusing on
                    designing and developing websites.
                  </p>
                </div>
              </div>
            </div>

            <!-- Job 5 -->
            <div class="relative pl-8 sm:pl-32 py-6 group">
              <div
                class="flex flex-col sm:flex-row items-start mb-1 group-hover:text-primary-500"
              >
                <div
                  class="absolute left-0 top-0 sm:top-6 flex items-center justify-center"
                >
                  <div
                    class="h-16 w-16 rounded-full border-2 border-primary-500 bg-white flex items-center justify-center"
                  >
                    <BriefcaseIcon class="h-8 w-8 text-primary-500" />
                  </div>
                </div>
                <div class="sm:ml-8 mt-8 sm:mt-0">
                  <span class="text-sm text-gray-500 mb-1 block"
                    >2006 - 2010</span
                  >
                  <h3 class="text-xl font-bold text-gray-900 mb-2">
                    Website Developer
                  </h3>
                  <h4 class="text-lg font-medium text-gray-700 mb-4">
                    Website Factory
                  </h4>
                  <p class="text-gray-600">
                    Utilized web technologies like Joomla and WordPress to build
                    dynamic websites that enhanced client visibility, user
                    engagement, and satisfaction. Led a development team in
                    creating and maintaining websites for corporate clients such
                    as EPOL, SATMA Awards, and Suncoast Casino.
                  </p>
                </div>
              </div>
            </div>

            <!-- Job 6 -->
            <div class="relative pl-8 sm:pl-32 py-6 group">
              <div
                class="flex flex-col sm:flex-row items-start mb-1 group-hover:text-primary-500"
              >
                <div
                  class="absolute left-0 top-0 sm:top-6 flex items-center justify-center"
                >
                  <div
                    class="h-16 w-16 rounded-full border-2 border-primary-500 bg-white flex items-center justify-center"
                  >
                    <BriefcaseIcon class="h-8 w-8 text-primary-500" />
                  </div>
                </div>
                <div class="sm:ml-8 mt-8 sm:mt-0">
                  <span class="text-sm text-gray-500 mb-1 block"
                    >2005 - 2006</span
                  >
                  <h3 class="text-xl font-bold text-gray-900 mb-2">
                    Personal Loan Consultant
                  </h3>
                  <h4 class="text-lg font-medium text-gray-700 mb-4">
                    Nedbank Personal Loans
                  </h4>
                  <p class="text-gray-600">
                    Assessed borrower eligibility, defined loan terms and
                    conditions, and prepared loan documentation. Provided
                    regular loan status updates to borrowers and third parties
                    to ensure timely processing and completion of applications.
                  </p>
                </div>
              </div>
            </div>

            <!-- Job 7 -->
            <div class="relative pl-8 sm:pl-32 py-6 group">
              <div
                class="flex flex-col sm:flex-row items-start mb-1 group-hover:text-primary-500"
              >
                <div
                  class="absolute left-0 top-0 sm:top-6 flex items-center justify-center"
                >
                  <div
                    class="h-16 w-16 rounded-full border-2 border-primary-500 bg-white flex items-center justify-center"
                  >
                    <BriefcaseIcon class="h-8 w-8 text-primary-500" />
                  </div>
                </div>
                <div class="sm:ml-8 mt-8 sm:mt-0">
                  <span class="text-sm text-gray-500 mb-1 block"
                    >2004 - 2005</span
                  >
                  <h3 class="text-xl font-bold text-gray-900 mb-2">
                    IT Facilitator
                  </h3>
                  <h4 class="text-lg font-medium text-gray-700 mb-4">
                    Mayibuye
                  </h4>
                  <p class="text-gray-600">
                    Trained learnership students in basic computer literacy and
                    A+ hardware skills. Helped many students become job-ready
                    and secure internships with small to medium IT companies in
                    Durban.
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- Education -->
          <div class="max-w-3xl mx-auto mt-16">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">Education</h2>

            <div class="relative pl-8 sm:pl-32 py-6 group">
              <div
                class="flex flex-col sm:flex-row items-start mb-1 group-hover:text-primary-500"
              >
                <div
                  class="absolute left-0 top-0 sm:top-6 flex items-center justify-center"
                >
                  <div
                    class="h-16 w-16 rounded-full border-2 border-primary-500 bg-white flex items-center justify-center"
                  >
                    <MenuIcon class="h-8 w-8 text-primary-500" />
                  </div>
                </div>
                <div class="sm:ml-8 mt-8 sm:mt-0">
                  <span class="text-sm text-gray-500 mb-1 block"
                    >2001 - 2004</span
                  >
                  <h3 class="text-xl font-bold text-gray-900 mb-2">
                    National Diploma in Information Technology
                  </h3>
                  <h4 class="text-lg font-medium text-gray-700 mb-4">
                    Durban University of Technology
                  </h4>
                  <p class="text-gray-600">
                    Graduated with distinction in Software Development, and top
                    3 final project in Microsoft .NET
                  </p>
                </div>
              </div>
            </div>

            <div class="relative pl-8 sm:pl-32 py-6 group">
              <div
                class="flex flex-col sm:flex-row items-start mb-1 group-hover:text-primary-500"
              >
                <div
                  class="absolute left-0 top-0 sm:top-6 flex items-center justify-center"
                >
                  <div
                    class="h-16 w-16 rounded-full border-2 border-primary-500 bg-white flex items-center justify-center"
                  >
                    <MenuIcon class="h-8 w-8 text-primary-500" />
                  </div>
                </div>
                <div class="sm:ml-8 mt-8 sm:mt-0">
                  <span class="text-sm text-gray-500 mb-1 block"
                    >2001 - 2004</span
                  >
                  <h3 class="text-xl font-bold text-gray-900 mb-2">Matric</h3>
                  <h4 class="text-lg font-medium text-gray-700 mb-4">
                    Tlhabane Technical & Commercial High School
                  </h4>
                  <p class="text-gray-600">
                    Matriculated with a distinction in Accounting (SG)
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Portfolio Section -->
      <section id="portfolio" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">
            Portfolio
          </h2>

          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Project 1 -->
            <div class="bg-white rounded-lg overflow-hidden shadow-md group">
              <div class="relative h-48 overflow-hidden">
                <img
                  src="https://placehold.co/400x600?text=Makhee Website"
                  alt="Makhee Website"
                  class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110"
                />
                <div
                  class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end"
                >
                  <div class="p-4 text-white">
                    <h4 class="font-bold">Makhee.com</h4>
                    <p class="text-sm">Laravel, Livewire 3, MySQL</p>
                  </div>
                </div>
              </div>
              <div class="p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-2">Makhee.com</h3>
                <p class="text-gray-600 mb-4">
                  A business and classified ads platform with binary MLN matrix
                  system, and user authentication.
                </p>
                <div class="flex flex-wrap gap-2 mb-4">
                  <span
                    class="px-3 py-1 bg-primary-100 text-primary-800 rounded-full text-xs font-medium"
                    >Laravel</span
                  >
                  <span
                    class="px-3 py-1 bg-primary-100 text-primary-800 rounded-full text-xs font-medium"
                    >Livewire 3</span
                  >
                  <span
                    class="px-3 py-1 bg-primary-100 text-primary-800 rounded-full text-xs font-medium"
                    >MySQL</span
                  >
                </div>
                <div class="flex space-x-3">
                  <a
                    href="https://makhee.com"
                    target="_blank"
                    class="text-primary-500 hover:text-primary-700 font-medium flex items-center"
                  >
                    <ExternalLinkIcon class="h-4 w-4 mr-1" />
                    Live Demo
                  </a>
                  <a
                    href="#"
                    class="text-gray-600 hover:text-gray-900 font-medium flex items-center"
                  >
                    <GithubIcon class="h-4 w-4 mr-1" />
                    GitHub
                  </a>
                </div>
              </div>
            </div>

            <!-- Project 2 -->
            <div class="bg-white rounded-lg overflow-hidden shadow-md group">
              <div class="relative h-48 overflow-hidden">
                <img
                  src="https://placehold.co/400x600?text=Bulk SMS App"
                  alt="Bulk SMS App"
                  class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110"
                />
                <div
                  class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end"
                >
                  <div class="p-4 text-white">
                    <h4 class="font-bold">Bulk SMS App</h4>
                    <p class="text-sm">
                      Laravel, InertiaJS, Tailwind CSS, VueJs 3, MySQL
                    </p>
                  </div>
                </div>
              </div>
              <div class="p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-2">
                  Bulk SMS App
                </h3>
                <p class="text-gray-600 mb-4">
                  A collaborative task management application with real-time
                  updates, team workspaces, and progress tracking.
                </p>
                <div class="flex flex-wrap gap-2 mb-4">
                  <span
                    class="px-3 py-1 bg-primary-100 text-primary-800 rounded-full text-xs font-medium"
                    >React</span
                  >
                  <span
                    class="px-3 py-1 bg-primary-100 text-primary-800 rounded-full text-xs font-medium"
                    >Firebase</span
                  >
                  <span
                    class="px-3 py-1 bg-primary-100 text-primary-800 rounded-full text-xs font-medium"
                    >Tailwind CSS</span
                  >
                  <span
                    class="px-3 py-1 bg-primary-100 text-primary-800 rounded-full text-xs font-medium"
                    >Redux</span
                  >
                </div>
                <div class="flex space-x-3">
                  <a
                    href="#"
                    class="text-primary-500 hover:text-primary-700 font-medium flex items-center"
                  >
                    <ExternalLinkIcon class="h-4 w-4 mr-1" />
                    Live Demo
                  </a>
                  <a
                    href="#"
                    class="text-gray-600 hover:text-gray-900 font-medium flex items-center"
                  >
                    <GithubIcon class="h-4 w-4 mr-1" />
                    GitHub
                  </a>
                </div>
              </div>
            </div>

            <!-- Project 3 -->
            <div class="bg-white rounded-lg overflow-hidden shadow-md group">
              <div class="relative h-48 overflow-hidden">
                <img
                  src="https://placehold.co/400x600?text=PipsHarvest App"
                  alt="PipsHarvest App"
                  class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110"
                />
                <div
                  class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end"
                >
                  <div class="p-4 text-white">
                    <h4 class="font-bold">PipsHarvest App</h4>
                    <p class="text-sm">
                      Laravel, InertiaJS, Tailwind CSS, VueJs 3, MongoDB
                    </p>
                  </div>
                </div>
              </div>
              <div class="p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-2">
                  PipsHarvest App
                </h3>
                <p class="text-gray-600 mb-4">
                  A fitness tracking application with workout plans, progress
                  visualization, and social sharing features.
                </p>
                <div class="flex flex-wrap gap-2 mb-4">
                  <span
                    class="px-3 py-1 bg-primary-100 text-primary-800 rounded-full text-xs font-medium"
                    >Angular</span
                  >
                  <span
                    class="px-3 py-1 bg-primary-100 text-primary-800 rounded-full text-xs font-medium"
                    >Node.js</span
                  >
                  <span
                    class="px-3 py-1 bg-primary-100 text-primary-800 rounded-full text-xs font-medium"
                    >Chart.js</span
                  >
                  <span
                    class="px-3 py-1 bg-primary-100 text-primary-800 rounded-full text-xs font-medium"
                    >PostgreSQL</span
                  >
                </div>
                <div class="flex space-x-3">
                  <a
                    href="#"
                    class="text-primary-500 hover:text-primary-700 font-medium flex items-center"
                  >
                    <ExternalLinkIcon class="h-4 w-4 mr-1" />
                    Live Demo
                  </a>
                  <a
                    href="#"
                    class="text-gray-600 hover:text-gray-900 font-medium flex items-center"
                  >
                    <GithubIcon class="h-4 w-4 mr-1" />
                    GitHub
                  </a>
                </div>
              </div>
            </div>

            <!-- Project 4 -->
            <div class="bg-white rounded-lg overflow-hidden shadow-md group">
              <div class="relative h-48 overflow-hidden">
                <img
                  src="https://placehold.co/400x600?text=Tender And Bidding App"
                  alt="Tender & Bidding App"
                  class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110"
                />
                <div
                  class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end"
                >
                  <div class="p-4 text-white">
                    <h4 class="font-bold">
                      NDZ Local Municipality Tender & Bidding App
                    </h4>
                    <p class="text-sm">WordPress, PHP, JavaScript</p>
                  </div>
                </div>
              </div>
              <div class="p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-2">
                  NDZ Local Municipality Tender & Bidding App
                </h3>
                <p class="text-gray-600 mb-4">
                  A custom WordPress theme for a real estate agency with
                  property listings, search functionality, and agent profiles.
                </p>
                <div class="flex flex-wrap gap-2 mb-4">
                  <span
                    class="px-3 py-1 bg-primary-100 text-primary-800 rounded-full text-xs font-medium"
                    >WordPress</span
                  >
                  <span
                    class="px-3 py-1 bg-primary-100 text-primary-800 rounded-full text-xs font-medium"
                    >PHP</span
                  >
                  <span
                    class="px-3 py-1 bg-primary-100 text-primary-800 rounded-full text-xs font-medium"
                    >JavaScript</span
                  >
                  <span
                    class="px-3 py-1 bg-primary-100 text-primary-800 rounded-full text-xs font-medium"
                    >MySQL</span
                  >
                </div>
                <div class="flex space-x-3">
                  <a
                    href="#"
                    class="text-primary-500 hover:text-primary-700 font-medium flex items-center"
                  >
                    <ExternalLinkIcon class="h-4 w-4 mr-1" />
                    Live Demo
                  </a>
                  <a
                    href="#"
                    class="text-gray-600 hover:text-gray-900 font-medium flex items-center"
                  >
                    <GithubIcon class="h-4 w-4 mr-1" />
                    GitHub
                  </a>
                </div>
              </div>
            </div>

            <!-- Project 5 -->
            <div class="bg-white rounded-lg overflow-hidden shadow-md group">
              <div class="relative h-48 overflow-hidden">
                <img
                  src="https://placehold.co/400x600?text=WhatsApp Store App"
                  alt="WhatsApp Store App"
                  class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110"
                />
                <div
                  class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end"
                >
                  <div class="p-4 text-white">
                    <h4 class="font-bold">WhatsApp Store App</h4>
                    <p class="text-sm">Vue.js, Twilio API</p>
                  </div>
                </div>
              </div>
              <div class="p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-2">
                  WhatsApp Store SASS
                </h3>
                <p class="text-gray-600 mb-4">
                  A weather dashboard with location search, current conditions,
                  forecasts, and interactive weather maps.
                </p>
                <div class="flex flex-wrap gap-2 mb-4">
                  <span
                    class="px-3 py-1 bg-primary-100 text-primary-800 rounded-full text-xs font-medium"
                    >Vue.js</span
                  >
                  <span
                    class="px-3 py-1 bg-primary-100 text-primary-800 rounded-full text-xs font-medium"
                    >OpenWeather API</span
                  >
                  <span
                    class="px-3 py-1 bg-primary-100 text-primary-800 rounded-full text-xs font-medium"
                    >Axios</span
                  >
                  <span
                    class="px-3 py-1 bg-primary-100 text-primary-800 rounded-full text-xs font-medium"
                    >Leaflet.js</span
                  >
                </div>
                <div class="flex space-x-3">
                  <a
                    href="#"
                    class="text-primary-500 hover:text-primary-700 font-medium flex items-center"
                  >
                    <ExternalLinkIcon class="h-4 w-4 mr-1" />
                    Live Demo
                  </a>
                  <a
                    href="#"
                    class="text-gray-600 hover:text-gray-900 font-medium flex items-center"
                  >
                    <GithubIcon class="h-4 w-4 mr-1" />
                    GitHub
                  </a>
                </div>
              </div>
            </div>

            <!-- Project 6 -->
            <div class="bg-white rounded-lg overflow-hidden shadow-md group">
              <div class="relative h-48 overflow-hidden">
                <img
                  src="https://placehold.co/400x600?text=Binary MLN Micro Service"
                  alt="Binary MLN Micro Service"
                  class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110"
                />
                <div
                  class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end"
                >
                  <div class="p-4 text-white">
                    <h4 class="font-bold">Binary MLN Micro Service</h4>
                    <p class="text-sm">Next.js, Tailwind CSS, Sanity CMS</p>
                  </div>
                </div>
              </div>
              <div class="p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-2">
                  Binary MLN Micro Service
                </h3>
                <p class="text-gray-600 mb-4">
                  A modern blog platform with content management, commenting
                  system, and responsive design for all devices.
                </p>
                <div class="flex flex-wrap gap-2 mb-4">
                  <span
                    class="px-3 py-1 bg-primary-100 text-primary-800 rounded-full text-xs font-medium"
                    >Next.js</span
                  >
                  <span
                    class="px-3 py-1 bg-primary-100 text-primary-800 rounded-full text-xs font-medium"
                    >Tailwind CSS</span
                  >
                  <span
                    class="px-3 py-1 bg-primary-100 text-primary-800 rounded-full text-xs font-medium"
                    >Sanity CMS</span
                  >
                  <span
                    class="px-3 py-1 bg-primary-100 text-primary-800 rounded-full text-xs font-medium"
                    >Vercel</span
                  >
                </div>
                <div class="flex space-x-3">
                  <a
                    href="#"
                    class="text-primary-500 hover:text-primary-700 font-medium flex items-center"
                  >
                    <ExternalLinkIcon class="h-4 w-4 mr-1" />
                    Live Demo
                  </a>
                  <a
                    href="#"
                    class="text-gray-600 hover:text-gray-900 font-medium flex items-center"
                  >
                    <GithubIcon class="h-4 w-4 mr-1" />
                    GitHub
                  </a>
                </div>
              </div>
            </div>
          </div>

          <div class="text-center mt-12">
            <a
              href="#"
              class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
            >
              View More Projects
              <ArrowRightIcon class="ml-2 h-5 w-5" />
            </a>
          </div>
        </div>
      </section>

      <!-- Contact Section -->
      <section id="contact" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">
            Get In Touch
          </h2>

          <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <div>
              <p class="text-lg text-gray-700 mb-8">
                I'm currently available for freelance work and full-time
                positions. If you have a project that needs some creative touch,
                or if you're looking to hire a developer, feel free to reach
                out!
              </p>

              <div class="space-y-6">
                <div class="flex items-start">
                  <div class="flex-shrink-0">
                    <MailIcon class="h-6 w-6 text-primary-500" />
                  </div>
                  <div class="ml-3 text-base text-gray-700">
                    <p>molotsipilane@gmail.com</p>
                  </div>
                </div>

                <div class="flex items-start">
                  <div class="flex-shrink-0">
                    <PhoneIcon class="h-6 w-6 text-primary-500" />
                  </div>
                  <div class="ml-3 text-base text-gray-700">
                    <p>+27 (81) 782-5940</p>
                  </div>
                </div>

                <div class="flex items-start">
                  <div class="flex-shrink-0">
                    <MapPinIcon class="h-6 w-6 text-primary-500" />
                  </div>
                  <div class="ml-3 text-base text-gray-700">
                    <p>Rustenburg, NW, RSA</p>
                  </div>
                </div>
              </div>

              <div class="mt-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                  Connect with me
                </h3>
                <div class="flex space-x-5">
                  <a
                    href="https://github.com/kakapa"
                    target="_blank"
                    class="text-gray-400 hover:text-gray-500"
                  >
                    <span class="sr-only">GitHub</span>
                    <GithubIcon class="h-6 w-6" />
                  </a>
                  <a
                    href="https://www.linkedin.com/in/molotsi-pilane"
                    target="_blank"
                    class="text-gray-400 hover:text-gray-500"
                  >
                    <span class="sr-only">LinkedIn</span>
                    <LinkedinIcon class="h-6 w-6" />
                  </a>
                </div>
              </div>
            </div>

            <div>
              <form class="space-y-6">
                <div>
                  <label
                    for="name"
                    class="block text-sm font-medium text-gray-700"
                    >Name</label
                  >
                  <div class="mt-1">
                    <input
                      type="text"
                      name="name"
                      id="name"
                      class="py-3 px-4 block w-full shadow-sm focus:ring-primary-500 focus:border-primary-500 border-gray-300 rounded-md"
                      placeholder="Your name"
                    />
                  </div>
                </div>

                <div>
                  <label
                    for="email"
                    class="block text-sm font-medium text-gray-700"
                    >Email</label
                  >
                  <div class="mt-1">
                    <input
                      type="email"
                      name="email"
                      id="email"
                      class="py-3 px-4 block w-full shadow-sm focus:ring-primary-500 focus:border-primary-500 border-gray-300 rounded-md"
                      placeholder="your.email@example.com"
                    />
                  </div>
                </div>

                <div>
                  <label
                    for="subject"
                    class="block text-sm font-medium text-gray-700"
                    >Subject</label
                  >
                  <div class="mt-1">
                    <input
                      type="text"
                      name="subject"
                      id="subject"
                      class="py-3 px-4 block w-full shadow-sm focus:ring-primary-500 focus:border-primary-500 border-gray-300 rounded-md"
                      placeholder="What is this regarding?"
                    />
                  </div>
                </div>

                <div>
                  <label
                    for="message"
                    class="block text-sm font-medium text-gray-700"
                    >Message</label
                  >
                  <div class="mt-1">
                    <textarea
                      id="message"
                      name="message"
                      rows="4"
                      class="py-3 px-4 block w-full shadow-sm focus:ring-primary-500 focus:border-primary-500 border-gray-300 rounded-md"
                      placeholder="Your message"
                    ></textarea>
                  </div>
                </div>

                <div>
                  <button
                    type="submit"
                    class="w-full inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                  >
                    Send Message
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </section>
    </div>
  </GuestLayout>
</template>

<script setup>
import { ref } from "vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import {
  MenuIcon,
  XIcon,
  CodeIcon,
  ServerIcon,
  //ToolIcon,
  CheckCircleIcon,
  BriefcaseIcon,
  //AcademicCapIcon,
  ExternalLinkIcon,
  GithubIcon,
  MailIcon,
  PhoneIcon,
  MapPinIcon,
  LinkedinIcon,
  TwitterIcon,
  FacebookIcon,
  ArrowRightIcon,
} from "lucide-vue-next";

const mobileMenuOpen = ref(false);

defineProps({
  name: {
    type: String,
  },
});
</script>

<style scoped>
html {
  scroll-behavior: smooth;
}
</style>
