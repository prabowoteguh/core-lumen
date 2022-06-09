<h1>Pembaharuan perizinan yang anda ajukan</h1>
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
		<td>{{ \App\Models\PermittanceType::where('id', $permittance_type_id)->value('name') }}</td>
	</tr>
	<tr>
		<td>Keterangan</td>
		<td>:</td>
		<td>{{ $description }}</td>
	</tr>
	@php
		$dateStart = date_create($date_start);
		$dateEnd   = date_create($date_end);
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
	<tr>
		<td>Status</td>
		<td>:</td>
		<td>{{ ($approval_status == 1 ? "Diizinkan" : "Ditolak") }}</td>
	</tr>
	<tr>
		<td>Note Approval</td>
		<td>:</td>
		<td>{{ $approval_note }}</td>
	</tr>
	<tr>
		<td>Pemberi Ijin</td>
		<td>:</td>
		<td>{{ \App\Models\User::where('id', $user_approval_id)->value('name') }}</td>
	</tr>
</table>