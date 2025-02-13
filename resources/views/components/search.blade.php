<form {{ $attributes }} method="GET" 
    class="w-full sm:w-auto flex flex-col sm:flex-row gap-2">
  <div class="relative flex-grow">
      <input type="search" name="search" value="{{ $search }}" 
             placeholder="{{ $slot }}"
             class="w-full py-2.5 px-4 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200" />
      <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2">
          <svg class="w-5 h-5 text-gray-400 hover:text-green-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
      </button>
  </div>
</form>