<!doctype html>

<html>
<head>
    <meta charset="utf-8">
</head>
<body>
@foreach($languages as $key => $language)
<table border="1">
    <thead>
    <tr>
        <th>Entry No. / {{ $key }}</th>
        <th>Date entered</th>
        @foreach($language['labels'] as $label)
        <th>{{ $label }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    <?php $i = 1; ?>
    @foreach($language['entries'] as $entry)
    <tr>
        <td>{{ $i++ }}</td>
        <td>{{ $entry->created_at }}</td>
        @foreach($language['labels'] as $key => $label)
        <td>{{ @$language['values'][$entry->id][$key] }}</td>
        @endforeach
    </tr>
    @endforeach
    </tbody>
</table>
<br />
@endforeach
</body>