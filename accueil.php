<?php $current = "accueil";

require_once("./navigation.php");
require_once("./PHP_SCRIPT/Utiles.php");

if ($_SESSION["login"] && $_SESSION["role"] != 2) {
	$name = $_SESSION["nom"];
	$role = $_SESSION["role"];
	$ch;

?>

	<h1 class="h3 mb-3" id="test"><strong>Bienvenue,</strong> <?php echo $name; ?></h1>
	<div class="row">
		<?php if ($role == 4) {
			$total = mysqli_num_rows(mysqli_query($connect, "SELECT * from pharmacie"));
			$repture = mysqli_num_rows(mysqli_query($connect, "SELECT * from pharmacie where stock=0"));
			$Prerepture = mysqli_num_rows(mysqli_query($connect, "SELECT * from pharmacie where stock<5"));
			$max = mysqli_fetch_array(mysqli_query($connect, "SELECT nom from pharmacie ORDER BY stock DESC LIMIT 1"));
		?>
			<div class="col-xl-6 col-xxl-5 d-flex" style="width: 100%;">
				<div class="w-100">
					<div class="row">
						<div class="col-sm-6">
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col mt-0">
											<h5 class="card-title">Total des medicaments</h5>
										</div>

										<div class="col-auto">
											<div class="stat text-primary">
												<i class="fa fa-pills align-middle"></i>
											</div>
										</div>
									</div>
									<h1 class="mt-1 mb-3"><?php echo $total ?></h1>

								</div>
							</div>
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col mt-0">
											<h5 class="card-title">Total des médicaments en reptures de stock</h5>
										</div>

										<div class="col-auto">
											<div class="stat text-primary">
												<i style="color:red" class="fa fa-battery-empty align-middle"></i>
											</div>
										</div>
									</div>
									<h1 class="mt-1 mb-3" style=""><?php echo $repture; ?></h1>

								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col mt-0">
											<h5 class="card-title">Médicaments Prés de repture</h5>
										</div>

										<div class="col-auto">
											<div class="stat text-primary">
												<i style="color:orange" class="fa fa-battery-quarter align-middle"></i>
											</div>
										</div>
									</div>
									<h1 class="mt-1 mb-3"><?php echo $Prerepture ?></h1>

								</div>
							</div>
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col mt-0">
											<h5 class="card-title">Médicament le plus existant</h5>
										</div>

										<div class="col-auto">
											<div class="stat text-primary">
												<i style="color:limegreen" class="fa fa-battery-full align-middle"></i>
											</div>
										</div>
									</div>
									<h1 class="mt-1 mb-3"><?php print_r($max[0]) ?></h1>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<?php if ($role == 1) {
			$total = mysqli_num_rows(mysqli_query($connect, "SELECT * from users where role = 3 or role = 4"));
			$total_doc = mysqli_num_rows(mysqli_query($connect, "SELECT * from users where role = 3"));
			$total_ph = mysqli_num_rows(mysqli_query($connect, "SELECT * from users where role = 4"));
			$repture = mysqli_num_rows(mysqli_query($connect, "SELECT * from pharmacie where stock=0"));
			$Prerepture = mysqli_num_rows(mysqli_query($connect, "SELECT * from pharmacie where stock<5"));
			$max = mysqli_fetch_array(mysqli_query($connect, "SELECT id_docteur from rendez_vous GROUP BY id_docteur ORDER BY Count(id_docteur) DESC LIMIT 1 "));


		?>
			<div class="col-xl-6 col-xxl-5 d-flex" style="width: 100%;">
				<div class="w-100">
					<div class="row">
						<div class="col-sm-6">
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col mt-0">
											<h5 class="card-title">Total des stuffs</h5>
										</div>

										<div class="col-auto">
											<div class="stat text-primary">
												<i class="fa fa-users align-middle"></i>
											</div>
										</div>
									</div>
									<h1 class="mt-1 mb-3"><?php echo $total ?></h1>

								</div>
							</div>
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col mt-0">
											<h5 class="card-title">Total des pharmaciens</h5>
										</div>

										<div class="col-auto">
											<div class="stat text-primary">
												<i style="color:blueviolet" class="fa fa-user-nurse align-middle"></i>
											</div>
										</div>
									</div>
									<h1 class="mt-1 mb-3" style=""><?php echo $total_ph; ?></h1>

								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col mt-0">
											<h5 class="card-title">Totals des docteurs</h5>
										</div>

										<div class="col-auto">
											<div class="stat text-primary">
												<i style="color:limegreen" class="fa fa-user-md align-middle"></i>
											</div>
										</div>
									</div>
									<h1 class="mt-1 mb-3"><?php echo $total_doc ?></h1>

								</div>
							</div>
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col mt-0">
											<h5 class="card-title">Docteur le plus fréquent</h5>
										</div>

										<div class="col-auto">
											<div class="stat text-primary">
												<i style="color:limegreen" class="fa fa-hospital-user align-middle"></i>
											</div>
										</div>
									</div>
									<h1 class="mt-1 mb-3"><?php echo "Dr " . GetNameByID($max[0]) ?></h1>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<?php if ($role == 0) {
			$idAd = $_SESSION["idUser"];
			$total = mysqli_num_rows(mysqli_query($connect, "SELECT * from users where userID!=$idAd "));
			$total_doc = mysqli_num_rows(mysqli_query($connect, "SELECT * from users where role = 3"));
			$total_ph = mysqli_num_rows(mysqli_query($connect, "SELECT * from users where role = 1"));
			$max = mysqli_fetch_array(mysqli_query($connect, "SELECT id_docteur from rendez_vous GROUP BY id_docteur ORDER BY Count(id_docteur) DESC LIMIT 1 "));


		?>
			<div class="col-xl-6 col-xxl-5 d-flex" style="width: 100%;">
				<div class="w-100">
					<div class="row">
						<div class="col-sm-6">
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col mt-0">
											<h5 class="card-title">Total des utilisateurs</h5>
										</div>

										<div class="col-auto">
											<div class="stat text-primary">
												<i class="fa fa-users align-middle"></i>
											</div>
										</div>
									</div>
									<h1 class="mt-1 mb-3"><?php echo $total ?></h1>

								</div>
							</div>
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col mt-0">
											<h5 class="card-title">Total des responsables stufss</h5>
										</div>

										<div class="col-auto">
											<div class="stat text-primary">
												<i style="color:blueviolet" class="fa fa-user-nurse align-middle"></i>
											</div>
										</div>
									</div>
									<h1 class="mt-1 mb-3" style=""><?php echo $total_ph; ?></h1>

								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col mt-0">
											<h5 class="card-title">Totals des docteurs</h5>
										</div>

										<div class="col-auto">
											<div class="stat text-primary">
												<i style="color:limegreen" class="fa fa-user-md align-middle"></i>
											</div>
										</div>
									</div>
									<h1 class="mt-1 mb-3"><?php echo $total_doc ?></h1>

								</div>
							</div>
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col mt-0">
											<h5 class="card-title">Docteur le plus fréquent</h5>
										</div>

										<div class="col-auto">
											<div class="stat text-primary">
												<i style="color:limegreen" class="fa fa-hospital-user align-middle"></i>
											</div>
										</div>
									</div>
									<h1 class="mt-1 mb-3"><?php echo "Dr " . GetNameByID($max[0]) ?></h1>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<?php if ($role == 3) {
			$idAd = $_SESSION["idUser"];
			$total = mysqli_num_rows(mysqli_query($connect, "SELECT * from rendez_vous where id_docteur=$idAd"));
			$enattente = mysqli_num_rows(mysqli_query($connect, "SELECT * from rendez_vous where id_docteur=$idAd and status='en attente'"));
			$confirme = mysqli_num_rows(mysqli_query($connect, "SELECT * from rendez_vous where id_docteur=$idAd and status='confirme'"));
			$termine = mysqli_num_rows(mysqli_query($connect, "SELECT * from rendez_vous where id_docteur=$idAd and status='termine'"));


		?>
			<div class="col-xl-6 col-xxl-5 d-flex" style="width: 100%;">
				<div class="w-100">
					<div class="row">
						<div class="col-sm-6">
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col mt-0">
											<h5 class="card-title">Total des rendez-vous</h5>
										</div>

										<div class="col-auto">
											<div class="stat text-primary">
												<i class="fa fa-hospital-user align-middle"></i>
											</div>
										</div>
									</div>
									<h1 class="mt-1 mb-3"><?php echo $total ?></h1>

								</div>
							</div>
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col mt-0">
											<h5 class="card-title">Rendez-vous confirme</h5>
										</div>

										<div class="col-auto">
											<div class="stat text-primary">
												<i style="color:limegreen" class="fa fa-calendar-check align-middle"></i>
											</div>
										</div>
									</div>
									<h1 class="mt-1 mb-3" style=""><?php echo $confirme; ?></h1>

								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col mt-0">
											<h5 class="card-title">Rendez-vous en attente</h5>
										</div>

										<div class="col-auto">
											<div class="stat text-primary">
												<i style="color:orange" class="fa fa-spinner align-middle"></i>
											</div>
										</div>
									</div>
									<h1 class="mt-1 mb-3"><?php echo $enattente ?></h1>

								</div>
							</div>
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col mt-0">
											<h5 class="card-title">Rendez-vous terminés</h5>
										</div>

										<div class="col-auto">
											<div class="stat text-primary">
												<i style="color:limegreen" class="fa fa-check align-middle"></i>
											</div>
										</div>
									</div>
									<h1 class="mt-1 mb-3"><?php echo $termine ?></h1>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>


	<?php
} else {
	redirect("./index");
}

	?>