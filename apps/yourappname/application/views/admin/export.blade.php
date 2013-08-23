<!doctype html>

<html>
<head>
    <meta charset="utf-8">
</head>
<body>
@foreach($table_data as $key => $value)
<table border="1">
    <thead>
    <tr>
        <th>Entry No. / {{ $key }}</th>
        <th>Date entered</th>
        @foreach($value['labels'] as $label)
        <th>{{ $label }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    <?php $i = 1; ?>
    @foreach($value['entries'] as $entry)
    <tr>
        <td>{{ $i++ }}</td>
        <td>{{ $entry->created_at }}</td>
        @foreach($value['labels'] as $key => $label)
        <td>{{ @$value['values'][$entry->id][$key] }}</td>
        @endforeach
    </tr>
    @endforeach
    </tbody>
</table>
<br />
@endforeach

<table border="1">
    <thead>
    <tr>
        <th>Rank</th>
        <th>Title</th>
        <th>Votes</th>
        <th>Last vote</th>
        <th>Regular price</th>
        <th>Discounted price</th>
        <th>Type</th>
    </tr>
    </thead>

    <tbody>
    <?php $i = 1; ?>
    @foreach($items as $item)
    <tr>
        <td>{{ $i++ }}</td>
        <td>{{ $item->title }}</td>
        <td>{{ $votes[$item->id] }}</td>
        <td>{{ $last_vote[$item->id] }}</td>
        <td>{{ $item->regular_price }}</td>
        <td>{{ $item->discounted_price }}</td>
        <td>{{ is_array(@getimagesize(URL::to(str_replace('.mp4', '-00001.png', $item->image)))) ? 'Photo' : 'Video' }}</td>
    </tr>
    @endforeach
    </tbody>
</table>
</body>