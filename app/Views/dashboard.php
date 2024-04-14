<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>




<div class="row">
	<div class="col-md-12 my-2 card">
		<div>
			<form class="input-group p-3" action="" method="GET">
				<span class="input-group-text">Pilih Poli</span>
				<select name="poli" class="form-select form-select-sm ">
					<option>Daftar Poli</option>
					<?php foreach ($serviceunits as $serviceunit) : ?>
						<option value="<?= $serviceunit['id'] ?>" <?= ($serviceunit['id'] == $poli) ? "Selected" : "" ?>><?= $serviceunit['service_name'] ?></option>
					<?php endforeach ?>
				</select>
				<button type="submit" class="btn btn-outline-primary btn-sm "> <i class="lni lni-search"></i>Tampil</button>
			</form>
		</div>
	</div>
	<div class="col-md-12 my-2 card">

	</div>
	<div class="col-md-12 my-2 card">
		<canvas id="chart"></canvas>
	</div>
	<div class="col-md-12 my-2 card">
		<div class="input-group m-3">
			<span class="input-group-text">
				Jumlah Keterlambatan Rekam Medis
			</span>
			<input type="text" class="form-control" value="<?= $count['count_late'] ?>" readonly>
		</div>
	</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
	var data_total_loans = []
	var data_total_return = []
	var data_labels = []


	<?php foreach ($transactions as $transaction) : ?>
		data_total_loans.push(<?= $transaction['totalloan'] ?>);
		data_total_return.push(<?= $transaction['totalreturn'] ?>)
		data_labels.push(<?= $transaction['month'] ?>);
	<?php endforeach ?>

	const data = {
		labels: data_labels,
		datasets: [{
				label: 'Grafik Peminjaman',
				data: data_total_loans,
				backgroundColor: [
					'rgba(255, 99, 132, 0.2)',
				],
				borderColor: [
					'rgb(255, 99, 132)',
				],
				borderWidth: 1
			},
			{
				label: 'Grafik Pengembalian',
				data: data_total_return,
				backgroundColor: [
					'rgba(54, 162, 235, 0.2)',
				],
				borderColor: [
					'rgb(54, 162, 235)',
				],
				borderWidth: 1
			}
		]
	};

	const config = {
		type: 'bar',
		data: data,
		options: {
			scales: {
				y: {
					beginAtZero: true
				}
			}
		},
	}

	var chart = new Chart(
		document.getElementById('chart'),
		config
	)
</script>



<?= $this->endSection() ?>