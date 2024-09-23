	<?php
	require_once __DIR__ . '/../../config.php';
	include_once('header.php');
	include_once('conexion.php');
	include_once('Verificar_Sesion.php');

	?>
	<div class="main-container">
		<?php include_once('menu.php'); ?>
		<div class="content-wrapper-scroll">
			<div class="main-header d-flex align-items-center justify-content-between position-relative">
				<div class="d-flex align-items-center justify-content-center">
					<div class="page-icon">
						<i class="bi bi-house"></i>
					</div>
					<div class="page-title d-none d-md-block">
						<h5>Bienvenido, <?php echo $_SESSION['Usuario']; ?></h5>
					</div>
				</div>
			</div>
			<div class="content-wrapper">
				<div class="row gx-3">
					<div class="col-sm-12 col-12">
						<div class="card">
							<div class="card-header">
								<div class="card-title">Recurso Registrados</div>
								<button type="button" class="btn btn-success float-end bi bi-folder-plus" data-bs-toggle="modal" data-bs-target="#ModalCrear">
									Crear Recurso
								</button>
							</div>
							<div class="card-body">
								<div class="table-responsive">

									<table id="TablaRecursos" class="table custom-table">
										<thead>
											<tr>
												<th>Titulo</th>
												<th>Descripcion</th>
												<th>Departamento</th>
												<th>Ubicacion</th>
												<th>Opciones</th>
											</tr>
										</thead>
										<tbody>

										</tbody>

									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal Editar -->
		<div class="modal fade" id="ModalEditar" tabindex="-1" aria-labelledby="ModalEditar" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title h4" id="ModalEditar">
							Modificar Recurso
						</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form id="editar">
						<div class="modal-body">
							<div class="row">
								<div class="col-md-12">
									<label class="form-label">Titulo</label>
									<input type="text" class="form-control" id="titulo_edit" name="titulo_edit" required />
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<label class="form-label">Descripcion</label>
									<textarea class="form-control" rows="3" id="descripcion_edit" name="descripcion_edit"></textarea>

								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<label for="formFile" class="form-label">Recurso</label>
									<input class="form-control" type="file" id="recurso_edit" name="recurso_edit" />
								</div>
							</div>
						</div>

						<div class="modal-footer">
							<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
								Cancelar
							</button>
							<button type="submit" id="btnModificar" class="btn btn-success">
								Modificar
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<!-- Modal Crear -->
		<div class="modal fade" id="ModalCrear" tabindex="-1" aria-labelledby="ModalCrear" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title h4" id="ModalCrear">
							Cargar Recurso
						</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form id="crear">
						<div class="modal-body">
							<div class="row">
								<div class="col-md-12">
									<label class="form-label">Titulo</label>
									<input type="text" class="form-control" id="titulo" name="titulo" required />
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<label class="form-label">Descripcion</label>
									<textarea class="form-control" rows="3" id="descripcion" name="descripcion"></textarea>

								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<label for="formFile" class="form-label">Recurso</label>
									<input class="form-control" type="file" id="recurso" name="recurso" />
								</div>
							</div>
						</div>

						<div class="modal-footer">
							<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
								Cancelar
							</button>
							<button type="submit" id="btnCrear" class="btn btn-success">
								Crear
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<!-- App Footer start -->
		<div class="app-footer">
			<span>Desarrollado por Keisha Sanchez & Edicson Gonzalez 2023</span>
		</div>
		<!-- App footer end -->
	</div>
	<?php
	include_once('footer.php');
	?>
	<script>
		const MAXIMUM_FILE_SIZE_IN_MEGABYTES = <?= MAXIMUM_FILE_SIZE_IN_MEGABYTES ?>;
	</script>
	<script src="js/recursos.js"></script>