<h1>Pengajuan perizinan</h1>
<br><br>
<table>
	<tr>
		<td>Nama</td>
		<td>:</td>
		<td>{{ auth()->user()->name }}</td>
	</tr>
	<tr>
		<td>Alasan</td>
		<td>:</td>
		<td>{{ $data['permittance_type'] }}</td>
	</tr>
	<tr>
		<td>Keterangan</td>
		<td>:</td>
		<td>{{ $data['description'] }}</td>
	</tr>
	@php
		$dateStart = date_create($data['date_start']);
		$dateEnd   = date_create($data['date_end']);
		$diff      = date_diff($dateStart, $dateEnd);
	@endphp
	<tr>
		<td>Jumlah Hari</td>
		<td>:</td>
		<td>{{ $diff->format("%a hari") }}</td>
	</tr>
	<tr>
		<td>Terhitung</td>
		<td>:</td>
		<td>{{ date_format($dateStart,"d F Y").' s.d '.date_format($dateEnd,"d F Y") }}</td>
	</tr>
</table>