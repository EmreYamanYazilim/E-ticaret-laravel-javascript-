@extends('layouts.admin')
@section('title', 'Kategori Listesi')

@push("css")
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
                    @foreach($categories as $category)
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
                                       class="text-danger btn-delete-category"
                                       data-feather="trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="col-6 mx-auto mt-3">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>

    </script>
@endpush
