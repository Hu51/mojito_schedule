<!-- login form -->
<div class="col-6">
	<form method="post" action="" class="mt-2" enctype="multipart/form-data">
		<h2>Régi feltöltése</h2>
		<div class="form-group">
			<input type="file" accept="application/json" name="jsonfile">
			<button type="submit" class="btn btn-primary" name="initType" value="restore">Feltölt</button>
		</div>
	</form>
	<hr>
	<form method="post" action="" class="mt-2" enctype="multipart/form-data">
		<h2>Új esemény</h2>
		<div class="form-group">
			<label for="name">Esemény neve</label>
			<input type="text" class="form-control" id="name" name="name" placeholder="Esemény neve" required>
		</div>
		<div class="form-group">
			<label for="url">Esemény URL</label>
			<input type="url" class="form-control" id="url" name="url" placeholder="Esemény URL" required>
		</div>

		<div class="form-group">
			<label for="fromDate">Kezdő dátum</label>
			<input type="date" class="form-control" name="fromDate" required>
		</div>

		<div class="form-group">
			<label for="days">Napok száma</label>
			<input type="number" class="form-control" name="days" min="1" value="3" required>
		</div>

		<div class="form-group">
			<label for="rooms">Termek száma</label>
			<input type="number" class="form-control" name="rooms" value="3" required>
		</div>

		<button type="submit" class="btn btn-primary" name="initType" value="new">Új esemény létrehozása</button>


	</form>
</div>
