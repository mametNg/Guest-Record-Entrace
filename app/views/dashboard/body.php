<?php if ($this->allowFile): ?>


	<!-- Page Heading -->
	<h1 class="h3 mb-4 text-gray-800 main-cls" main="home-panel">DASHBOARD</h1>
	<div class="row">
		<div class="col-lg-6 mb-4">
			<div class="card shadow mb-4">
				<div class="card-body">
					<div class="text-center">
						<img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="https://42f2671d685f51e10fc6-b9fcecea3e50b3b59bdc28dead054ebc.ssl.cf5.rackcdn.com/illustrations/creative_team_r90h.svg" alt="">
					</div>
					<p>Hello <?= $this->e(ucwords($data['users']['profile']['name'])) ?>, Welcome to Panel Dashboard.</p>
				</div>
			</div>
		</div>
		<div class="col-lg-6 mb-4">
			<div class="card mb-3">
				<div class="row no-gutters">
					<div class="col-md-4">
						<img src="<?= $this->base_url() ?>/assets/img/account/<?= $this->e($data['users']['profile']['img']) ?>" class="card-img" alt="<?= $this->e(ucwords($data['users']['profile']['name'])) ?>">
					</div>
					<div class="col-md-8">
						<div class="card-body">
							<h5 class="card-title"><?= $this->e(ucwords($data['users']['profile']['name'])) ?></h5>
							<p class="card-text my-1">Email : <?= $this->e(strtolower($data['users']['profile']['email'])) ?></p>
							<p class="card-text my-1"><small class="text-muted">Created Account <?= $this->e(date("d F Y", $data['users']['profile']['created'])) ?></small></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>