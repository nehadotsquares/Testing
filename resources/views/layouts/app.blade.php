<!DOCTYPE html>
<html>
<head>
    <title>CRUD</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">CRUD</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    @if(Auth::check())
                        <li class="nav-item">
                            <span class="nav-link">Welcome! {{ Auth::user()->name }}
                                @if(Auth::user()->upload)
                                    <img src="{{ asset('storage/' . Auth::user()->upload->file_path) }}" 
                                        alt="Profile Image" 
                                        class="rounded-circle ms-2" 
                                        width="35" 
                                        height="35" 
                                        style="object-fit: cover;">
                                @endif
                            </span>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item"><a href="{{ url('/login') }}" class="nav-link">Login</a></li>
                        <li class="nav-item"><a href="{{ url('/register') }}" class="nav-link">Register</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @yield('content')
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).on('click', '.delete-btn', function () {
            let form = $(this).closest('form');

            Swal.fire({
                title: 'Are you sure?',
                text: "This post will be deleted permanently!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>
    <!-- <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script> -->
    <!-- <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script> -->
     <script src="https://cdn.ckeditor.com/ckeditor5/41.2.0/classic/ckeditor.js"></script>
    <script>
        document.querySelectorAll('.editor').forEach((el) => {
            ClassicEditor
                .create(el, {
                    // ckfinder: {
                    //     uploadUrl: "{{ route('ckeditor.upload') }}?_token={{ csrf_token() }}"
                    // }
                    extraPlugins: [ MyCustomUploadAdapterPlugin ]
                })
                .catch(error => {
                    console.error(error);
                });
        });

        class MyUploadAdapter {
            constructor(loader) {
                this.loader = loader;
            }

            upload() {
                return this.loader.file.then(file => {
                    const data = new FormData();
                    data.append('upload', file);
                    data.append('_token', '{{ csrf_token() }}');

                    return fetch("{{ route('ckeditor.upload') }}", {
                        method: 'POST',
                        body: data
                    })
                    .then(res => res.json())
                    .then(res => ({
                        default: res.default   // required key
                    }));
                });
            }

            abort() {}
        }

        function MyCustomUploadAdapterPlugin(editor) {
            editor.plugins.get('FileRepository').createUploadAdapter = loader => {
                return new MyUploadAdapter(loader);
            };
        }
    </script>

    <!-- rating number -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const slider = document.getElementById('rating');
            const output = document.getElementById('ratingValue');

            if (slider) {
                output.textContent = slider.value;

                slider.addEventListener('input', function () {
                    output.textContent = this.value;
                });
            }
        });
    </script>
    @yield('scripts')
</body>
</html>