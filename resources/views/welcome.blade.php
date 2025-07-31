<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Business Network | Connect. Grow. Succeed.</title>
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    .bg-blue-600 {
      background-color: rgb(102 83 204) !important;
    }
    .text-blue-600 {
      color: rgb(102 83 204) !important;
    }
    .border-blue-600 {
      border-color: rgb(102 83 204) !important;
    }
  </style>
</head>
<body class="bg-white text-gray-800">

  <!-- Navbar -->
  <nav class="flex items-center justify-between px-6 py-4 shadow">
    <a href="{{ route('post.index') }}">
      <img src="{{ asset('images/mikxx-text-logo.png') }}" alt="" width="150">
    </a>
    <div class="space-x-4">
      @if(Auth::check())
          <a href="{{ route('post.index') }}" class="text-sm text-gray-600 hover:text-blue-500">{{Auth::user()->first_name}}</a>
      @else
           <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-blue-500">Sign In</a>
       @endif
     
      <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md">Create Free Account</a>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="relative bg-gray-100 text-center py-20 px-6">
    <h2 class="text-4xl font-bold mb-4">Connect. Grow. Succeed.</h2>
    <p class="text-lg text-gray-600 mb-6">India’s first smart business community</p>
    <div class="space-x-4">
      <button class="bg-blue-600 text-white px-6 py-3 rounded-md">Create Free Account</button>
      <button class="border border-blue-600 text-blue-600 px-6 py-3 rounded-md">Explore Features</button>
    </div>
  </section>

  <!-- Platform Highlights -->
  <section class="py-16 bg-white px-6">
    <div class="grid md:grid-cols-4 gap-6 text-center">
      <div>
        <img src="https://cdn-icons-png.flaticon.com/512/1055/1055646.png" class="mx-auto w-12 mb-3">
        <h3 class="font-semibold">Post Business Updates</h3>
      </div>
      <div>
        <img src="https://cdn-icons-png.flaticon.com/512/1256/1256650.png" class="mx-auto w-12 mb-3">
        <h3 class="font-semibold">Discover Leads</h3>
      </div>
      <div>
        <img src="https://cdn-icons-png.flaticon.com/512/2682/2682065.png" class="mx-auto w-12 mb-3">
        <h3 class="font-semibold">Sell Products/Services</h3>
      </div>
      <div>
        <img src="https://cdn-icons-png.flaticon.com/512/1077/1077012.png" class="mx-auto w-12 mb-3">
        <h3 class="font-semibold">Apply for Jobs</h3>
      </div>
    </div>
  </section>

  <!-- Feature Carousel (static layout here) -->
  <section class="bg-gray-50 py-16 px-6">
    <h2 class="text-2xl font-bold text-center mb-8">Powerful Features</h2>
    <div class="grid md:grid-cols-5 gap-4 text-center">
      <div class="p-4 bg-white rounded shadow">Business Pagessssssssss</div>
      <div class="p-4 bg-white rounded shadow">Lead Manager</div>
      <div class="p-4 bg-white rounded shadow">Hiring Tools</div>
      <div class="p-4 bg-white rounded shadow">Event Booking</div>
      <div class="p-4 bg-white rounded shadow">CRM + Analytics</div>
    </div>
  </section>

  <!-- User Personas -->
  <section class="py-16 px-6">
    <h2 class="text-2xl font-bold text-center mb-8">Who is it for?</h2>
    <div class="grid md:grid-cols-4 gap-6 text-center">
      <div>
        <div class="w-16 h-16 bg-gray-200 rounded-full mx-auto mb-2"></div>
        <p>Freelancer</p>
      </div>
      <div>
        <div class="w-16 h-16 bg-gray-200 rounded-full mx-auto mb-2"></div>
        <p>Agency</p>
      </div>
      <div>
        <div class="w-16 h-16 bg-gray-200 rounded-full mx-auto mb-2"></div>
        <p>Startup / Brand</p>
      </div>
      <div>
        <div class="w-16 h-16 bg-gray-200 rounded-full mx-auto mb-2"></div>
        <p>Corporate</p>
      </div>
    </div>
  </section>

  <!-- Stats and Testimonials -->
  <section class="bg-blue-50 py-16 text-center">
    <h2 class="text-2xl font-bold mb-4">Why Join Us?</h2>
    <p class="mb-6">Trusted by 50K+ professionals across India</p>
    <div class="flex justify-center gap-8 text-lg font-semibold">
      <div>5K+ Daily Leads</div>
      <div>99% Discovery Rate</div>
      <div>Secure & Verified</div>
    </div>
  </section>

  <!-- How It Works -->
  <section class="py-16 px-6">
    <h2 class="text-2xl font-bold text-center mb-8">How It Works</h2>
    <div class="grid md:grid-cols-3 gap-6 text-center">
      <div>
        <div class="text-4xl mb-2">1</div>
        <p>Create an Account</p>
      </div>
      <div>
        <div class="text-4xl mb-2">2</div>
        <p>Build Profile/Page</p>
      </div>
      <div>
        <div class="text-4xl mb-2">3</div>
        <p>Post, Connect & Grow</p>
      </div>
    </div>
  </section>

  <!-- Pricing -->
  <section class="bg-gray-100 py-16 px-6">
    <h2 class="text-2xl font-bold text-center mb-8">Plans</h2>
    <div class="flex flex-col md:flex-row justify-center gap-6">
      <div class="bg-white p-6 rounded shadow w-full md:w-1/3 text-center">
        <h3 class="text-xl font-bold mb-2">Free Plan</h3>
        <p>Start networking with basic features</p>
      </div>
      <div class="bg-blue-600 text-white p-6 rounded shadow w-full md:w-1/3 text-center">
        <h3 class="text-xl font-bold mb-2">Premium</h3>
        <p>Advanced tools & badge for ₹299/month</p>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-black text-gray-400 text-sm py-10 px-6">
    <div class="grid md:grid-cols-4 gap-6 mb-6">
      <div>
        <h4 class="font-semibold text-white">Company</h4>
        <ul>
          <li><a href="#">About</a></li>
          <li><a href="#">Terms</a></li>
          <li><a href="#">Privacy</a></li>
        </ul>
      </div>
      <div>
        <h4 class="font-semibold text-white">Help</h4>
        <ul>
          <li><a href="#">Contact</a></li>
          <li><a href="#">Blog</a></li>
          <li><a href="#">Support</a></li>
        </ul>
      </div>
      <div>
        <h4 class="font-semibold text-white">Social</h4>
        <div class="flex gap-2 mt-2">
          <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/733/733579.png" class="w-5"></a>
          <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/1384/1384031.png" class="w-5"></a>
          <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/1384/1384060.png" class="w-5"></a>
        </div>
      </div>
      <div>
        <h4 class="font-semibold text-white">Subscribe</h4>
        <input type="email" placeholder="Your email" class="mt-2 w-full p-2 rounded text-black" />
      </div>
    </div>
    <p class="text-center mt-4">&copy; 2025 Mikxx. All rights reserved.</p>
  </footer>

</body>
</html>