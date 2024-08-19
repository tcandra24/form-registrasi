<div class="title" style="padding-bottom: 13px">
    <div style="text-align: center;text-transform: uppercase;font-size: 15px">
        Fuboru Registrasi
    </div>
</div>
<table style="width: 100%">
    <thead>
        <tr style="background-color: #e6e6e7;">
            <th scope="col">No</th>

            @foreach ($fields as $field)
                <th scope="col">{{ $field['label'] }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($registrations as $registration)
            <tr>
                <td>{{ $loop->iteration }}</td>
                @foreach ($fields as $field)
                    <td>
                        {{ $field['model_path'] !== null ? $registration->{$field['relation_method_name']}->name : $registration->{$field['name']} }}
                    </td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
