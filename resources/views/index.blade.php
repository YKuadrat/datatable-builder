<table {!! $htmlOptions !!}>
	<thead>
		<tr>
			@foreach ($headerColumns as $column)
			<th>{{ ucwords(str_replace('_', ' ', $column)) }}</th>
			@endforeach
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>

{{-- <link href="{{ asset('assets/theme/vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" /> --}}
{{-- <script src="{{ asset('assets/theme/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script> --}}

@section('datatable-section')
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/form-builder/plugins/datatable/dataTables.bootstrap4.min.css') }}">
<script type="text/javascript" src="{{ asset('vendor/form-builder/plugins/datatable/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/form-builder/plugins/datatable/dataTables.bootstrap4.min.js') }}"></script>
@endsection

<script type="text/javascript">
	var dtColumns = [], dtOptions = {!! json_encode($pluginOptions) !!};


	@foreach ($attributeColumns as $c)
		var row = {
			data: "{{ $c }}"
		}

		@if ($c == 'action')
		row.searchable = false
		row.sortable = false
		@endif

		dtColumns.push(row)
	@endforeach
	dtOptions.columns = dtColumns;



	@if ($sourceByAjax)

		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});
		dtOptions.processing = true;
		dtOptions.serverSide = true;
		dtOptions.ajax.url =  "{{ $source }}";


		// FILTERS PARAMETER
		dtOptions.ajax.data = {}
		dtOptions.ajax.data.filters = {}
		@foreach ($filters as $field => $val)
			dtOptions.ajax.data.filters.{{$field}} = {!! $val !!}.val()
			{!! $val !!}.on('change, keyup', function(event) {
				dtOptions.ajax.data.filters.{{$field}} = $(this).val()
			});
		@endforeach

	@else

		delete dtOptions.ajax;

	@endif



	console.log(dtOptions)

	var dataTableInit_{{ $elOptions['id'] }} = function() {
		$('#{{ $elOptions['id'] }}').DataTable(dtOptions);
	}

	var dataTableFilter_{{ $elOptions['id'] }} = function(){
		$('#{{ $elOptions['id'] }}').DataTable().clear();
        $('#{{ $elOptions['id'] }}').DataTable().destroy();
        
		dataTableInit_{{ $elOptions['id'] }}()
	}

	$(document).ready(function() {
		dataTableInit_{{ $elOptions['id'] }}()
	});
</script>