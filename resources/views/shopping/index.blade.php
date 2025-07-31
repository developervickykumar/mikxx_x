

  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
 
  <style>
    
    .cat-scroll { scrollbar-width: none; -ms-overflow-style: none; }
    .cat-scroll::-webkit-scrollbar { display: none; }
    .product-scroll { scrollbar-width: none; -ms-overflow-style: none; }
    .product-scroll::-webkit-scrollbar { display: none; }
    .cat-btn.active, .filter-btn.active { background: #059669; color: #fff; }
    .cat-btn:hover, .filter-btn:hover { background: #e5e7eb; color: #374151; }
    .promo-card { background: linear-gradient(90deg, #d1fae5 60%, #a7f3d0 100%); }
    .deal-card { background: linear-gradient(90deg, #d1fae5 60%, #a7f3d0 100%); }
    .shop-scroll {
      scrollbar-width: none;
      -ms-overflow-style: none;
    }
    .shop-scroll::-webkit-scrollbar {
      display: none;
    }
    .dept-scroll {
      scrollbar-width: none;
      -ms-overflow-style: none;
    }
    .dept-scroll::-webkit-scrollbar {
      display: none;
    }
    .btn-emerald {
      background-color: #059669;
      color: white;
      border-radius: 9999px;
      transition: all 0.3s ease;
    }
    .btn-emerald:hover {
      background-color: #047857;
    }
    .dept-btn {
      background-color: #f3f4f6;
      color: #374151;
      transition: all 0.3s ease;
    }
    .dept-btn:hover {
      background-color: #e5e7eb;
    }
    .dept-btn.active {
      background-color: #059669;
      color: white;
    }
    .product-card {
      transition: all 0.3s ease;
      border: 1px solid #e5e7eb;
    }
    .product-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
      border-color: #059669;
    }
    .product-image {
      transition: all 0.3s ease;
    }
    .product-card:hover .product-image {
      transform: scale(1.1);
    }
    .product-badge {
      position: absolute;
      top: 1rem;
      left: 1rem;
      z-index: 10;
    }
    .product-actions {
      position: absolute;
      top: 1rem;
      right: 1rem;
      opacity: 0;
      transition: all 0.3s ease;
    }
    .product-card:hover .product-actions {
      opacity: 1;
    }
    .cat-btn {
      transition: all 0.3s ease;
      transform: translateY(0);
    }
    .cat-btn:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
      background: #059669;
      color: white;
    }
    .cat-btn img {
      transition: all 0.3s ease;
    }
    .cat-btn:hover img {
      transform: scale(1.1);
    }
    .main-tab-btn {
      background-color: white;
      color: #374151;
      border-radius: 9999px;
      transition: all 0.3s ease;
      border: 1px solid #e5e7eb;
    }
    .main-tab-btn:hover {
      background-color: #1e293b;
      color: white;
    }
    .main-tab-btn.active {
      background-color: #2563eb;
      color: white;
      border-color: #2563eb;
    }
    .form-label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: 500;
      color: #374151;
    }
    .form-input {
      width: 100%;
      padding: 0.75rem 1rem;
      border: 1px solid #e5e7eb;
      border-radius: 0.5rem;
      transition: all 0.3s ease;
    }
    .form-input:focus {
      outline: none;
      border-color: #059669;
      box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
    }
  </style> 
  
   
  <!-- Header -->
  <div class="bg-white shadow sticky top-0 z-50">
    <div class="max-w-7xl mx-auto flex items-center justify-between px-4 py-3">
      <div class="flex items-center gap-3">
        <span class="material-icons-outlined text-3xl text-emerald-600">shopping_basket</span>
        <span class="font-bold text-xl text-emerald-700">EcoGrocery</span>
      </div>
      <div class="flex-1 mx-6">
        <label class="form-label">Search Products</label>
        <input type="text" placeholder="Type to search..." class="form-input">
      </div>
      <div class="flex items-center gap-4">
        <button class="p-2 rounded-full hover:bg-gray-100">
          <span class="material-icons-outlined">person</span>
        </button>
        <button class="p-2 rounded-full hover:bg-gray-100">
          <span class="material-icons-outlined">shopping_cart</span>
        </button>
      </div>
    </div>
  </div>

  <!-- Department Capsules -->
  <section class="max-w-7xl mx-auto mt-4">
    <div class="flex gap-3 overflow-x-auto pb-2 px-4 dept-scroll">
      <button class="dept-btn flex flex-col items-center px-4 py-3 rounded-xl font-semibold hover:shadow-md min-w-[6rem]">
        <span class="material-icons-outlined text-2xl">local_grocery_store</span>
        <span class="text-xs mt-1">Grocery</span>
      </button>
      <button class="dept-btn flex flex-col items-center px-4 py-3 rounded-xl font-semibold hover:shadow-md min-w-[6rem]">
        <span class="material-icons-outlined text-2xl">electrical_services</span>
        <span class="text-xs mt-1">Electronics</span>
      </button>
      <button class="dept-btn flex flex-col items-center px-4 py-3 rounded-xl font-semibold hover:shadow-md min-w-[6rem]">
        <span class="material-icons-outlined text-2xl">checkroom</span>
        <span class="text-xs mt-1">Fashion</span>
      </button>
      <button class="dept-btn flex flex-col items-center px-4 py-3 rounded-xl font-semibold hover:shadow-md min-w-[6rem]">
        <span class="material-icons-outlined text-2xl">home_furnishings</span>
        <span class="text-xs mt-1">Home Decor</span>
      </button>
      <button class="dept-btn flex flex-col items-center px-4 py-3 rounded-xl font-semibold hover:shadow-md min-w-[6rem]">
        <span class="material-icons-outlined text-2xl">diamond</span>
        <span class="text-xs mt-1">Jewelry</span>
      </button>
      <button class="dept-btn flex flex-col items-center px-4 py-3 rounded-xl font-semibold hover:shadow-md min-w-[6rem]">
        <span class="material-icons-outlined text-2xl">toys</span>
        <span class="text-xs mt-1">Toys</span>
      </button>
      <button class="dept-btn flex flex-col items-center px-4 py-3 rounded-xl font-semibold hover:shadow-md min-w-[6rem]">
        <span class="material-icons-outlined text-2xl">book</span>
        <span class="text-xs mt-1">Books</span>
      </button>
      <button class="dept-btn flex flex-col items-center px-4 py-3 rounded-xl font-semibold hover:shadow-md min-w-[6rem]">
        <span class="material-icons-outlined text-2xl">sports_soccer</span>
        <span class="text-xs mt-1">Sports</span>
      </button>
      <button class="dept-btn flex flex-col items-center px-4 py-3 rounded-xl font-semibold hover:shadow-md min-w-[6rem]">
        <span class="material-icons-outlined text-2xl">checkroom</span>
        <span class="text-xs mt-1">Shoes</span>
      </button>
      <button class="dept-btn flex flex-col items-center px-4 py-3 rounded-xl font-semibold hover:shadow-md min-w-[6rem]">
        <span class="material-icons-outlined text-2xl">local_pharmacy</span>
        <span class="text-xs mt-1">Pharmacy</span>
      </button>
      <button class="dept-btn flex flex-col items-center px-4 py-3 rounded-xl font-semibold hover:shadow-md min-w-[6rem]">
        <span class="material-icons-outlined text-2xl">factory</span>
        <span class="text-xs mt-1">Industrial Products</span>
      </button>
    </div>
  </section>

  <!-- Hero Banner -->
  <section class="bg-black py-8 px-4 flex flex-col md:flex-row items-center justify-between max-w-7xl mx-auto rounded-2xl mt-6 relative">
    <div class="flex-1 mb-6 md:mb-0 pr-0 md:pr-8">
      <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">Discover Amazing Shopping Deals Today!</h1>
      <p class="text-gray-300 mb-4">Enjoy up to 50% off on top brands and categories!</p>
      <div class="flex flex-col md:flex-row gap-3 mb-4 w-full">
        <div class="relative flex-1">
          <label class="form-label">Search Products</label>
          <span class="material-icons-outlined absolute left-3 top-[2.5rem] text-gray-400">search</span>
          <input type="text" placeholder="Search for products, brands, or shops..." class="form-input pl-10 bg-gray-900 text-white border-gray-700">
        </div>
        <button id="openFilterBtn" class="main-tab-btn px-5 py-3 font-semibold flex items-center justify-center gap-2">
          <span class="material-icons-outlined">tune</span> Advanced Filter
        </button>
      </div>
      <button class="btn-emerald px-6 py-3 font-semibold">Shop now</button>
    </div>
    <img src="https://images.unsplash.com/photo-1519125323398-675f0ddb6308?auto=format&fit=crop&w=400&q=80" alt="Shopping Banner" class="w-48 h-48 object-cover rounded-full border-4 border-gray-800 shadow-lg">
    <!-- Advanced Filter Modal -->
    <div id="filterModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
      <div class="bg-white rounded-xl p-8 w-full max-w-md relative">
        <button class="absolute top-2 right-2 text-gray-400 hover:text-gray-700" onclick="closeFilterModal()">
          <span class="material-icons-outlined">close</span>
        </button>
        <h2 class="text-xl font-bold mb-4">Advanced Filter</h2>
        <form class="space-y-4">
          <div>
            <label class="block font-medium mb-1">Price Range</label>
            <div class="flex gap-2">
              <input type="number" placeholder="Min" class="w-1/2 px-3 py-2 border rounded">
              <input type="number" placeholder="Max" class="w-1/2 px-3 py-2 border rounded">
            </div>
          </div>
          <div>
            <label class="block font-medium mb-1">Brand</label>
            <input type="text" placeholder="Brand name" class="w-full px-3 py-2 border rounded">
          </div>
          <div>
            <label class="block font-medium mb-1">Rating</label>
            <div class="flex gap-2">
              <label><input type="checkbox" class="mr-1">4★ & above</label>
              <label><input type="checkbox" class="mr-1">3★ & above</label>
            </div>
          </div>
          <div>
            <label class="block font-medium mb-1">Department</label>
            <div class="flex flex-wrap gap-2">
              <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm">Grocery</span>
              <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-sm">Electronics</span>
              <span class="px-3 py-1 bg-pink-100 text-pink-700 rounded-full text-sm">Fashion</span>
              <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm">Home Decor</span>
              <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm">Jewelry</span>
            </div>
          </div>
          <button type="submit" class="btn-emerald w-full px-4 py-2 font-semibold">Apply Filter</button>
        </form>
      </div>
    </div>
  </section>

  <!-- Featured Categories (moved below banner) -->
  <section class="max-w-7xl mx-auto mt-4">
    <h2 class="text-xl font-bold mb-4 px-4">Featured Categories</h2>
    <div class="flex gap-4 overflow-x-auto pb-2 cat-scroll px-4">
      <!-- Category 1 -->
      <div class="flex flex-col items-center min-w-[8rem]">
        <button class="cat-btn flex flex-col items-center bg-gray-100 text-gray-700 rounded-xl p-2">
          <img src="https://images.unsplash.com/photo-1502741338009-cac2772e18bc?auto=format&fit=crop&w=80&q=80" class="w-16 h-16 rounded-full object-cover mb-1">
          <span class="text-sm font-medium">Vegetables</span>
        </button>
      </div>
      <!-- Category 2 -->
      <div class="flex flex-col items-center min-w-[8rem]">
        <button class="cat-btn flex flex-col items-center bg-gray-100 text-gray-700 rounded-xl p-2">
          <img src="https://images.unsplash.com/photo-1464306076886-debca5e8a6b0?auto=format&fit=crop&w=80&q=80" class="w-16 h-16 rounded-full object-cover mb-1">
          <span class="text-sm font-medium">Fruits</span>
        </button>
      </div>
      <!-- Category 3 -->
      <div class="flex flex-col items-center min-w-[8rem]">
        <button class="cat-btn flex flex-col items-center bg-gray-100 text-gray-700 rounded-xl p-2">
          <img src="https://images.unsplash.com/photo-1519864600265-abb23847ef2c?auto=format&fit=crop&w=80&q=80" class="w-16 h-16 rounded-full object-cover mb-1">
          <span class="text-sm font-medium">Dairy</span>
        </button>
      </div>
      <!-- Category 4 -->
      <div class="flex flex-col items-center min-w-[8rem]">
        <button class="cat-btn flex flex-col items-center bg-gray-100 text-gray-700 rounded-xl p-2">
          <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=80&q=80" class="w-16 h-16 rounded-full object-cover mb-1">
          <span class="text-sm font-medium">Bakery</span>
        </button>
      </div>
      <!-- Category 5 -->
      <div class="flex flex-col items-center min-w-[8rem]">
        <button class="cat-btn flex flex-col items-center bg-gray-100 text-gray-700 rounded-xl p-2">
          <img src="https://images.unsplash.com/photo-1550547660-d9450f859349?auto=format&fit=crop&w=80&q=80" class="w-16 h-16 rounded-full object-cover mb-1">
          <span class="text-sm font-medium">Meat</span>
        </button>
      </div>
      <!-- Category 6 -->
      <div class="flex flex-col items-center min-w-[8rem]">
        <button class="cat-btn flex flex-col items-center bg-gray-100 text-gray-700 rounded-xl p-2">
          <img src="https://images.unsplash.com/photo-1528496382677-c85d11904886?auto=format&fit=crop&w=80&q=80" class="w-16 h-16 rounded-full object-cover mb-1">
          <span class="text-sm font-medium">Beverages</span>
        </button>
      </div>
      <!-- Category 7 -->
      <div class="flex flex-col items-center min-w-[8rem]">
        <button class="cat-btn flex flex-col items-center bg-gray-100 text-gray-700 rounded-xl p-2">
          <img src="https://images.unsplash.com/photo-1526413332786-5213c3585015?auto=format&fit=crop&w=80&q=80" class="w-16 h-16 rounded-full object-cover mb-1">
          <span class="text-sm font-medium">Beauty</span>
        </button>
      </div>
      <!-- Category 8 -->
      <div class="flex flex-col items-center min-w-[8rem]">
        <button class="cat-btn flex flex-col items-center bg-gray-100 text-gray-700 rounded-xl p-2">
          <img src="https://images.unsplash.com/photo-1525301074623-9712528428e3?auto=format&fit=crop&w=80&q=80" class="w-16 h-16 rounded-full object-cover mb-1">
          <span class="text-sm font-medium">Stationery</span>
        </button>
      </div>
    </div>
  </section>

  <!-- Shops Near You Section -->
  <section class="max-w-7xl mx-auto mt-8 px-4">
    <h2 class="text-2xl font-bold mb-6">Shops Near You</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
      <!-- Shop 1 -->
      <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="relative">
          <div class="shop-images relative h-48 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=400&q=80" class="w-full h-full object-cover transition-transform duration-300 hover:scale-110">
            <div class="absolute bottom-2 right-2 flex gap-1">
              <span class="bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded-full">1/3</span>
            </div>
          </div>
          <div class="absolute top-2 right-2 flex gap-1">
            <button class="bg-white p-1 rounded-full shadow hover:bg-gray-100">
              <span class="material-icons-outlined text-gray-600">favorite_border</span>
            </button>
            <button class="bg-white p-1 rounded-full shadow hover:bg-gray-100">
              <span class="material-icons-outlined text-gray-600">share</span>
            </button>
          </div>
        </div>
        <div class="p-4">
          <div class="flex items-start justify-between mb-2">
            <div>
              <div class="font-bold text-lg mb-1">FreshMart</div>
              <div class="text-emerald-600 text-sm">0.8 km away</div>
            </div>
            <div class="flex items-center gap-1 bg-emerald-100 px-2 py-1 rounded">
              <span class="material-icons-outlined text-yellow-400 text-base">star</span>
              <span class="text-emerald-700 font-semibold">4.7</span>
            </div>
          </div>
          <div class="text-gray-600 text-sm mb-3">Fresh vegetables, fruits, and groceries delivered to your doorstep.</div>
          <div class="flex items-center gap-2 mb-3">
            <span class="px-2 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs">Vegetables</span>
            <span class="px-2 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs">Fruits</span>
            <span class="px-2 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs">Dairy</span>
          </div>
          <div class="flex items-center justify-between text-xs text-gray-500 border-t pt-3 mt-3">
            <span class="flex items-center gap-1"><span class="material-icons-outlined text-pink-500 text-base">favorite</span>210</span>
            <span class="flex items-center gap-1"><span class="material-icons-outlined text-blue-400 text-base">chat_bubble</span>34</span>
            <span class="flex items-center gap-1"><span class="material-icons-outlined text-gray-400 text-base">visibility</span>1.2k</span>
          </div>
          <button class="w-full mt-3 px-4 py-2 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition flex items-center justify-center gap-2">
            <span class="material-icons-outlined text-base">shopping_cart</span>
            Shop Now
          </button>
        </div>
      </div>

      <!-- Shop 2 -->
      <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="relative">
          <div class="shop-images relative h-48 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=400&q=80" class="w-full h-full object-cover transition-transform duration-300 hover:scale-110">
            <div class="absolute bottom-2 right-2 flex gap-1">
              <span class="bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded-full">1/3</span>
            </div>
          </div>
          <div class="absolute top-2 right-2 flex gap-1">
            <button class="bg-white p-1 rounded-full shadow hover:bg-gray-100">
              <span class="material-icons-outlined text-gray-600">favorite_border</span>
            </button>
            <button class="bg-white p-1 rounded-full shadow hover:bg-gray-100">
              <span class="material-icons-outlined text-gray-600">share</span>
            </button>
          </div>
        </div>
        <div class="p-4">
          <div class="flex items-start justify-between mb-2">
            <div>
              <div class="font-bold text-lg mb-1">Green Basket</div>
              <div class="text-emerald-600 text-sm">1.2 km away</div>
            </div>
            <div class="flex items-center gap-1 bg-emerald-100 px-2 py-1 rounded">
              <span class="material-icons-outlined text-yellow-400 text-base">star</span>
              <span class="text-emerald-700 font-semibold">4.5</span>
            </div>
          </div>
          <div class="text-gray-600 text-sm mb-3">Organic produce and natural products for a healthy lifestyle.</div>
          <div class="flex items-center gap-2 mb-3">
            <span class="px-2 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs">Organic</span>
            <span class="px-2 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs">Natural</span>
            <span class="px-2 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs">Healthy</span>
          </div>
          <div class="flex items-center justify-between text-xs text-gray-500 border-t pt-3 mt-3">
            <span class="flex items-center gap-1"><span class="material-icons-outlined text-pink-500 text-base">favorite</span>180</span>
            <span class="flex items-center gap-1"><span class="material-icons-outlined text-blue-400 text-base">chat_bubble</span>22</span>
            <span class="flex items-center gap-1"><span class="material-icons-outlined text-gray-400 text-base">visibility</span>900</span>
          </div>
          <button class="w-full mt-3 px-4 py-2 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition flex items-center justify-center gap-2">
            <span class="material-icons-outlined text-base">shopping_cart</span>
            Shop Now
          </button>
        </div>
      </div>

      <!-- Shop 3 -->
      <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="relative">
          <div class="shop-images relative h-48 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1550547660-d9450f859349?auto=format&fit=crop&w=400&q=80" class="w-full h-full object-cover transition-transform duration-300 hover:scale-110">
            <div class="absolute bottom-2 right-2 flex gap-1">
              <span class="bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded-full">1/3</span>
            </div>
          </div>
          <div class="absolute top-2 right-2 flex gap-1">
            <button class="bg-white p-1 rounded-full shadow hover:bg-gray-100">
              <span class="material-icons-outlined text-gray-600">favorite_border</span>
            </button>
            <button class="bg-white p-1 rounded-full shadow hover:bg-gray-100">
              <span class="material-icons-outlined text-gray-600">share</span>
            </button>
          </div>
        </div>
        <div class="p-4">
          <div class="flex items-start justify-between mb-2">
            <div>
              <div class="font-bold text-lg mb-1">Fruit Hub</div>
              <div class="text-emerald-600 text-sm">1.0 km away</div>
            </div>
            <div class="flex items-center gap-1 bg-emerald-100 px-2 py-1 rounded">
              <span class="material-icons-outlined text-yellow-400 text-base">star</span>
              <span class="text-emerald-700 font-semibold">4.8</span>
            </div>
          </div>
          <div class="text-gray-600 text-sm mb-3">Fresh and exotic fruits from around the world.</div>
          <div class="flex items-center gap-2 mb-3">
            <span class="px-2 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs">Exotic</span>
            <span class="px-2 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs">Seasonal</span>
            <span class="px-2 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs">Fresh</span>
          </div>
          <div class="flex items-center justify-between text-xs text-gray-500 border-t pt-3 mt-3">
            <span class="flex items-center gap-1"><span class="material-icons-outlined text-pink-500 text-base">favorite</span>320</span>
            <span class="flex items-center gap-1"><span class="material-icons-outlined text-blue-400 text-base">chat_bubble</span>40</span>
            <span class="flex items-center gap-1"><span class="material-icons-outlined text-gray-400 text-base">visibility</span>2.1k</span>
          </div>
          <button class="w-full mt-3 px-4 py-2 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition flex items-center justify-center gap-2">
            <span class="material-icons-outlined text-base">shopping_cart</span>
            Shop Now
          </button>
        </div>
      </div>

      <!-- Shop 4 -->
      <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="relative">
          <div class="shop-images relative h-48 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1519864600265-abb23847ef2c?auto=format&fit=crop&w=400&q=80" class="w-full h-full object-cover transition-transform duration-300 hover:scale-110">
            <div class="absolute bottom-2 right-2 flex gap-1">
              <span class="bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded-full">1/3</span>
            </div>
          </div>
          <div class="absolute top-2 right-2 flex gap-1">
            <button class="bg-white p-1 rounded-full shadow hover:bg-gray-100">
              <span class="material-icons-outlined text-gray-600">favorite_border</span>
            </button>
            <button class="bg-white p-1 rounded-full shadow hover:bg-gray-100">
              <span class="material-icons-outlined text-gray-600">share</span>
            </button>
          </div>
        </div>
        <div class="p-4">
          <div class="flex items-start justify-between mb-2">
            <div>
              <div class="font-bold text-lg mb-1">Daily Needs</div>
              <div class="text-emerald-600 text-sm">2.0 km away</div>
            </div>
            <div class="flex items-center gap-1 bg-emerald-100 px-2 py-1 rounded">
              <span class="material-icons-outlined text-yellow-400 text-base">star</span>
              <span class="text-emerald-700 font-semibold">4.2</span>
            </div>
          </div>
          <div class="text-gray-600 text-sm mb-3">Your one-stop shop for all daily essentials and groceries.</div>
          <div class="flex items-center gap-2 mb-3">
            <span class="px-2 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs">Essentials</span>
            <span class="px-2 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs">Groceries</span>
            <span class="px-2 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs">Household</span>
          </div>
          <div class="flex items-center justify-between text-xs text-gray-500 border-t pt-3 mt-3">
            <span class="flex items-center gap-1"><span class="material-icons-outlined text-pink-500 text-base">favorite</span>90</span>
            <span class="flex items-center gap-1"><span class="material-icons-outlined text-blue-400 text-base">chat_bubble</span>10</span>
            <span class="flex items-center gap-1"><span class="material-icons-outlined text-gray-400 text-base">visibility</span>500</span>
          </div>
          <button class="w-full mt-3 px-4 py-2 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition flex items-center justify-center gap-2">
            <span class="material-icons-outlined text-base">shopping_cart</span>
            Shop Now
          </button>
        </div>
      </div>
    </div>
  </section>

  <!-- Promo Cards -->
  <section class="max-w-7xl mx-auto mt-8 grid grid-cols-1 md:grid-cols-2 gap-6 px-4">
    <div class="promo-card rounded-2xl p-6 flex flex-col justify-between">
      <div>
        <div class="font-bold text-lg mb-2">Everyday Fresh Produce</div>
        <div class="text-emerald-700 mb-4">Check out our best picks for you!</div>
        <button class="btn-emerald px-4 py-2 font-semibold">Explore</button>
      </div>
      <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=120&q=80" class="w-24 h-24 object-cover rounded-xl self-end mt-4">
    </div>
    <div class="promo-card rounded-2xl p-6 flex flex-col justify-between bg-pink-100">
      <div>
        <div class="font-bold text-lg mb-2">Make your Breakfast Healthy and Tasty</div>
        <div class="text-emerald-700 mb-4">Start your day with our nutritious options.</div>
        <button class="btn-emerald px-4 py-2 font-semibold">Shop Now</button>
      </div>
      <img src="https://images.unsplash.com/photo-1464306076886-debca5e8a6b0?auto=format&fit=crop&w=120&q=80" class="w-24 h-24 object-cover rounded-xl self-end mt-4">
    </div>
  </section>

  <!-- Product Filters & Grid -->
  <section class="max-w-7xl mx-auto mt-10">
    <h2 class="text-xl font-bold mb-4 px-4">Delicious fresh products</h2>
    <div class="flex gap-2 px-4 mb-4">
      <button class="main-tab-btn px-6 py-2 font-medium active">All</button>
      <button class="main-tab-btn px-6 py-2 font-medium">Vegetables</button>
      <button class="main-tab-btn px-6 py-2 font-medium">Fruits</button>
      <button class="main-tab-btn px-6 py-2 font-medium">Dairy</button>
      <button class="main-tab-btn px-6 py-2 font-medium">Bakery</button>
      <button class="main-tab-btn px-6 py-2 font-medium">Meat</button>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 px-4 product-scroll">
      <!-- Product 1 -->
      <div class="product-card bg-white rounded-xl p-4 flex flex-col items-center relative overflow-hidden">
        <div class="product-badge">
          <span class="bg-emerald-500 text-white text-xs font-bold px-3 py-1 rounded-full">20% OFF</span>
        </div>
        <div class="product-actions flex gap-2">
          <button class="bg-white p-2 rounded-full shadow hover:bg-gray-100">
            <span class="material-icons-outlined text-gray-600">favorite_border</span>
          </button>
          <button class="bg-white p-2 rounded-full shadow hover:bg-gray-100">
            <span class="material-icons-outlined text-gray-600">shopping_cart</span>
          </button>
        </div>
        <div class="w-full aspect-square mb-4 overflow-hidden rounded-lg">
          <img src="https://images.unsplash.com/photo-1502741338009-cac2772e18bc?auto=format&fit=crop&w=120&q=80" class="product-image w-full h-full object-cover">
        </div>
        <div class="w-full">
          <div class="font-semibold text-lg mb-1">Broccoli</div>
          <div class="flex gap-2 my-2">
            <button class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-medium hover:bg-emerald-200">250g</button>
            <button class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-medium hover:bg-gray-200">500g</button>
          </div>
          <div class="flex items-center gap-2 mb-3">
            <span class="text-gray-400 line-through text-sm">$1.50</span>
            <span class="text-emerald-700 font-bold text-lg">$1.2</span>
          </div>
          <button class="btn-emerald w-full px-4 py-2 text-sm font-semibold">Add to Cart</button>
        </div>
      </div>

      <!-- Product 2 -->
      <div class="product-card bg-white rounded-xl p-4 flex flex-col items-center relative overflow-hidden">
        <div class="product-badge">
          <span class="bg-emerald-500 text-white text-xs font-bold px-3 py-1 rounded-full">Buy 1 Get 1</span>
        </div>
        <div class="product-actions flex gap-2">
          <button class="bg-white p-2 rounded-full shadow hover:bg-gray-100">
            <span class="material-icons-outlined text-gray-600">favorite_border</span>
          </button>
          <button class="bg-white p-2 rounded-full shadow hover:bg-gray-100">
            <span class="material-icons-outlined text-gray-600">shopping_cart</span>
          </button>
        </div>
        <div class="w-full aspect-square mb-4 overflow-hidden rounded-lg">
          <img src="https://images.unsplash.com/photo-1464306076886-debca5e8a6b0?auto=format&fit=crop&w=120&q=80" class="product-image w-full h-full object-cover">
        </div>
        <div class="w-full">
          <div class="font-semibold text-lg mb-1">Cabbage</div>
          <div class="flex gap-2 my-2">
            <button class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-medium hover:bg-emerald-200">1 pc</button>
            <button class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-medium hover:bg-gray-200">2 pc</button>
          </div>
          <div class="flex items-center gap-2 mb-3">
            <span class="text-gray-400 line-through text-sm">$1.00</span>
            <span class="text-emerald-700 font-bold text-lg">$0.85</span>
          </div>
          <button class="btn-emerald w-full px-4 py-2 text-sm font-semibold">Add to Cart</button>
        </div>
      </div>

      <!-- Product 3 -->
      <div class="product-card bg-white rounded-xl p-4 flex flex-col items-center relative overflow-hidden">
        <div class="product-badge">
          <span class="bg-emerald-500 text-white text-xs font-bold px-3 py-1 rounded-full">10% OFF</span>
        </div>
        <div class="product-actions flex gap-2">
          <button class="bg-white p-2 rounded-full shadow hover:bg-gray-100">
            <span class="material-icons-outlined text-gray-600">favorite_border</span>
          </button>
          <button class="bg-white p-2 rounded-full shadow hover:bg-gray-100">
            <span class="material-icons-outlined text-gray-600">shopping_cart</span>
          </button>
        </div>
        <div class="w-full aspect-square mb-4 overflow-hidden rounded-lg">
          <img src="https://images.unsplash.com/photo-1519864600265-abb23847ef2c?auto=format&fit=crop&w=120&q=80" class="product-image w-full h-full object-cover">
        </div>
        <div class="w-full">
          <div class="font-semibold text-lg mb-1">Banana</div>
          <div class="flex gap-2 my-2">
            <button class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-medium hover:bg-emerald-200">6 pcs</button>
            <button class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-medium hover:bg-gray-200">12 pcs</button>
          </div>
          <div class="flex items-center gap-2 mb-3">
            <span class="text-gray-400 line-through text-sm">$2.55</span>
            <span class="text-emerald-700 font-bold text-lg">$2.3</span>
          </div>
          <button class="btn-emerald w-full px-4 py-2 text-sm font-semibold">Add to Cart</button>
        </div>
      </div>

      <!-- Product 4 -->
      <div class="product-card bg-white rounded-xl p-4 flex flex-col items-center relative overflow-hidden">
        <div class="product-badge">
          <span class="bg-emerald-500 text-white text-xs font-bold px-3 py-1 rounded-full">15% OFF</span>
        </div>
        <div class="product-actions flex gap-2">
          <button class="bg-white p-2 rounded-full shadow hover:bg-gray-100">
            <span class="material-icons-outlined text-gray-600">favorite_border</span>
          </button>
          <button class="bg-white p-2 rounded-full shadow hover:bg-gray-100">
            <span class="material-icons-outlined text-gray-600">shopping_cart</span>
          </button>
        </div>
        <div class="w-full aspect-square mb-4 overflow-hidden rounded-lg">
          <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=120&q=80" class="product-image w-full h-full object-cover">
        </div>
        <div class="w-full">
          <div class="font-semibold text-lg mb-1">Beef Steak</div>
          <div class="flex gap-2 my-2">
            <button class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-medium hover:bg-emerald-200">250g</button>
            <button class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-medium hover:bg-gray-200">500g</button>
          </div>
          <div class="flex items-center gap-2 mb-3">
            <span class="text-gray-400 line-through text-sm">$28.00</span>
            <span class="text-emerald-700 font-bold text-lg">$24.0</span>
          </div>
          <button class="btn-emerald w-full px-4 py-2 text-sm font-semibold">Add to Cart</button>
        </div>
      </div>
    </div>
    <div class="flex justify-center mt-8">
      <button class="btn-emerald px-8 py-3 font-semibold text-lg">See More Products</button>
    </div>
  </section>

  <!-- Delivery Info Banner -->
  <section class="max-w-7xl mx-auto mt-10 px-4">
    <div class="bg-red-100 rounded-2xl flex flex-col md:flex-row items-center justify-between p-6">
      <div class="mb-4 md:mb-0">
        <div class="font-bold text-lg mb-2">Stay home & get your daily needs everyday</div>
        <div class="text-red-700 mb-2">09:00 AM to 08:00 PM</div>
        <button class="btn-emerald px-4 py-2 font-semibold">Order Now</button>
      </div>
      <img src="https://images.unsplash.com/photo-1519864600265-abb23847ef2c?auto=format&fit=crop&w=180&q=80" class="w-40 h-32 object-cover rounded-xl">
    </div>
  </section>

  <!-- Best Deal Section -->
  <section class="max-w-7xl mx-auto mt-10 px-4">
    <div class="deal-card rounded-2xl p-6 flex flex-col md:flex-row items-center justify-between">
      <div class="flex-1 mb-6 md:mb-0">
        <div class="text-emerald-700 font-bold mb-2">Today's Best Deal</div>
        <div class="text-2xl font-bold mb-2">Tomato, Broccoli, Red Chili</div>
        <div class="flex gap-4 items-center">
          <span class="bg-white px-3 py-1 rounded-lg font-bold text-emerald-700">$0.25</span>
          <span class="bg-white px-3 py-1 rounded-lg font-bold text-emerald-700">$1.85</span>
          <span class="bg-white px-3 py-1 rounded-lg font-bold text-emerald-700">$2.60</span>
        </div>
      </div>
      <div class="flex gap-4">
        <img src="https://images.unsplash.com/photo-1502741338009-cac2772e18bc?auto=format&fit=crop&w=80&q=80" class="w-20 h-20 object-cover rounded-full">
        <img src="https://images.unsplash.com/photo-1464306076886-debca5e8a6b0?auto=format&fit=crop&w=80&q=80" class="w-20 h-20 object-cover rounded-full">
        <img src="https://images.unsplash.com/photo-1519864600265-abb23847ef2c?auto=format&fit=crop&w=80&q=80" class="w-20 h-20 object-cover rounded-full">
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-white mt-10 py-6 shadow-inner">
    <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row justify-between items-center text-gray-500 text-sm">
      <div>&copy; 2024 EcoGrocery. All rights reserved.</div>
      <div class="flex gap-4 mt-2 md:mt-0">
        <a href="#" class="hover:text-emerald-700">Contact</a>
        <a href="#" class="hover:text-emerald-700">Privacy Policy</a>
        <a href="#" class="hover:text-emerald-700">Terms of Service</a>
      </div>
    </div>
  </footer>
  <script>
  // Advanced Filter Modal logic
  const openFilterBtn = document.getElementById('openFilterBtn');
  const filterModal = document.getElementById('filterModal');
  function closeFilterModal() { filterModal.classList.add('hidden'); }
  openFilterBtn.addEventListener('click', () => filterModal.classList.remove('hidden'));
  filterModal.addEventListener('click', (e) => { if (e.target === filterModal) closeFilterModal(); });
  </script>
 
 