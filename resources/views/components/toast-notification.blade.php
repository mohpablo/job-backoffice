 <div class="fixed inset-x-0 bottom-6 flex justify-center z-50">
     @if (session('success'))
     <div
         x-data="{ show: true }"
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-4"
         x-init="setTimeout(() => show = false, 5000)"
         class="flex items-center gap-3 max-w-md w-full bg-green-50 border border-green-400 text-green-800 px-4 py-3 rounded-lg shadow-lg">
         <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24">
             <path stroke-linecap="round" stroke-linejoin="round"
                 d="M5 13l4 4L19 7" />
         </svg>
         <span class="flex-1 text-sm font-medium">
             {{ session('success') }}
         </span>
         <button
             @click="show = false"
             class="text-green-700 hover:text-green-900 focus:outline-none">
             ✕
         </button>
     </div>
     @endif
 </div>