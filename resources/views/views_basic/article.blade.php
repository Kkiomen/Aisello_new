<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $article->view_content['basic_website_structure_title'] }}</title>
    <meta name="description" content="{{ $article->view_content['basic_website_structure_description'] }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="canonical" href="{{ $article->getRoute() }}" />
    <meta name="keywords" content="{{ $article->view_content['basic_website_structure_keywords'] }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/assets/css/article-style.css') }}">


    <meta property="og:title" content="{{ $article->view_content['basic_website_structure_op_title'] }}" />
    <meta property="og:description" content="{{ $article->view_content['basic_website_structure_op_description'] }}" />
    <meta property="og:url" content="{{ $article->getRoute() }}" />
    <meta property="og:image" content="{{ $article->view_content['basic_website_structure_op_image_img_file'] }}" />
    <meta property=”og:type” content=”article” />
</head>
<body>





<div class="bg-white">
    <header class="absolute inset-x-0 top-0 z-50" x-data="{ open: true }">
        <div class="mx-auto max-w-7xl">
            <div class="px-6 pt-6 lg:max-w-2xl lg:pl-8 lg:pr-0">
                <nav class="flex items-center justify-between lg:justify-start" aria-label="Global">
                    <div class="text-black uppercase" style="font-family: 'Montserrat', sans-serif; font-weight: 800">
                        Bartłomiej Biernat
                    </div>
                    <button type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700 lg:hidden"  @click="open = !open">
                        <span class="sr-only">Open main menu</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                    <div class="hidden lg:ml-12 lg:flex lg:gap-x-14">
                        <a href="{{ route('index') }}" class="text-sm font-semibold leading-6 text-gray-900">Strona główna</a>
                        <a href="{{ route('blog') }}" class="text-sm font-semibold leading-6 text-gray-900">Blog</a>
                        <a href="{{ route('index') }}#contact" class="text-sm font-semibold leading-6 text-gray-900">Kontakt</a>
                    </div>
                </nav>
            </div>
        </div>
        <!-- Mobile menu, show/hide based on menu open state. -->
        <div class="lg:hidden" x-show="!open" role="dialog" aria-modal="true">
            <!-- Background backdrop, show/hide based on slide-over state. -->
            <div class="fixed inset-0 z-50"></div>
            <div class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
                <div class="flex items-center justify-between">
                    <div class="text-black uppercase" style="font-family: 'Montserrat', sans-serif; font-weight: 800">
                        Bartłomiej Biernat
                    </div>
                    <button type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700" @click="open = !open">
                        <span class="sr-only">Close menu</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="mt-6 flow-root">
                    <div class="-my-6 divide-y divide-gray-500/10">
                        <div class="space-y-2 py-6">
                            <a href="{{ route('index') }}" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Strona główna</a>
                            <a href="{{ route('blog') }}" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Blog</a>
                            <a href="{{ route('index') }}#contact" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Kontakt</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="relative">
        <div class="mx-auto max-w-7xl">
            <div class="relative z-10 pt-14 lg:w-full lg:max-w-2xl">
                <svg class="absolute inset-y-0 right-8 hidden h-full w-80 translate-x-1/2 transform fill-white lg:block" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
                    <polygon points="0,0 90,0 50,100 0,100" />
                </svg>

                <div class="relative px-6 py-10 sm:py-10 lg:px-8 lg:py-20 lg:pr-0">
                    <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-xl">

                        <nav class="flex mb-16" aria-label="Breadcrumb">
                            <ol role="list" class="flex items-center space-x-4">
                                <li>
                                    <div>
                                        <a href="#" class="text-gray-400 hover:text-gray-500">
                                            <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                                <path fill-rule="evenodd" d="M9.293 2.293a1 1 0 0 1 1.414 0l7 7A1 1 0 0 1 17 11h-1v6a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-6H3a1 1 0 0 1-.707-1.707l7-7Z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="sr-only">Strona główna</span>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <div class="flex items-center">
                                        <svg class="h-5 w-5 flex-shrink-0 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                            <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                        </svg>
                                        <a href="{{ route('blog') }}" class="ml-4 text-xs sm:text-sm font-medium text-gray-500 hover:text-gray-700">Blog</a>
                                    </div>
                                </li>
                                @if($category)
                                    <li>
                                        <div class="flex items-center">
                                            <svg class="h-5 w-5 flex-shrink-0 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                                <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                            </svg>
                                            <a href="{{ route('blog.list.category', ['slug' => $category->slug]) }}" class="ml-4 text-xs sm:text-sm  font-medium text-gray-500 hover:text-gray-700">{{ $category->name }}</a>
                                        </div>
                                    </li>
                                @endif
                                <li>
                                    <div class="flex items-center">
                                        <svg class="h-5 w-5 flex-shrink-0 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                            <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                        </svg>
                                        <a href="#" class="ml-4 text-xs sm:text-sm font-medium text-gray-500 hover:text-gray-700" aria-current="page">{{ $article->name }}</a>
                                    </div>
                                </li>
                            </ol>
                        </nav>



                        <h1 class="text-3xl font-bold mt-3 sm:mt-0 tracking-tight text-gray-900 sm:text-5xl">{{ $article->name }}</h1>
                        <p class="mt-6 text-lg leading-8 text-gray-600">{{ $article->short_description }}</p>
                        <div class="mt-10 flex items-center gap-x-6">
                            <a href="{{ route('index') }}#contact" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Skorzystaj z usług</a>
                            <a href="#article-content" class="text-sm font-semibold leading-6 text-gray-900">Przeczytaj artykuł <span aria-hidden="true">→</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
            <img class="aspect-[3/2] object-cover lg:aspect-auto lg:h-full lg:w-full" src="{{ $article->image }}" alt="{{ !empty($article->view_content['basic_website_structure_image_img_alt']) ? $article->view_content['basic_website_structure_image_img_alt'] : $article->name }}">
        </div>
    </div>
