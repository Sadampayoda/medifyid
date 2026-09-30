<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

<script>
    var start_date = '';
    var end_date = '';
    var data_per_fetch = 500;
    var data_fetched = 0;

    $(document).ready(function() {
        $('#table').DataTable({
            searching: false,
            order: [[0, 'desc']],
            columnDefs: [{ targets: -1, orderable: false }],
        });
        getData()
    });

    $('.btn-get-data').click(function() {
        getData()
    })

    function getData(){

        $('#loading-filter').show();
        var dataTableObj = $('#table').DataTable();
        var filter_kode = $('#filter-kode').val()
        var filter_nama = $('#filter-nama').val()
        dataTableObj.clear().draw();

        $.ajax({
            url: '{{url("category-items/search")}}',
            dataType: 'json',
            tryCount: 0,
            retryLimit: 3,
            data: {
                kode: filter_kode,
                nama: filter_nama
            },
            success: function(results) {
                var data = results.data
                var rows = [];

                $.each(data, function(index, item) {
                    var array_temp = [];
                    var id = item.id;

                    var baseUrl = `{{ url('category-items') }}`;

                    var html = `
                        <a href="${baseUrl}/${id}" class="btn btn-primary btn-sm">View</a>
                        <a href="${baseUrl}/${id}/print" class="btn btn-danger btn-sm" target="_blank">Print PDF</a>
                        <a href="${baseUrl}/${id}/edit" class="btn btn-info btn-sm">Edit</a>
                        <form action="${baseUrl}/${id}" method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin hapus kategori ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-warning btn-sm">Delete</button>
                        </form>
                    `;

                    $.each(item, function(obj_name, obj_value) {
                        if(obj_name === 'id'){
                            return;
                        }
                        array_temp.push(obj_value)
                    })

                    array_temp.push(html)

                    rows.push(array_temp);
                });

                dataTableObj.rows.add(rows).draw();
                $('#loading-filter').hide();
            },
            error: function(xhr, textStatus, errorThrown) {
                this.tryCount++;
                if (this.tryCount <= this.retryLimit) {
                    $.ajax(this);
                    return;
                }
                alert('Terjadi kesalahan server, tidak dapat mengambil data')
                $('#loading-filter').hide();

                return;
            }
        })
    }
</script>