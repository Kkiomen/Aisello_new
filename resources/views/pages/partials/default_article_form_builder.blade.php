<div class="container mx-auto py-4">
    @csrf
    @foreach($contents as $content)
        <div class="md:mx-auto grid max-w-7xl bg-white md:shadow md:shadow-2xl md:rounded-2xl mb-6 pt-10 px-3 py-3 md:px-10" @if(!empty($content['dropdown'])) x-data="{ open: true }" @endif>

            @if(!empty($content['label']))
                @if(!empty($content['dropdown']))
                    <div class="flex justify-between border-b-2 border-gray-200 mb-5 pb-3">
                        <div>
                            {{ $content['label'] }}
                        </div>
                        <div class="cursor-pointer pr-5 md:pr-0 select-none" @click="open = !open">
                            <i class="fa-solid fa-arrow-down" x-show="open" ></i>
                            <i class="fa-solid fa-arrow-up" x-show="!open" ></i>
                        </div>
                    </div>
                @else
                    <div class="border-b-2 border-gray-200 mb-5 pb-3">
                        {{ $content['label'] }}
                    </div>
                @endif
            @endif

            @if(isset($content['key']) && $content['key'] === 'content-list')
                @include('pages.partials.contents', ['content' => $content])
            @endif


            <div x-show="!open" >
                <div class="pb-10">
                    @if(!empty($content['content']))

                        @foreach($content['content'] as $contentData)
                            @include('cms_page.partials.content', ['content' => $contentData])
                        @endforeach

                    @endif
                </div>
            </div>
        </div>
    @endforeach

</div>


<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var notyf = new Notyf();
        // Funkcja, która zapisuje dane z pojedynczego input/textarea
        function saveFormData(event) {
            const input = event.target; // Pobierz aktualnie zmodyfikowane pole
            const formData = {};

            // Dodaj dane do obiektu formData (tylko jedno pole)
            const key = input.name; // name jako klucz
            let value;

            // Sprawdź, czy pole to checkbox
            if (input.type === 'checkbox') {
                value = input.checked ? 1 : 0; // Zapisz 1 jeśli zaznaczone, 0 jeśli nie
            } else {
                value = input.value; // Wartość wpisana przez użytkownika (dla input i textarea)
            }

            if (key) {
                formData[key] = value;
            }

            // Wyślij dane na backend metodą POST
            fetch('{{ route('pages.updateKey', ['article' => $article->id]) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            })
                .then(response => response.json())
                .then(data => {
                    console.log('Dane zapisane:', data);
                    if(data.result.changes){
                        notyf.success('Zapisano informacje');
                    }
                })
                .catch(error => {
                    console.error('Błąd:', error);
                    // notyf.error('Wystąpił błąd podczas zapisywania danych');
                });
        }

        // Nasłuchiwanie eventów blur na input[type="text"] i textarea
        const inputs = document.querySelectorAll('input[type="text"],input[type="checkbox"], textarea');
        inputs.forEach(input => {
            input.addEventListener('blur', saveFormData); // Event na opuszczenie pola
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        var notyf = new Notyf();
        const imageUploadElements = document.querySelectorAll('input[type="file"][id^="image-upload-"]');

        imageUploadElements.forEach((inputElement) => {
            inputElement.addEventListener('change', async function(event) {
                const file = event.target.files[0];
                const elementKey = event.target.id.replace('image-upload-', ''); // Extract element key

                if (file) {
                    const formData = new FormData();
                    formData.append('file', file);
                    formData.append('key', elementKey);

                    console.log(elementKey)

                    try {
                        const response = await fetch('{{ route('pages.updateImage', ['article' => $article->id]) }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: formData
                        })
                            .then(response => response.json())
                            .then(data => {
                                console.log('Dane zapisane:', data);
                                notyf.success('Zapisano informacje');
                                const previewImage = document.getElementById(`preview-image-${elementKey}`);
                                previewImage.src = data.filePath;
                            })
                            .catch(error => {
                                console.error('Błąd:', error);
                                notyf.error('Wystąpił błąd podczas zapisywania danych');
                            });
                    } catch (error) {
                        console.error('Error during upload', error);
                    }
                }
            });
        });
    });
</script>
