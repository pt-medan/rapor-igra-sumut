<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl sm:text-2xl text-gray-800 leading-tight px-4 sm:px-0">
            🎨 Responsive Design Improvement Guide
        </h2>
    </x-slot>

    <div class="py-8 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6 text-gray-900">
                    <div class="prose max-w-none">
                        <h3 class="text-xl sm:text-2xl font-bold mb-4">Mobile-First Responsive Design Checklist</h3>
                        
                        <h4 class="text-lg font-semibold mt-6 mb-3">1. Typography Scaling</h4>
                        <pre class="bg-gray-100 p-3 sm:p-4 rounded overflow-x-auto text-xs sm:text-sm"><code>
{/* Responsive text sizes */}
text-lg sm:text-xl md:text-2xl lg:text-3xl

{/* Mobile-first approach: smaller base, scale up */}
h1: text-2xl → sm:text-3xl → md:text-4xl → lg:text-5xl
h2: text-xl → sm:text-2xl → md:text-3xl → lg:text-4xl
h3: text-lg → sm:text-xl → md:text-2xl → lg:text-3xl
body: text-base → remains consistent

{/* Line height improves readability */}
Leading: leading-relaxed (1.625) for mobile
                        </code></pre>

                        <h4 class="text-lg font-semibold mt-6 mb-3">2. Spacing & Padding</h4>
                        <pre class="bg-gray-100 p-3 sm:p-4 rounded overflow-x-auto text-xs sm:text-sm"><code>
{/* Mobile-first spacing */}
px-4 sm:px-6 lg:px-8     {/* Padding horizontal */}
py-4 sm:py-6 lg:py-8     {/* Padding vertical */}

{/* Gaps between elements */}
gap-3 sm:gap-4 md:gap-6  {/* More spacing on larger screens */}

{/* Margins */}
my-4 sm:my-6 md:my-8
                        </code></pre>

                        <h4 class="text-lg font-semibold mt-6 mb-3">3. Grid Layouts</h4>
                        <pre class="bg-gray-100 p-3 sm:p-4 rounded overflow-x-auto text-xs sm:text-sm"><code>
{/* Mobile: 1 column, Tablet: 2 columns, Desktop: 3-4 columns */}
grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4

{/* For forms: responsive input width */}
grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6

{/* Buttons row on mobile: stack, on desktop: horizontal */}
flex flex-col sm:flex-row gap-3 sm:gap-4
                        </code></pre>

                        <h4 class="text-lg font-semibold mt-6 mb-3">4. Tables - Responsive Solutions</h4>
                        <pre class="bg-gray-100 p-3 sm:p-4 rounded overflow-x-auto text-xs sm:text-sm"><code>
{/* Option 1: Horizontal scroll wrapper */}
&lt;div class="overflow-x-auto"&gt;
    &lt;table class="min-w-full text-xs sm:text-sm"&gt;
    &lt;/table&gt;
&lt;/div&gt;

{/* Option 2: Hide columns on mobile */}
&lt;th class="hidden sm:table-cell"&gt;...&lt;/th&gt;

{/* Option 3: Card-based layout on mobile */}
@media (max-width: 768px) {
    table, thead, tbody, th, td, tr {
        display: block;
    }
    tr { margin-bottom: 1.5rem; }
}
                        </code></pre>

                        <h4 class="text-lg font-semibold mt-6 mb-3">5. Touch-Friendly Buttons</h4>
                        <pre class="bg-gray-100 p-3 sm:p-4 rounded overflow-x-auto text-xs sm:text-sm"><code>
{/* Minimum 44x44px on mobile for touch targets */}
px-3 py-2 sm:px-4 sm:py-2    {/* Button padding */}
min-h-[44px] min-w-[44px]     {/* Minimum touch target */}

{/* Button sizing */}
text-xs sm:text-sm            {/* Font size adjusts */}
rounded-md sm:rounded-lg      {/* Corner radius */}

{/* Stacking on mobile, inline on desktop */}
flex flex-col sm:flex-row gap-2 sm:gap-3
                        </code></pre>

                        <h4 class="text-lg font-semibold mt-6 mb-3">6. Form Inputs</h4>
                        <pre class="bg-gray-100 p-3 sm:p-4 rounded overflow-x-auto text-xs sm:text-sm"><code>
{/* Input sizing */}
class="block mt-1 w-full px-3 sm:px-4 py-2 
       text-sm sm:text-base
       border border-gray-300 rounded-md"

{/* Label sizing */}
&lt;label class="block text-sm sm:text-base font-medium 
               text-gray-700"&gt;

{/* Form grid */}
grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6
                        </code></pre>

                        <h4 class="text-lg font-semibold mt-6 mb-3">7. Cards & Containers</h4>
                        <pre class="bg-gray-100 p-3 sm:p-4 rounded overflow-x-auto text-xs sm:text-sm"><code>
{/* Card padding responsive */}
p-4 sm:p-6 lg:p-8

{/* Card shadows */}
shadow-sm sm:shadow md:shadow-md

{/* Card gaps */}
gap-3 sm:gap-4 md:gap-6

{/* Rounded corners */}
rounded-lg sm:rounded-xl
                        </code></pre>

                        <h4 class="text-lg font-semibold mt-6 mb-3">Breakpoints Reference</h4>
                        <table class="w-full border-collapse border border-gray-300 text-xs sm:text-sm my-4">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border border-gray-300 p-2 text-left">Breakpoint</th>
                                    <th class="border border-gray-300 p-2 text-left">Prefix</th>
                                    <th class="border border-gray-300 p-2 text-left">Width</th>
                                    <th class="border border-gray-300 p-2 text-left">Usage</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border border-gray-300 p-2">Mobile</td>
                                    <td class="border border-gray-300 p-2">none (default)</td>
                                    <td class="border border-gray-300 p-2">&lt; 640px</td>
                                    <td class="border border-gray-300 p-2">Base styles</td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-300 p-2">Small</td>
                                    <td class="border border-gray-300 p-2">sm:</td>
                                    <td class="border border-gray-300 p-2">≥ 640px</td>
                                    <td class="border border-gray-300 p-2">Larger phones</td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-300 p-2">Medium</td>
                                    <td class="border border-gray-300 p-2">md:</td>
                                    <td class="border border-gray-300 p-2">≥ 768px</td>
                                    <td class="border border-gray-300 p-2">Tablets</td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-300 p-2">Large</td>
                                    <td class="border border-gray-300 p-2">lg:</td>
                                    <td class="border border-gray-300 p-2">≥ 1024px</td>
                                    <td class="border border-gray-300 p-2">Desktops</td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-300 p-2">X-Large</td>
                                    <td class="border border-gray-300 p-2">xl:</td>
                                    <td class="border border-gray-300 p-2">≥ 1280px</td>
                                    <td class="border border-gray-300 p-2">Large desktops</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
