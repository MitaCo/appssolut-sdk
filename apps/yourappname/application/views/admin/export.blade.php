<!doctype html>

<html>
<head>
    <meta charset="utf-8">
</head>
<body>
@foreach($table_data as $data)
<table border="1">
    <thead>
    <tr>
        <th>{{ $data['target']->title }}</th>
        <th>Date entered</th>
        @foreach($data['labels'] as $label)
        <th>{{ $label }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    <?php $i = 1; ?>
    @foreach($data['entries'] as $entry)
    <tr>
        <td>{{ $i++ }}</td>
        <td>{{ $entry->created_at }}</td>
        @foreach($data['labels'] as $key => $label)
        <td>{{ @$data['values'][$entry->id][$key] }}</td>
        @endforeach
    </tr>
    @endforeach
    </tbody>
</table>
<br />
@endforeach
</body>