@extends('layouts.master')

@section('content')

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Cover Banner -->
    <section class="relative">
      <div class="h-36 sm:h-48 bg-gray-200 rounded-b-3xl overflow-hidden flex items-end justify-center" style="background-image: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=800&q=80'); background-size: cover; background-position: center;">
      </div>
      <!-- Profile Image (moved below banner, above name) -->
      <div class="flex flex-col items-center -mt-10 sm:-mt-14 mb-2">
        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Business Profile" class="w-20 h-20 sm:w-28 sm:h-28 rounded-full border-4 border-white shadow-md object-cover bg-white"/>
      </div>
      <div class="pb-4 text-center">
        <h1 class="text-xl sm:text-2xl font-bold flex items-center justify-center gap-2 flex-wrap">
          Business Name
          <!-- Show this span only if verified -->
          <span class="material-icons-outlined text-blue-500 text-lg align-middle" title="Verified">verified</span>
        </h1>
        <div class="flex flex-wrap justify-center gap-2 mt-2">
          <span class="px-3 py-1 rounded-full bg-gray-100 text-xs text-gray-700">Category</span>
          <span class="px-3 py-1 rounded-full bg-gray-100 text-xs text-gray-700">Subcategory</span>
        </div>
        <div class="flex items-center justify-center gap-1 mt-2">
          <div class="flex text-yellow-400">
            <span class="material-icons-outlined text-base">star</span>
            <span class="material-icons-outlined text-base">star</span>
            <span class="material-icons-outlined text-base">star</span>
            <span class="material-icons-outlined text-base">star</span>
            <span class="material-icons-outlined text-base">star_half</span>
          </div>
          <span class="text-gray-500 text-sm">(4.5 • 128 reviews)</span>
        </div>
      </div>
    </section>

    <!-- Primary Action Buttons -->
    <section class="w-full overflow-x-auto">
      <div class="flex flex-nowrap justify-center gap-1 sm:gap-2 mb-4 items-center min-w-[300px]">
        <button class="flex items-center gap-1 px-3 py-1.5 rounded-full bg-blue-500 text-white text-xs font-medium shadow-sm hover:bg-blue-600 transition">
          <span class="material-icons-outlined text-sm">person_add</span> Follow
        </button>
        <button class="flex items-center gap-1 px-3 py-1.5 rounded-full bg-blue-100 text-blue-700 text-xs font-medium shadow-sm hover:bg-blue-200 transition">
          <span class="material-icons-outlined text-sm">chat</span> Message
        </button>
        <button class="flex items-center gap-1 px-3 py-1.5 rounded-full bg-green-100 text-green-700 text-xs font-medium shadow-sm hover:bg-green-200 transition">
          <span class="material-icons-outlined text-sm">call</span> Call
        </button>
        <button class="flex items-center gap-1 px-3 py-1.5 rounded-full bg-green-500 text-white text-xs font-medium shadow-sm hover:bg-green-600 transition">
          <span class="inline-block w-4 h-4 align-middle">
            <svg viewBox="0 0 32 32" fill="currentColor" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"><path d="M16 3C9.373 3 4 8.373 4 15c0 2.385.832 4.584 2.236 6.393L4 29l7.824-2.205C13.5 27.597 14.734 28 16 28c6.627 0 12-5.373 12-12S22.627 3 16 3zm0 22c-1.13 0-2.238-.188-3.285-.558l-.235-.08-4.646 1.31 1.324-4.53-.153-.236C7.188 19.238 7 18.13 7 17c0-5.065 4.135-9.2 9.2-9.2S25.4 11.935 25.4 17c0 5.065-4.135 9.2-9.2 9.2zm5.07-6.13c-.276-.138-1.635-.808-1.888-.9-.253-.092-.437-.138-.62.138-.184.276-.713.9-.874 1.085-.161.184-.322.207-.598.069-.276-.138-1.166-.429-2.222-1.367-.822-.733-1.377-1.638-1.54-1.914-.161-.276-.017-.425.122-.563.126-.125.276-.322.414-.483.138-.161.184-.276.276-.46.092-.184.046-.345-.023-.483-.069-.138-.62-1.497-.849-2.05-.224-.54-.453-.467-.62-.476l-.529-.009c-.161 0-.414.06-.63.276-.216.216-.822.804-.822 1.96 0 1.156.84 2.274.957 2.432.115.161 1.653 2.527 4.008 3.44.56.192.995.307 1.336.393.561.143 1.072.123 1.475.075.45-.054 1.377-.562 1.572-1.104.195-.542.195-1.007.138-1.104-.057-.097-.207-.153-.483-.291z"/></svg>
          </span>
          WhatsApp
        </button>
        <button class="flex items-center gap-1 px-3 py-1.5 rounded-full bg-purple-100 text-purple-700 text-xs font-medium shadow-sm hover:bg-purple-200 transition">
          <span class="material-icons-outlined text-sm">share</span> Share
        </button>
      </div>
    </section>

    <!-- Description & Status -->
    <section class="text-center mb-4 px-1">
      <div class="flex flex-wrap justify-center gap-2 items-center text-xs">
        <span class="px-2 py-1 rounded bg-gray-100 text-gray-700">Individual</span>
        <span class="px-2 py-1 rounded bg-gray-100 text-gray-700">Brand</span>
        <span class="px-2 py-1 rounded bg-gray-100 text-gray-700">Organization</span>
        <span class="px-2 py-1 rounded bg-gray-100 text-gray-700">Franchise</span>
        <span class="px-2 py-1 rounded bg-gray-100 text-gray-700">Nonprofit</span>
        <span class="px-2 py-1 rounded bg-gray-100 text-gray-700">Startup</span>
        <span class="px-2 py-1 rounded font-semibold bg-green-500 text-white">Online</span>
      </div>
    </section>

    <!-- Sectors Section (moved here) -->
    <section class="mt-4">
      <div class="overflow-x-auto pb-2">
        <ul class="flex gap-3 min-w-full px-1">
          <!-- Example sectors, replace with dynamic rendering in production -->
          <li>
            <button class="flex flex-col items-center group focus:outline-none">
              <span class="flex items-center justify-center w-16 h-16 rounded-full bg-blue-100 group-hover:bg-blue-200 transition-all">
                <span class="material-icons-outlined text-2xl text-blue-500">spa</span>
              </span>
              <span class="text-xs text-gray-700 mt-1">Beauty</span>
            </button>
          </li>
          <li>
            <button class="flex flex-col items-center group focus:outline-none">
              <span class="flex items-center justify-center w-16 h-16 rounded-full bg-green-100 group-hover:bg-green-200 transition-all">
                <span class="material-icons-outlined text-2xl text-green-500">devices</span>
              </span>
              <span class="text-xs text-gray-700 mt-1">Tech</span>
            </button>
          </li>
          <li>
            <button class="flex flex-col items-center group focus:outline-none">
              <span class="flex items-center justify-center w-16 h-16 rounded-full bg-yellow-100 group-hover:bg-yellow-200 transition-all">
                <span class="material-icons-outlined text-2xl text-yellow-500">restaurant</span>
              </span>
              <span class="text-xs text-gray-700 mt-1">Food</span>
            </button>
          </li>
          <li>
            <button class="flex flex-col items-center group focus:outline-none">
              <span class="flex items-center justify-center w-16 h-16 rounded-full bg-pink-100 group-hover:bg-pink-200 transition-all">
                <span class="material-icons-outlined text-2xl text-pink-500">shopping_bag</span>
              </span>
              <span class="text-xs text-gray-700 mt-1">Fashion</span>
            </button>
          </li>
          <li>
            <button class="flex flex-col items-center group focus:outline-none">
              <span class="flex items-center justify-center w-16 h-16 rounded-full bg-red-100 group-hover:bg-red-200 transition-all">
                <span class="material-icons-outlined text-2xl text-red-500">local_hospital</span>
              </span>
              <span class="text-xs text-gray-700 mt-1">Health</span>
            </button>
          </li>
          <li>
            <button class="flex flex-col items-center group focus:outline-none">
              <span class="flex items-center justify-center w-16 h-16 rounded-full bg-indigo-100 group-hover:bg-indigo-200 transition-all">
                <span class="material-icons-outlined text-2xl text-indigo-500">school</span>
              </span>
              <span class="text-xs text-gray-700 mt-1">Education</span>
            </button>
          </li>
          <li>
            <button class="flex flex-col items-center group focus:outline-none">
              <span class="flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 group-hover:bg-gray-200 transition-all">
                <span class="material-icons-outlined text-2xl text-gray-500">miscellaneous_services</span>
              </span>
              <span class="text-xs text-gray-700 mt-1">Services</span>
            </button>
          </li>
          <li>
            <button class="flex flex-col items-center group focus:outline-none">
              <span class="flex items-center justify-center w-16 h-16 rounded-full bg-orange-100 group-hover:bg-orange-200 transition-all">
                <span class="material-icons-outlined text-2xl text-orange-500">home</span>
              </span>
              <span class="text-xs text-gray-700 mt-1">Real Estate</span>
            </button>
          </li>
          <li>
            <button class="flex flex-col items-center group focus:outline-none">
              <span class="flex items-center justify-center w-16 h-16 rounded-full bg-cyan-100 group-hover:bg-cyan-200 transition-all">
                <span class="material-icons-outlined text-2xl text-cyan-500">flight</span>
              </span>
              <span class="text-xs text-gray-700 mt-1">Travel</span>
            </button>
          </li>
        </ul>
      </div>
    </section>

    <!-- Search, Filter, Sort Section (only one instance, directly below sectors) -->
    <section class="w-full">
      <div class="relative max-w-xl mx-auto mb-3 flex items-center">
        <input type="text" placeholder="Search products, services, or segments" class="w-full pl-12 pr-4 py-3 rounded-full border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white shadow-sm transition placeholder-gray-400 text-sm"/>
        <span class="material-icons-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">search</span>
        <div class="flex gap-2 ml-2">
          <button id="openFilterModal" class="p-3 rounded-full bg-blue-100 text-blue-700 hover:bg-blue-200 transition focus:outline-none">
            <span class="material-icons-outlined text-2xl">tune</span>
          </button>
          <button class="p-3 rounded-full bg-gray-100 text-gray-700 hover:bg-blue-100 hover:text-blue-700 transition focus:outline-none">
            <span class="material-icons-outlined text-2xl">swap_vert</span>
          </button>
        </div>
      </div>
    </section>

    <!-- Stories Section (below nav/overview, only one instance remains) -->
    <section class="mt-6">
      <div class="flex gap-4 overflow-x-auto pb-2 px-1">
        <!-- Add Story -->
        <div class="flex flex-col items-center">
          <button class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center border-2 border-blue-400 text-blue-500 hover:bg-blue-200 transition-all">
            <span class="material-icons-outlined text-3xl">add</span>
          </button>
          <span class="text-xs text-gray-700 mt-1">Add Story</span>
        </div>
        <!-- Example Stories -->
        <div class="flex flex-col items-center">
          <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Story" class="w-16 h-16 rounded-full border-2 border-blue-400 object-cover"/>
          <span class="text-xs text-gray-700 mt-1 truncate w-16 text-center">John</span>
        </div>
        <div class="flex flex-col items-center">
          <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Story" class="w-16 h-16 rounded-full border-2 border-pink-400 object-cover"/>
          <span class="text-xs text-gray-700 mt-1 truncate w-16 text-center">Emily</span>
        </div>
        <div class="flex flex-col items-center">
          <img src="https://randomuser.me/api/portraits/men/45.jpg" alt="Story" class="w-16 h-16 rounded-full border-2 border-green-400 object-cover"/>
          <span class="text-xs text-gray-700 mt-1 truncate w-16 text-center">Mike</span>
        </div>
        <div class="flex flex-col items-center">
          <img src="https://randomuser.me/api/portraits/women/46.jpg" alt="Story" class="w-16 h-16 rounded-full border-2 border-yellow-400 object-cover"/>
          <span class="text-xs text-gray-700 mt-1 truncate w-16 text-center">Sara</span>
        </div>
        <!-- Four more stories -->
        <div class="flex flex-col items-center">
          <img src="https://randomuser.me/api/portraits/men/50.jpg" alt="Story" class="w-16 h-16 rounded-full border-2 border-purple-400 object-cover"/>
          <span class="text-xs text-gray-700 mt-1 truncate w-16 text-center">Alex</span>
        </div>
        <div class="flex flex-col items-center">
          <img src="https://randomuser.me/api/portraits/women/51.jpg" alt="Story" class="w-16 h-16 rounded-full border-2 border-red-400 object-cover"/>
          <span class="text-xs text-gray-700 mt-1 truncate w-16 text-center">Nina</span>
        </div>
        <div class="flex flex-col items-center">
          <img src="https://randomuser.me/api/portraits/men/52.jpg" alt="Story" class="w-16 h-16 rounded-full border-2 border-teal-400 object-cover"/>
          <span class="text-xs text-gray-700 mt-1 truncate w-16 text-center">Chris</span>
        </div>
        <div class="flex flex-col items-center">
          <img src="https://randomuser.me/api/portraits/women/53.jpg" alt="Story" class="w-16 h-16 rounded-full border-2 border-orange-400 object-cover"/>
          <span class="text-xs text-gray-700 mt-1 truncate w-16 text-center">Lily</span>
        </div>
      </div>
    </section>

    <!-- Sticky Navigation Bar -->
    <nav class="sticky top-0 z-10 bg-white border-b border-gray-100 shadow-sm overflow-x-auto whitespace-nowrap">
      <ul class="flex flex-nowrap justify-center gap-2 py-2 text-sm font-medium min-w-full border-b border-gray-200" style="scrollbar-width: none; -ms-overflow-style: none;">
        <li><a href="#overview" class="px-3 py-1 rounded hover:bg-blue-50 transition border-b-2 border-blue-500 text-blue-600 font-semibold">Overview</a></li>
        <li><a href="#departments" class="px-3 py-1 rounded hover:bg-blue-50 transition">Departments</a></li>
        <li><a href="#services" class="px-3 py-1 rounded hover:bg-blue-50 transition">Services</a></li>
        <li><a href="#products" class="px-3 py-1 rounded hover:bg-blue-50 transition">Products</a></li>
        <li><a href="#media" class="px-3 py-1 rounded hover:bg-blue-50 transition">Media</a></li>
        <li><a href="#offers" class="px-3 py-1 rounded hover:bg-blue-50 transition">Offers</a></li>
        <li><a href="#reviews" class="px-3 py-1 rounded hover:bg-blue-50 transition">Reviews</a></li>
        <li><a href="#faqs" class="px-3 py-1 rounded hover:bg-blue-50 transition">FAQs</a></li>
        <li><a href="#contact" class="px-3 py-1 rounded hover:bg-blue-50 transition">Contact</a></li>
      </ul>
      <style>
        nav ul::-webkit-scrollbar { display: none; }
        nav { scrollbar-width: none; -ms-overflow-style: none; }
      </style>
    </nav>


    <!-- Filter Modal Popup (hidden by default) -->
    <div id="filterModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-30 hidden">
      <div class="bg-white rounded-2xl shadow-xl w-full max-w-3xl mx-2 p-0 relative flex flex-col sm:flex-row overflow-hidden">
        <button id="closeFilterModal" class="absolute top-3 right-3 p-2 rounded-full bg-gray-100 text-gray-700 hover:bg-red-100 hover:text-red-700 transition focus:outline-none z-10">
          <span class="material-icons-outlined text-lg">close</span>
        </button>
        <!-- Popup Header: Title, Search, Sort, Clear All -->
        <div class="w-full sm:w-64 bg-gray-50 flex flex-col sticky top-0 z-10 p-4 border-b border-gray-100">
          <h2 class="text-lg font-bold mb-3">Filter Categories</h2>
          <div class="flex flex-col gap-2 mb-2">
            <div class="relative">
              <input type="text" placeholder="Search categories..." class="w-full pl-10 pr-4 py-2 rounded-full border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white shadow-sm transition placeholder-gray-400 text-sm"/>
              <span class="material-icons-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
            </div>
            <div class="flex gap-2 items-center w-full">
              <label for="modalSort" class="text-xs text-gray-500 whitespace-nowrap">Sort by:</label>
              <select id="modalSort" class="flex-1 min-w-0 px-3 py-2 rounded-full border border-gray-200 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                <option>Recommended</option>
                <option>Popular</option>
                <option>Newest</option>
                <option>Price Low to High</option>
                <option>Price High to Low</option>
              </select>
              <button class="px-3 py-2 rounded-full bg-gray-100 text-gray-700 text-xs font-medium hover:bg-red-100 hover:text-red-700 transition flex items-center gap-1 whitespace-nowrap">
                <span class="material-icons-outlined text-sm">clear_all</span> Clear All
              </button>
            </div>
          </div>
        </div>
        <!-- Vertical Category Tabs -->
        <div class="w-full sm:w-64 bg-gray-50 p-4 overflow-y-auto" style="scrollbar-width: none; -ms-overflow-style: none;">
          <ul class="flex sm:flex-col gap-2 min-w-0">
            <li><button class="w-full px-4 py-2 rounded-full bg-blue-100 text-blue-700 font-medium hover:bg-blue-200 transition text-left truncate">Category 1</button></li>
            <li><button class="w-full px-4 py-2 rounded-full bg-gray-100 text-gray-700 font-medium hover:bg-blue-100 hover:text-blue-700 transition text-left truncate">Very Long Category Name Example 2</button></li>
            <li><button class="w-full px-4 py-2 rounded-full bg-gray-100 text-gray-700 font-medium hover:bg-blue-100 hover:text-blue-700 transition text-left truncate">Category 3</button></li>
            <li><button class="w-full px-4 py-2 rounded-full bg-gray-100 text-gray-700 font-medium hover:bg-blue-100 hover:text-blue-700 transition text-left truncate">Category 4</button></li>
            <li><button class="w-full px-4 py-2 rounded-full bg-gray-100 text-gray-700 font-medium hover:bg-blue-100 hover:text-blue-700 transition text-left truncate">Category 5</button></li>
            <li><button class="w-full px-4 py-2 rounded-full bg-gray-100 text-gray-700 font-medium hover:bg-blue-100 hover:text-blue-700 transition text-left truncate">Category 6</button></li>
          </ul>
          <style>
            #filterModal .overflow-y-auto::-webkit-scrollbar { display: none; }
          </style>
        </div>
        <!-- Placeholder for future filter options -->
        <div class="flex-1 p-6 flex items-center justify-center min-w-0">
          <span class="text-gray-400 text-sm text-center">(Filter options will appear here)</span>
        </div>
      </div>
    </div>

        <script>
          // Modal open/close logic
          document.getElementById('openFilterModal').onclick = function() {
            document.getElementById('filterModal').classList.remove('hidden');
          };
          document.getElementById('closeFilterModal').onclick = function() {
            document.getElementById('filterModal').classList.add('hidden');
          };
        </script>

        <!-- Business Posts Timeline -->
        <section class="mt-6 space-y-6">
          <!-- Post Card 1 -->
          <article class="bg-white rounded-2xl shadow-sm p-4 flex flex-col gap-3">
            <div class="flex items-center gap-3">
              <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Business Logo" class="w-10 h-10 rounded-full object-cover"/>
              <div>
                <div class="font-semibold text-sm">Business Name</div>
                <div class="text-xs text-gray-400">2 hours ago</div>
              </div>
            </div>
            <div class="text-gray-700 text-sm line-clamp-3">Excited to announce our new product launch! Check out the details and let us know your thoughts. #innovation #business</div>
            <img src="https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?auto=format&fit=crop&w=600&q=80" alt="Post Media" class="rounded-xl w-full max-h-60 object-cover"/>
            <div class="flex gap-6 pt-2 text-gray-500 text-sm">
              <button class="flex items-center gap-1 hover:text-blue-500 transition"><span class="material-icons-outlined text-base">thumb_up</span> Like</button>
              <button class="flex items-center gap-1 hover:text-blue-500 transition"><span class="material-icons-outlined text-base">chat_bubble_outline</span> Comment</button>
              <button class="flex items-center gap-1 hover:text-blue-500 transition"><span class="material-icons-outlined text-base">share</span> Share</button>
            </div>
          </article>
          <!-- Post Card 2 -->
          <article class="bg-white rounded-2xl shadow-sm p-4 flex flex-col gap-3">
            <div class="flex items-center gap-3">
              <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Business Logo" class="w-10 h-10 rounded-full object-cover"/>
              <div>
                <div class="font-semibold text-sm">Business Name</div>
                <div class="text-xs text-gray-400">Yesterday</div>
              </div>
            </div>
            <div class="text-gray-700 text-sm line-clamp-3">We're grateful for all the support from our amazing customers! Here's a quick look at our team celebrating a recent milestone.</div>
            <img src="https://images.unsplash.com/photo-1504384308090-c894fdcc538d?auto=format&fit=crop&w=600&q=80" alt="Post Media" class="rounded-xl w-full max-h-60 object-cover"/>
            <div class="flex gap-6 pt-2 text-gray-500 text-sm">
              <button class="flex items-center gap-1 hover:text-blue-500 transition"><span class="material-icons-outlined text-base">thumb_up</span> Like</button>
              <button class="flex items-center gap-1 hover:text-blue-500 transition"><span class="material-icons-outlined text-base">chat_bubble_outline</span> Comment</button>
              <button class="flex items-center gap-1 hover:text-blue-500 transition"><span class="material-icons-outlined text-base">share</span> Share</button>
            </div>
          </article>
          <!-- Post Card 3 -->
          <article class="bg-white rounded-2xl shadow-sm p-4 flex flex-col gap-3">
            <div class="flex items-center gap-3">
              <img src="https://randomuser.me/api/portraits/men/45.jpg" alt="Business Logo" class="w-10 h-10 rounded-full object-cover"/>
              <div>
                <div class="font-semibold text-sm">Business Name</div>
                <div class="text-xs text-gray-400">3 days ago</div>
              </div>
            </div>
            <div class="text-gray-700 text-sm line-clamp-3">Don't miss our limited-time offer! Save big on select services this week only. Visit our website for more info.</div>
            <div class="flex gap-6 pt-2 text-gray-500 text-sm">
              <button class="flex items-center gap-1 hover:text-blue-500 transition"><span class="material-icons-outlined text-base">thumb_up</span> Like</button>
              <button class="flex items-center gap-1 hover:text-blue-500 transition"><span class="material-icons-outlined text-base">chat_bubble_outline</span> Comment</button>
              <button class="flex items-center gap-1 hover:text-blue-500 transition"><span class="material-icons-outlined text-base">share</span> Share</button>
            </div>
          </article>
        </section>

      </div>
      <!-- Right: Offers & Promotions -->
      <aside class="w-full lg:w-72 flex-shrink-0">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 max-h-80 overflow-y-auto">
          <h3 class="text-sm font-semibold mb-3">Current Offers</h3>
          <div class="space-y-3">
            <!-- Offer Item -->
            <div class="p-3 rounded-xl bg-blue-50 flex flex-col gap-1">
              <div class="flex items-center gap-2 flex-wrap">
                <span class="text-xs font-bold bg-blue-500 text-white px-2 py-0.5 rounded-full">-20%</span>
                <span class="font-medium text-sm truncate">Offer Title 1</span>
              </div>
              <span class="text-xs text-gray-600 truncate">Short note about the offer.</span>
              <div class="flex items-center justify-between mt-1 flex-wrap gap-2">
                <span class="text-xs text-gray-400">Expires: 2024-12-31</span>
                <button class="px-3 py-1 rounded-full bg-blue-500 text-white text-xs font-medium hover:bg-blue-600 transition">Claim Offer</button>
              </div>
            </div>
            <!-- Offer Item -->
            <div class="p-3 rounded-xl bg-blue-50 flex flex-col gap-1">
              <div class="flex items-center gap-2 flex-wrap">
                <span class="text-xs font-bold bg-blue-500 text-white px-2 py-0.5 rounded-full">-10%</span>
                <span class="font-medium text-sm truncate">Offer Title 2</span>
              </div>
              <span class="text-xs text-gray-600 truncate">Short note about the offer.</span>
              <div class="flex items-center justify-between mt-1 flex-wrap gap-2">
                <span class="text-xs text-gray-400">Expires: 2024-11-30</span>
                <button class="px-3 py-1 rounded-full bg-blue-500 text-white text-xs font-medium hover:bg-blue-600 transition">Use Now</button>
              </div>
            </div>
          </div>
        </div>
      </aside>
    </section>
 
@endsection