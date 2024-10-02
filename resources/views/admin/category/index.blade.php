@extends('layouts.admin')
@section('title', 'Kategori Listesi')

@push('css')
@endpush

@section('body')
    <div class="card">
        <div class="card-body">
            <h6 class="card-title">Kategori Listesi</h6>
            <div class="table-responsive pt-3">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kategori Adı</th>
                            <th>Slug</th>
                            <th>Durum</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->slug }}</td>
                                <td>
                                    @if ($category->status)
                                        <a href="javascript:void(0)" class="btn btn-inverse-success btn-change-status"
                                            data-id="{{ $category->id }}">Aktif</a>
                                    @else
                                        <a href="javascript:void(0)" class="btn btn-inverse-danger btn-change-status"
                                            data-id="{{ $category->id }}">Pasif</a>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.category.edit', ['category' => $category->id]) }}"><i
                                            class="text-warning" data-feather="edit"></i></a>
                                    <a href="javascript:void(0)">
                                        <i data-id="{{ $category->id }}" data-name="{{ $category->name }}"
                                            class="text-danger btn-delete-category" data-feather="trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <form action="" method="POST" id="deleteForm">
                    @csrf
                    @method('DELETE')
                </form>
                <div class="col-6 mx-auto mt-3">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let deleteForm = document.querySelector('#deleteForm');

            document.querySelector('.table').addEventListener('click', function(event) {
                let element = event.target;
                let categoryName = element.getAttribute('data-name');
                if (element.classList.contains('btn-delete-category')) {

                    Swal.fire({
                        title: categoryName + " Kategorisini silmek istediğinize emin misiniz?",
                        showCancelButton: true,
                        confirmButtonText: "Evet",
                        cancelButtonText: "Hayır"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let dataID = element.getAttribute('data-id');
                            //rotanın her zaman ne olduğunu bulabilmek için değişkene veriyorum
                            let route ='{{ route('admin.category.destroy', ['category' => 'eyy_cat']) }}'
                            route = route.replace('eyy_cat', dataID)
                            deleteForm.action = route;
                            setTimeout(deleteForm.submit(), 100);
                            Swal.fire("Silindi", "", "success");
                        } else if (result.isDenied) {
                            Swal.fire("Kategori silinmedi", "", "info");
                        }
                    });

                }




            });
        });
    </script>
@endpush
