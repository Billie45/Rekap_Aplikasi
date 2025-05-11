@props(['data' => []])

<div class="bg-white rounded shadow p-4">
    <table class="table-auto w-full border border-gray-100">
        <tbody>
            @foreach($data as $row)
                <tr class="border-t">
                    <th class="text-left w-1/3 p-2 bg-gray-100">{{ $row['label'] }}</th>
                    <td class="p-2">{!! $row['value'] !!}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