</div>


<div class="bg-gray-100 px-0 md:px-6 md:py-16 lg:px-8" id="article-content">

    <div class="mx-auto max-w-full md:max-w-7xl text-base leading-7 bg-white p-5 md:p-10 text-gray-700 rounded-xl article-content-theme">

        @foreach($article->contents as $content)
            @if($content['type'] == 'text' && !empty($content['content']))
                {!! $content['content'] !!}
            @endif

            @if($content['type'] == 'image' && !empty($content['content']))
                <figure class="mt-16">
                    <img class="aspect-video rounded-xl bg-gray-50 object-cover" src="{{ $content['content'] }}" alt="{{ $content['alt'] ?? '' }}">
                </figure>
            @endif

        @endforeach


        @if(!$article->tags->isEmpty())
            <div class="mt-20 tags_list">
                <div class="font-bold text-lg">{{ __('basic.tags') }}:</div>

                <div class="mt-3">
                    @foreach($article->tags as $tag)
                        <a href="{{ route('blogTag', ['tag' => Str::slug($tag->name)]) }}" class="inline-block px-4 py-1 text-bg-indigo-600 hover:bg-indigo-600 hover:text-white border border-indigo-600 mx-2 my-2 rounded-2xl">
                            {{ $tag->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>

@if($randomArticles->count() > 0)

    <div class="bg-white py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Losowe 3 artykuły</h2>
                <p class="mt-2 text-lg leading-8 text-gray-600">Sprawdź inne artykuły</p>
            </div>
            <div class="mx-auto mt-16 grid max-w-2xl auto-rows-fr grid-cols-1 gap-8 sm:mt-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">

                @foreach($randomArticles as $currentArticle)
                    <article class="relative isolate flex flex-col justify-end overflow-hidden rounded-2xl bg-gray-900 px-8 pb-8 pt-80 sm:pt-48 lg:pt-80">
                        <img src="{{ $currentArticle->image }}" alt="" class="absolute inset-0 -z-10 h-full w-full object-cover">
                        <div class="absolute inset-0 -z-10 bg-gradient-to-t from-gray-900 via-gray-900/40"></div>
                        <div class="absolute inset-0 -z-10 rounded-2xl ring-1 ring-inset ring-gray-900/10"></div>

                        <div class="flex flex-wrap items-center gap-y-1 overflow-hidden text-sm leading-6 text-gray-300">
                            <time datetime="{{ $currentArticle->created_at->format('Y-m-d') }}" class="mr-8">{{ $currentArticle->created_at->format('Y-m-d') }}</time>
                        </div>
                        <h3 class="mt-3 text-lg font-semibold leading-6 text-white">
                            <a href="{{ $currentArticle->getRoute() }}">
                                <span class="absolute inset-0"></span>
                                {{ $currentArticle->name }}
                            </a>
                        </h3>
                    </article>
                @endforeach

            </div>
        </div>
    </div>

@endif

<footer class="bg-gray-900">
    <div class="mx-auto max-w-7xl px-6 pb-8 lg:px-8 ">
        <div class="border-t border-white/10 pt-8 md:flex md:items-center md:justify-between">
            <p class="mt-8 text-xs leading-5 text-gray-400 md:order-1 md:mt-0">&copy; {{ date('Y') }} Serwis elektroniki - Bartłomiej Biernat</p>
        </div>
    </div>
</footer>


<script src="{{ asset('/assets/js/script.js') }}"></script>
</body>
</html>
