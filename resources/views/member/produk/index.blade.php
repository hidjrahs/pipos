@extends('member.layouts.layout')

@section('konten')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="card mb-4">
            <h5 class="card-header">produk
                {!! statusBtn() !!}
            </h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-3 col-6 mt-2">
                        <select name="kategori" id="kategori" class="form-control kategori-select" multiple
                            onchange="datatables.ajax.reload()" data-ajax--url="{{ route('drop-kategori') }}"></select>
                    </div>
                    <div class="col-sm-4 col-6 mt-2"><input type="text" id="cari" class="form-control"
                            placeholder="Cari...">
                    </div>
                    <div class="col-sm-5 col-6 mt-2">
                        @haspermission('PRODUK_CREATE')
                            <a href="{{ route('produk.create') }}" class="btn btn-sm btn-primary float-end">Tambah</a>
                        @endhaspermission

                        @haspermission('PRODUK_PRINT')
                            {!! exportBtn('data', route('produk.ajax'), 'DATA PRODUK') !!}
                        @endhaspermission
                    </div>
                </div>

                @if (session()->has('pesan'))
                    {!! session('pesan') !!}
                @endif
            </div>

            <table class="table table-hover display nowrap mb-4" id="datatable">
                <thead>
                    <tr>
                        <th>foto</th>
                        <th>produk</th>
                        <th>kategori</th>
                        <th>stok</th>
                        <th>harga</th>
                        <th>status</th>
                        <th>ditambahkan</th>
                        <th></th>
                    </tr>
                </thead>
            </table>

        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="modalDetailTable" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalDetailTableLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDetailTableLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalDetailTableBody">

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>

    <script>
        var datatables = $('#datatable').DataTable({
            scrollX: true,
            scrollY: false,
            processing: true,
            serverSide: true,
            searching: false,
            lengthChange: false,
            pageLength: 10,
            bDestroy: true,
            info: false,
            responsive: true,
            order: [
                [6, 'desc']
            ],
            ajax: {
                url: "{{ route('produk.ajax') }}",
                type: "POST",
                data: function(d) {
                    d._token = $("input[name=_token]").val();
                    d.kategori = $("#kategori").val();
                    d.status = $('.btn-check:checked').val();
                    d.cari = $('#cari').val();
                },
            },
            columns: [{
                    data: 'foto'
                },
                {
                    data: 'produk'
                },
                {
                    data: 'kategori_id'
                },
                {
                    data: 'stok',
                },
                {
                    data: 'harga',
                    render: function(data) {
                        return formatRupiah(data);
                    }
                },
                {
                    data: 'status'
                },
                {
                    data: 'created_at'
                },
                {
                    data: 'aksi'
                },
            ]
        });

        $('#cari').keyup(function() {
            datatables.search($('#cari').val()).draw();
        });

        function formatRupiah(angka) {
            var reverse = angka.toString().split('').reverse().join('');
            var ribuan = reverse.match(/\d{1,3}/g);
            var hasil = ribuan.join('.').split('').reverse().join('');
            return 'Rp ' + hasil;
        }
    </script>
@endsection