<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $tag->title_seo }}</title>
    <meta name="description" content="{{ $tag->description_seo }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>


<div class="bg-gray-900">
    <header class="absolute inset-x-0 top-0 z-50" x-data="{ open: true }">
        <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
            <div class="flex lg:flex-1">
                <div class="text-white uppercase" id="logo_header" style="font-family: 'Montserrat', sans-serif; font-weight: 800">
                    {{ $header_title }}
                </div>
            </div>
            <div class="flex lg:hidden">
                <button type="button" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-400"  @click="open = !open">
                    <span class="sr-only">Open main menu</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>
            <div class="hidden lg:flex lg:gap-x-12" id="navbar_desktop">
                <a href="{{ $navbar_1_btn_href }}" class="text-sm font-semibold leading-6 text-white">{{ $navbar_1_btn_text }}</a>
                <a href="{{ $navbar_2_btn_href }}" class="text-sm font-semibold leading-6 text-white">{{ $navbar_2_btn_text }}</a>
                <a href="{{ $navbar_3_btn_href }}" class="text-sm font-semibold leading-6 text-white">{{ $navbar_3_btn_text }}</a>
            </div>
            <div class="hidden lg:flex lg:flex-1 lg:justify-end">

            </div>
        </nav>
        <!-- Mobile menu, show/hide based on menu open state. -->

        <div class="lg:hidden"  role="dialog" x-show="!open" aria-modal="true">
            <!-- Background backdrop, show/hide based on slide-over state. -->
            <div class="fixed inset-0 z-50"></div>
            <div class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-gray-900 px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-white/10">
                <div class="flex items-center justify-between">
                    <a href="#" class="-m-1.5 p-1.5">
                        <span class="sr-only">Your Company</span>
                    </a>
                    <button type="button" class="-m-2.5 rounded-md p-2.5 text-gray-400"  @click="open = !open">
                        <span class="sr-only">Close menu</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="mt-6 flow-root">
                    <div class="-my-6 divide-y divide-gray-500/25">
                        <div class="space-y-2 py-6" id="navbar_mobile">
                            <a href="{{ $navbar_1_btn_href }}" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-white hover:bg-gray-800">{{ $navbar_1_btn_text }}</a>
                            <a href="{{ $navbar_2_btn_href }}" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-white hover:bg-gray-800">{{ $navbar_2_btn_text }}</a>
                            <a href="{{ $navbar_3_btn_href }}" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-white hover:bg-gray-800">{{ $navbar_3_btn_text }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="relative isolate overflow-hidden pt-14" id="header_main">
        <img src="{{ $header_image_full_img_file  }}" alt="{{ $header_image_full_img_alt }}" class="absolute inset-0 -z-10 h-full w-full object-cover">
        <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
            <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-20 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
        </div>
        <div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56">

            <div class="text-center px-3 sm:px-0">
                <h1 class="text-balance text-3xl font-bold tracking-tight text-white sm:text-4xl">{{$tag->name}}</h1>
            </div>
        </div>
        <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]" aria-hidden="true">
            <div class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-20 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
        </div>
    </div>
</div>




<div>
    <div class="relative isolate z-50 shadow">

        <div class="absolute inset-x-0 top-0 -z-10 bg-white pt-16 shadow-lg ring-1 ring-gray-900/5">
            <div class="mx-auto grid max-w-7xl grid-cols-1 gap-x-8 gap-y-10 px-6 py-10 lg:grid-cols-[1fr_2fr] lg:px-8">
                @if($categories->count() > 0)
                    <div class="grid grid-cols-1 gap-x-4 sm:gap-x-8">
                        <div>
                            <h3 class="text-sm font-medium leading-6 text-gray-500">Kategorie</h3>
                            <div class="mt-6 flow-root">
                                <div class="-my-2">
                                    <!-- Tu wyświetlać kategorie -->
                                    @foreach($categories as $category)
                                        <a href="{{ route('blog.list.category', ['slug' => $category->slug]) }}" class="flex gap-x-4 py-2 text-sm font-semibold leading-6 text-gray-900">

                                            @if(!empty($currentCategory) && $currentCategory == $category->name)
                                                <strong>{{ $category->name }}</strong>
                                            @else
                                                {{ $category->name }}
                                            @endif
                                        </a>
                                    @endforeach
                                    <!-- Tu wyświetlać kategorie -->
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 gap-10 sm:gap-8 lg:grid-cols-2">

                    @foreach($articles as $article)
                        <article class="relative isolate flex max-w-2xl flex-col gap-x-8 gap-y-6 sm:flex-row sm:items-start lg:flex-col lg:items-stretch">
                            <div class="relative flex-none">
                                <img class="aspect-[2/1] w-full rounded-lg bg-gray-100 object-cover sm:aspect-[16/9] sm:h-32 lg:h-auto" src="{{ $article->image }}" alt="{{ !empty($article->view_content['basic_website_structure_image_img_alt']) ? $article->view_content['basic_website_structure_image_img_alt'] : $article->name }}">
                                <div class="absolute inset-0 rounded-lg ring-1 ring-inset ring-gray-900/10"></div>
                            </div>
                            <div>
                                <div class="flex items-center gap-x-4">
                                    <time datetime="{{ $article->created_at->format('Y-m-d') }}" class="text-sm leading-6 text-gray-600">{{ $article->created_at->format('Y-m-d') }}</time>

                                </div>
                                <h4 class="mt-2 text-sm font-semibold leading-6 text-gray-900">
                                    <a href="{{ $article->getRoute() }}">
                                        <span class="absolute inset-0"></span>
                                        {{ $article->name }}
                                    </a>
                                </h4>
                                <p class="mt-2 text-sm leading-6 text-gray-600">{{ $article->getShortDescriptionToBlogList() }}</p>
                            </div>
                        </article>
                    @endforeach
                    <!-- Add more articles as needed -->



                </div>

            </div>

        </div>
    </div>





</div>






<footer class="bg-gray-900">
    <div class="mx-auto max-w-7xl px-6 pb-8 lg:px-8 ">
        <div class="border-t border-white/10 pt-8 md:flex md:items-center md:justify-between">
            <p class="mt-8 text-xs leading-5 text-gray-400 md:order-1 md:mt-0">&copy; {{ date('Y') }} Serwis elektroniki - Bartłomiej Biernat</p>
        </div>
    </div>
</footer>








</body>
</html>
