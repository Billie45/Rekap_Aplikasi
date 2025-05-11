@props([
    'headers' => [],
    'rows' => [],
])

<div class="table-wrapper mt-3">
    <table class="compact-table">
        <thead>
            <tr>
                @foreach ($headers as $head)
                    <th>{{ $head }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($rows as $row)
                <tr>
                    @foreach ($row as $cell)
                        <td>{!! $cell !!}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
