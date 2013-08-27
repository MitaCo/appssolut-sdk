@foreach($table_data as $key => $value)
<table  class="table table-condensed cf give_table user_list">
    <thead class="cf">
    <tr>
        <th  scope="col">Entry No. / {{ $key }}</th>
        <th  scope="col">Date entered</th>
        @foreach($value['labels'] as $label)
        <th  scope="col">{{ $label }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    <?php $i = 1; ?>
    @foreach($value['entries'] as $entry)
    <tr>
        <td data-title="Entry">{{ $i++ }}</td>
        <td data-title="Date">{{ $entry->created_at }}</td>
        @foreach($value['labels'] as $key => $label)
        <td data-title="data_{{ $key }}">{{ @$value['values'][$entry->id][$key] }}</td>
        @endforeach
    </tr>
    @endforeach
    </tbody>
</table>
@endforeach