<!doctype html>
<html lang="{{ env('APP_LANG_HTML') }}"l>
<head>
    <meta charset="UTF-8">
    <title>{{ __('basic.meta_title') }}</title>
    <meta name="description" content="{{ __('basic.meta_description') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {!! \App\Services\HomeService::getTagManagerHEAD() !!}

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">

</head>
<body>
{!! \App\Services\HomeService::getTagManagerBODY() !!}

<div class="relative overflow-hidden bg-gray-800" x-data="{ open: true }">
    <div class="hidden sm:absolute sm:inset-y-0 sm:block sm:h-full sm:w-full" aria-hidden="true">
        <div class="relative mx-auto h-full max-w-7xl">
            <svg class="absolute right-full translate-x-1/4 translate-y-1/4 transform lg:translate-x-1/2" width="404" height="784" fill="none" viewBox="0 0 404 784">
                <defs>
                    <pattern id="4522f7d5-8e8c-43ee-89bd-ad34cbfb07fa" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                        <rect x="0" y="0" width="4" height="4" class="text-gray-800" fill="currentColor" />
                    </pattern>
                </defs>
                <rect width="404" height="784" fill="url(#4522f7d5-8e8c-43ee-89bd-ad34cbfb07fa)" />
            </svg>
            <svg class="absolute left-full -translate-x-1/4 -translate-y-3/4 transform md:-translate-y-1/2 lg:-translate-x-1/2" width="404" height="784" fill="none" viewBox="0 0 404 784">
                <defs>
                    <pattern id="5d0dd344-b041-4d26-bec4-8d33ea57ec9b" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                        <rect x="0" y="0" width="4" height="4" class="text-gray-700" fill="currentColor" />
                    </pattern>
                </defs>
                <rect width="404" height="784" fill="url(#5d0dd344-b041-4d26-bec4-8d33ea57ec9b)" />
            </svg>
        </div>
    </div>

    <div class="relative pb-16 pt-6 sm:pb-24">
        <div>
            <div class="mx-auto max-w-7xl px-4 sm:px-6">
                <nav class="relative flex items-center justify-between sm:h-10 md:justify-center" aria-label="Global">
                    <div class="flex flex-1 items-center md:absolute md:inset-y-0 md:left-0">
                        <div class="flex w-full items-center justify-between md:w-auto">
                            <a href="{{ route('index')  }}" class="logo_oatllo">
                                aisello
                            </a>
                            <div class="-mr-2 flex items-center md:hidden">
                                <button type="button" @click="open = !open" class="relative inline-flex items-center justify-center rounded-md bg-gray-50 p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" aria-expanded="false">
                                    <span class="absolute -inset-0.5"></span>
                                    <span class="sr-only">Open main menu</span>
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="hidden md:flex md:space-x-10">
                        <a href="{{ route('index') }}" class="font-medium text-gray-500 hover:text-gray-900">{{ __('basic.home') }}</a>
                        <a href="{{ route('blog') }}" class="font-medium text-gray-500 hover:text-gray-900">Blog</a>
                    </div>
                    <div class="hidden md:absolute md:inset-y-0 md:right-0 md:flex md:items-center md:justify-end">
            <span class="inline-flex rounded-md shadow">
{{--              <a href="#" class="inline-flex items-center rounded-md border border-transparent bg-white px-4 py-2 text-base font-medium text-indigo-600 hover:bg-gray-50">Log in</a>--}}
            </span>
                    </div>
                </nav>
            </div>

            <!--
              Mobile menu, show/hide based on menu open state.

              Entering: "duration-150 ease-out"
                From: "opacity-0 scale-95"
                To: "opacity-100 scale-100"
              Leaving: "duration-100 ease-in"
                From: "opacity-100 scale-100"
                To: "opacity-0 scale-95"
            -->
            <div class="absolute inset-x-0 top-0 z-10 origin-top-right transform p-2 transition md:hidden"  x-show="!open">
                <div class="overflow-hidden rounded-lg bg-white shadow-md ring-1 ring-black ring-opacity-5">
                    <div class="flex items-center justify-between px-5 pt-4">
                        <div class="logo_oatllo text-black">
                            aisello
                        </div>
                        <div class="-mr-2">
                            <button type="button" @click="open = !open" class="relative inline-flex items-center justify-center rounded-md bg-white p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                                <span class="absolute -inset-0.5"></span>
                                <span class="sr-only">Close menu</span>
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="px-2 pb-3 pt-2">
                        <a href="{{ route('index') }}" class="block rounded-md px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-300">{{ __('basic.home') }}</a>
                        <a href="{{ route('blog') }}" class="block rounded-md px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-300">Blog</a>
                    </div>
                    {{--                    <a href="#" class="block w-full bg-gray-50 px-5 py-3 text-center font-medium text-indigo-600 hover:bg-gray-100">Log in</a>--}}
                </div>
            </div>
        </div>

        <main class="mx-auto mt-16 max-w-7xl px-4 sm:mt-24">
            <div class="text-center">
                <h1 class="text-4xl font-bold tracking-tight text-gray-200 sm:text-5xl md:text-6xl">
                    <span class="block xl:inline">{{ __('basic.blog_header') }}</span>
                </h1>
                <p class="mx-auto mt-3 max-w-md text-base text-gray-500 sm:text-lg md:mt-5 md:max-w-3xl md:text-xl">{{ __('basic.blog_subheader') }}</p>
            </div>
        </main>
    </div>
</div>



<div class="jetbrains_bg_color py-24 sm:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">

            @foreach($articles as $article)
                <article class="flex flex-col items-start justify-between">
                    <a href="{{ $article->getRoute() }}">
                        <div class="relative w-full">
                            <img  src="{{ $article->image }}" alt="{{ !empty($article->view_content['basic_website_structure_image_img_alt']) ? $article->view_content['basic_website_structure_image_img_alt'] : $article->name }}" class="aspect-[16/9] w-full rounded-2xl bg-gray-100 object-cover sm:aspect-[2/1] lg:aspect-[3/2]">
                            <div class="absolute inset-0 rounded-2xl ring-1 ring-inset ring-gray-900/10"></div>
                        </div>
                    </a>
                    <div class="max-w-xl">
                        <div class="mt-8 flex items-center gap-x-4 text-xs">
                            <time datetime="{{ $article->created_at->format('Y-m-d') }}" class="text-gray-300">{{ $article->created_at->format('Y-m-d') }}</time>
                        </div>
                        <div class="group relative">
                            <h3 class="mt-3 text-lg/6 font-semibold text-gray-300 group-hover:text-gray-200">
                                <a href="{{ $article->getRoute() }}">
                                    <span class="absolute inset-0"></span>
                                    {{ $article->name }}
                                </a>
                            </h3>
                            <p class="mt-5 line-clamp-3 text-sm/6 text-gray-500">{{ $article->getShortDescriptionToBlogList() }}</p>
                        </div>
                    </div>
                </article>
            @endforeach

            <!-- More posts... -->
        </div>
    </div>
</div>






</body>
</html>
