<table {!! $htmlOptions !!}>
	<thead>
		<tr>
			@foreach ($headerColumns as $column)
				@if ($column['rawLabel'])
					<th>{!! $column['label'] !!}</th>
				@else
					<th>{{ ucwords(str_replace('_', ' ', $column['label'])) }}</th>
				@endif
			@endforeach
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>

{{-- <link href="{{ asset('assets/theme/vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" /> --}}
{{-- <script src="{{ asset('assets/theme/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script> --}}

@section('datatable-resource')
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/datatable-builder/plugins/datatable/dataTables.bootstrap4.min.css') }}">
<script type="text/javascript" src="{{ asset('vendor/datatable-builder/plugins/datatable/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/datatable-builder/plugins/datatable/dataTables.bootstrap4.min.js') }}"></script>
@endsection

<script type="text/javascript">
	var dtColumns_{{ $elOptions['id'] }} = [], dtOptions_{{ $elOptions['id'] }} = {!! json_encode($pluginOptions) !!}, dt_{{ $elOptions['id'] }};


	@foreach ($attributeColumns as $c)
		@if (is_array($c))
			dtColumns_{{ $elOptions['id'] }}.push({!! json_encode($c) !!})
		@else
			var row = {
				data: "{{ $c }}"
			}

			@if ($c == 'action')
			row.searchable = false
			row.sortable = false
			@endif
			dtColumns_{{ $elOptions['id'] }}.push(row)
		@endif

	@endforeach
	dtOptions_{{ $elOptions['id'] }}.columns = dtColumns_{{ $elOptions['id'] }};



	@if ($sourceByAjax)

		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});
		dtOptions_{{ $elOptions['id'] }}.processing = true;
		dtOptions_{{ $elOptions['id'] }}.serverSide = true;
		dtOptions_{{ $elOptions['id'] }}.ajax.url =  "{{ $source }}";


		// FILTERS PARAMETER
		dtOptions_{{ $elOptions['id'] }}.ajax.data = {}
		dtOptions_{{ $elOptions['id'] }}.ajax.data.filters = {}
		@foreach ($filters ?? [] as $field => $val)

			dtOptions_{{ $elOptions['id'] }}.ajax.data.filters.{{$field}} = {!! $val !!}
			@if (ends_with($val, '.val()' ))
				<?php $el = str_replace('.val()', '', $val) ?>
				{!! $el !!}.on('change', function(event) {
					dtOptions_{{ $elOptions['id'] }}.ajax.data.filters.{{$field}} = $(this).val()
				});
			@endif

		@endforeach

	@else

		delete dtOptions_{{ $elOptions['id'] }}.ajax;

	@endif



	console.log(dtOptions_{{ $elOptions['id'] }})

	var dataTableInit_{{ $elOptions['id'] }} = function() {
		dataTable_{{ $elOptions['id'] }} = $('#{{ $elOptions['id'] }}').DataTable(dtOptions_{{ $elOptions['id'] }});
	}

	var dataTableFilter_{{ $elOptions['id'] }} = function(){
		$('#{{ $elOptions['id'] }}').DataTable().clear();
        $('#{{ $elOptions['id'] }}').DataTable().destroy();
        
		dataTableInit_{{ $elOptions['id'] }}()
	}

	var dataTableReload_{{ $elOptions['id'] }} = function(){
		var scrollingContainer = $("#{{ $elOptions['id'] }}").parent('div.dataTables_scrollBody');
		var scrollTop = scrollingContainer.scrollTop();

		dataTable_{{ $elOptions['id'] }}.ajax.reload(function() {
			scrollingContainer.scrollTop(scrollTop);
		}, false);
	}

	$(document).ready(function() {
		dataTableInit_{{ $elOptions['id'] }}()
	});
</script>