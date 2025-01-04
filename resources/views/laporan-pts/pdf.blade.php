<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Jejak Pembinaan - {{ $pts->nama_pt }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h2, h3 { text-align: center; }
        
        /* Table Styling */
        .timeline-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border: 1px solid #cccccc; /* Outer border in light gray */
        }

        .timeline-table th, .timeline-table td {
            border: 1px solid #cccccc; /* Cell borders in light gray */
            padding: 8px;
            vertical-align: top;
        }

        .separator {
            height: 1px;
            background-color: #cccccc; /* Gray separator between tables */
            margin: 20px 0;
        }

        .label { font-weight: bold; }
    </style>
</head>
<body>
    <h3>
        Jejak Pembinaan <br>
        {{ $pts->nama_pt }}
    </h3>
    {{-- <h3></h3> --}}

    @foreach($laporan->sortByDesc('tanggal_kegiatan') as $item)
    <table class="timeline-table">
        <tr>
            <td class="label">Tanggal Kegiatan:</td>
            <td>{{ \Carbon\Carbon::parse($item->tanggal_kegiatan)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</td>
            <td class="label">Tanggal Dibuat:</td>
            <td>{{ \Carbon\Carbon::parse($item->created_at)->timezone('Asia/Jakarta')->locale('id')->isoFormat('dddd, D MMMM YYYY [pukul] HH:mm [WIB]') }}</td>
        </tr>
        <tr>
            <td class="label">Jenis Kegiatan:</td>
            <td>{{ $item->jenis_kegiatan }}</td>
            <td class="label">Dibuat Oleh:</td>
            <td>{{ $item->createdbyuser }}</td>
        </tr>
        <tr>
            <td class="label">Tempat Kegiatan:</td>
            <td>{{ $item->tempat_kegiatan }}</td>
            <td class="label">Lingkup Tim Kerja:</td>
            <td>
                <ul style="margin: -5px 0 0 -20px;">
                    @foreach(explode(';', $item->pokja) as $anggota)
                        <li>{{ trim($anggota) }}</li>
                    @endforeach
                </ul>
            </td>            
        </tr>
        <tr>
            <td class="label">Ringkasan Kegiatan:</td>
            <td colspan="3">{{ $item->resume }}</td>
        </tr>
    </table>
    
    <div class="separator"></div> <!-- Gray separator between tables -->
    
    @endforeach

</body>
</html>
