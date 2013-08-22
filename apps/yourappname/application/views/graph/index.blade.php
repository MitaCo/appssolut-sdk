<table  class="table table-condensed cf give_table user_list">
    <thead class="cf">
    <tr>
        <th  scope="col">Rank</th>
        <th  scope="col">Title</th>
        <th  scope="col">Votes</th>
        <th  scope="col">Last vote</th>
        <th  scope="col">Regular price</th>
        <th  scope="col">Discounted price</th>
        <th  scope="col">Type</th>
        <th  scope="col">End date and time</th>
    </tr>
    </thead>

    <tbody>
    <?php $i = 1; ?>
    @foreach($items as $item)
    <tr>
        <td data-title="Rank">{{ $i++ }}</td>
        <td data-title="Title">{{ $item->title }}</td>
        <td data-title="Votes">{{ $votes[$item->id] }}</td>
        <td data-title="Last vote">{{ $last_vote[$item->id] }}</td>
        <td data-title="Regular price">{{ $item->regular_price }}</td>
        <td data-title="Discounted price">{{ $item->discounted_price }}</td>
        <td data-title="Type">{{ (File::extension($item->image) == 'mp4') ? 'Video' : 'Photo' }}</td>
        <td data-title="End date and time">{{ date('d.m.Y H:i', strtotime($instance->setting->end)) }}</td>
    </tr>
    @endforeach
    </tbody>
</table>