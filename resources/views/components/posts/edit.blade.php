@push('css')
    <!-- Quill Editor CSS -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endpush
<div class="relative p-4 max-w-4xl bg-white rounded-lg border dark:bg-gray-800 sm:p-5">
    <!-- Edit Post Modal -->
    <!-- Modal header -->
    <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Edit Post</h3>
    </div>
    <!-- Modal body -->
    <form action="/posting/{{ $post->slug }}" method="POST">
        @csrf
        @method('PATCH')
        <!-- Title Input -->
        <div class="mb-4">
            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
            <input type="text" name="title" id="title"
                class="text-sm rounded-lg block w-full p-2.5 border dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('title') bg-red-50 border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500 @else border-gray-300 text-gray-900 focus:ring-primary-600 focus:border-primary-600 @enderror"
                placeholder="Type post title" autofocus value="{{ old('title') ?? $post->title }}">
            @error('title')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span>
                    {{ $message }}</p>
            @enderror
        </div>
        <!-- Category Select -->
        <div class="mb-4">
            <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
            <select name="category_id" id="category"
                class="text-sm rounded-lg block w-full p-2.5 border dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('category_id') bg-red-50 border-red-500 text-red-700 placeholder-red-700 focus:ring-red-500 focus:border-red-500 @else border-gray-300 text-gray-900 focus:ring-primary-500 focus:border-primary-500 @enderror">
                <option selected value="">Select post category</option>
                @foreach (App\Models\Category::all() as $category)
                    <option value="{{ $category->id }}" @selected((old('category_id') ?? $post->category_id) == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span>
                    {{ $message }}</p>
            @enderror
        </div>
        <!-- Body Input with Quill Editor -->
        <div class="mb-4">
            <label for="body" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Body</label>
            <div id="quill-editor" style="height: 200px;">{!! old('body') ?? $post->body !!}</div>
            <input type="hidden" name="body" id="body" value="{{ old('body') ?? $post->body }}">
            @error('body')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span>
                    {{ $message }}</p>
            @enderror
        </div>
        <!-- Action Buttons -->
        <div class="flex gap-2">
            <button type="submit"
                class="text-white inline-flex items-center bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 cursor-pointer">
                Update post
            </button>
            <a href="/posting"
                class="inline-flex items-center text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900 cursor-pointer">
                Cancel
            </a>
        </div>
    </form>
</div>
@push('js')
    <!-- Quill Editor JS -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var quill = new Quill('#quill-editor', {
                theme: 'snow',
                placeholder: 'Write post body here',
                modules: {
                    toolbar: [
                        [{
                            header: [1, 2, false]
                        }],
                        ['bold', 'italic', 'underline'],
                        ['link', 'blockquote', 'code-block', 'image'],
                        [{
                            list: 'ordered'
                        }, {
                            list: 'bullet'
                        }]
                    ]
                }
            });
            // Sync Quill content to hidden input on submit
            var form = document.querySelector('form[action^="/posting/"]');
            if (form) {
                form.addEventListener('submit', function() {
                    document.getElementById('body').value = quill.root.innerHTML;
                });
            }
        });
    </script>
@endpush
